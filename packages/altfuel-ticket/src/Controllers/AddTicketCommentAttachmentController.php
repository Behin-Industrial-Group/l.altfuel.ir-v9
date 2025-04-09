<?php

namespace Mkhodroo\AltfuelTicket\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\AltfuelTicket\Models\CommentAttachments;
use Mkhodroo\AltfuelTicket\Models\Ticket;
use Mkhodroo\AltfuelTicket\Models\TicketComment;
use ZipArchive;

class AddTicketCommentAttachmentController extends Controller
{
    
    public static function add($comment_id , $file){
        return CommentAttachments::create([
            'comment_id' => $comment_id,
            'file' => $file
        ]);
    }

    public function downloadZip(Request $request)
    {

        $commentIds = TicketComment::where('ticket_id', $request->id)->pluck('id');
        $files = CommentAttachments::whereIn('comment_id', $commentIds)->pluck('file');

        if (count($files)) {
            $zipFileName = 'ticket_' . $request->id . '.zip';

            $zip = new \ZipArchive;
            $zipPath = public_path($zipFileName);

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                foreach ($files as $file) {
                    $filePath = public_path('\..\\' .$file);
                    $zip->addFile($filePath, basename($filePath));
                }

                $zip->close();
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }else{
            return response('پیوستی وجود ندارد', 404);
        }

    }
}
