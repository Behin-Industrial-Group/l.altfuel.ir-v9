<?php

namespace TodoList\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TodoList\Models\Todo;

class OthersTodoListController extends Controller
{

    public function list(Request $request){
        $tasks = Todo::where('user_id', $request->user_id)->get();
        return $tasks;
    }

    public function create(Request $request){
        $task = Todo::create([
            'creator' => Auth::id(),
            'user_id' => $request->user_id,
            'task' => $request->task,
            'description' => $request->description,
            'reminder_date' => $request->reminder_date,
            'due_date' => $request->due_date,
        ]);
    }

}
