<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mkhodroo\AltfuelTicket\Models\TicketComment;

class LangflowController extends Controller
{
    public function run(Request $request)
    {
        $lastComment = TicketComment::where('ticket_id', $request->ticket_id)->orderBy('id', 'desc')->first();
        // return response()->json(['message' => $lastComment->text]);
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . 'NefmcszgGgzjPsmBbyUGaSra:6a543b5db7f883861cee2b0926451700b5d973b21d06127cea6fe25e223e6c3f',
        ])->post('https://api.langflow.astra.datastax.com/lf/f52522a6-cf86-4c2b-867b-b619da53ddee/api/v1/run/f1540628-e150-4805-be8a-59111e1852c1?stream=false', [
            'input_value' => $lastComment->text,
            'output_type' => 'chat',
            'input_type' => 'chat',
            'tweaks' => [
                'ChatInput-S6pVj' => [],
                'ParseData-RKLei' => [],
                'Prompt-ipfvP' => [],
                'SplitText-9KAvp' => [],
                'ChatOutput-dUVEn' => [],
                'AstraDB-y5TS6' => [],
                'AstraDB-LYPfX' => [],
                'File-q7DuD' => [],
                'GroqModel-LutP7' => [],
                'CohereEmbeddings-jUybi' => [],
                'CohereEmbeddings-2MzXP' => [],
            ],
        ]);

        return $response->json();
    }
}
