<?php

namespace IsoAgent\Controllers;

use App\Http\Controllers\Controller;
use IsoAgent\Models\LangflowMessage;
use Illuminate\Http\Request;

class IsoAgentController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $messages = LangflowMessage::where('user_id', $userId)->get();
        return view('IsoAgentViews::index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $langflowController = new LangflowIsoController();
        $response = $langflowController->run($request->message);
        dd($response);

        // ذخیره سوال و پاسخ در پایگاه داده
        $this->saveMessageToDatabase($request->message, $response, $request->user_id);

        return response([
            'response' => $response
        ], 200);
    }

    private function saveMessageToDatabase($message, $response, $userId)
    {
        // کد برای ذخیره‌سازی در پایگاه داده
        LangflowMessage::create([
            'message' => $message,
            'response' => $response,
            'user_id' => $userId,
        ]);
    }



}
