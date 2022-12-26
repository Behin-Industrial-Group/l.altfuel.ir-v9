<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MessageModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class MessageController extends Controller
{
    private $model; 
    private $user;

    public function __construct() {
        $this->model = new MessageModel();
        $this->user = new User();
    }

    public function send($to,$message,$from = null)
    {
        if(Auth::user())
            $from = Auth::user()->id;
        if($from == null)    
            $from = 'نامشخص';

        if(is_array($to)){
            foreach($to as $to){
                MessageModel::insert([
                    'from' => $from,
                    'to' => $to,
                    'message' => $message,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }else{
            MessageModel::insert([
                'from' => $from,
                'to' => $to,
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        
    }

    public function list(Request $request)
    {
        $messages = $this->model->leftjoin('users as u', 'u.id','messages.from')
            ->where('to', Auth::user()->id)
            ->orderBy('messages.id', 'desc')
            ->select('messages.*', 'u.display_name')->get();
        
        return view('admin.messages.list')->with(['messages'=> $messages]);
    }

    public function show($id)
    {
        $message = $this->model->leftjoin('users as u', 'u.id', 'messages.from')
            ->where('messages.id',$id)
            ->where('to', Auth::user()->id)
            ->select('messages.*', 'u.display_name')
            ->first();
        $message->status = 'read';
        $message->save();
        return view('admin.messages.show')->with(['message'=> $message]);
    }

    public function numberOfUnread()
    {
        return $this->model->where('to', Auth::user()->id)->where('status', 'new')->count();
    }
}
