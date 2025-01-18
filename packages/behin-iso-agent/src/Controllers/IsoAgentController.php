<?php

namespace IsoAgent\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LangflowMessage;
use Illuminate\Http\Request;

class IsoAgentController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        // $messages = LangflowMessage::all();
        $messages = 1;
        return view('IsoAgentViews::index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        // صدا زدن تابع run از LangflowIsoController
        $langflowController = new LangflowIsoController();
        $response = $langflowController->run($request->question);

        // ذخیره سوال و پاسخ در پایگاه داده
        $this->saveMessageToDatabase($request->question, $response, $request->user()->id);

        return $response;
    }

    private function saveMessageToDatabase($question, $response, $userId)
    {
        // کد برای ذخیره‌سازی در پایگاه داده
        LangflowMessage::create([
            'user_id' => $userId,
            'question' => $question,
            'response' => $response,
        ]);
    }



}
