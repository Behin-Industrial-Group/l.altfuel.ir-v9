<?php

namespace Behin\Hamayesh\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Behin\Hamayesh\Imports\ParticipantsImport;
use Behin\Hamayesh\Models\EventParticipant;
use ExcelReader\Controllers\ExcelReader;
use Illuminate\Support\Facades\DB;

class EventVerificationController extends Controller
{
    public function importForm($eventId)
    {
        return view('event-verification::import', compact('eventId'));
    }

    public function import(Request $request, $eventId)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        if ($xlsx = ExcelReader::parse($file->getPathname())) {

            $header = $xlsx->rows()[0];

            $i = 0;
            foreach ($xlsx->rows() as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                $data = array_combine($header, $row);
                $data = self::headerRenameAndFilter($data);
                $table = DB::table("event_{$eventId}_participants");

                if ($table->where('ticket_id', $data['ticket_id'])->exists()) {
                    // return response("کاربر با شناسه {$data['user_id']} قبلا در سیستم ثبت شده است", 400);
                }else{
                    $eventParticipant = $table->insert([
                        'ticket_id' => (string)trim($data['ticket_id']),
                        'user_id' => (string)trim($data['user_id']),
                        'first_name' => (string)trim($data['first_name']),
                        'last_name' => (string)trim($data['last_name']),
                        'username' => (string)trim($data['username']),
                        'national_code' => (string)trim($data['national_code']),
                        'ticket' => (string)trim($data['ticket']),
                        'role' => (string)trim($data['role']),
                        'type' => (string)trim($data['type']),
                        'status' => (string)trim($data['status']),
                        'mobile' => (string)trim($data['mobile'])
                    ]);
                }

                $i++;
            }

            return response("تعداد $i ردیف ذخیره شد", 200);
        } else {
            $msg = ExcelReader::parseError();
            return response($msg, 400);
        }
    

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public static function headerRenameAndFilter($array)
    {

        $keysToRename = [
            'نام' => 'first_name',
            'نام خانوادگی' => 'last_name',
            'نام کاربری' => 'username',
            'شناسه' => 'ticket_id',
            'شناسه کاربری' => 'user_id',
            'بلیت' => 'ticket',
            'نقش' => 'role',
            'نوع' => 'type',
            'وضعیت' => 'status',
            'کد ملی' => 'national_code',
            'موبایل' => 'mobile'
        ];

        $result = [];

        foreach ($keysToRename as $oldKey => $newKey) {
            if (array_key_exists($oldKey, $array)) {
                $result[$newKey] = $array[$oldKey];
            }
        }

        return $result;
    }

    public function verificationForm($eventId)
    {
        return view('event-verification::verify', compact('eventId'));
    }

    public function verify(Request $request, $eventId)
    {
        // $request->validate([
        //     'national_code' => 'string',
        //     'qr_code' => 'string',
        // ]);

        $table = DB::table("event_{$eventId}_participants");

        if($request->qr_code){
            $qrCode = explode('/', $request->qr_code);
            if(
                $qrCode[0] == 'https:' &&
                $qrCode[1] == '' &&
                $qrCode[2] == 'behinlms.com' &&
                $qrCode[3] == 'event' &&
                $qrCode[4] == 'enrollment' &&
                $qrCode[5] == 'validate' &&
                count($qrCode) == 8
            ){
                $ticket_id = $qrCode[6];
                $participant = $table->where('ticket_id', $ticket_id);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR code معتبر نیست.',
                ], 400);
            }
        }

        if($request->national_code){
            $participant = $table->where('national_code', $request->national_code);
        }



        if (!$participant->first()) {
            return response()->json([
                'status' => 'error',
                'message' => 'شرکت کننده پیدا نشد',
            ], 400);
        }

        if($participant->first()->is_verified){
            return response()->json([
                'status' => 'error',
                'message' => 'شرکت کننده قبلا پذیرش شده است'
            ], 400);
        }


        $participant->update([
            'is_verified' => true,
            'verified_by' => auth()->id() . ' ' . auth()->user()->name,
            'verified_at' => now(),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'پذیرش شرکت کننده با موفقیت انجام شد',
        ], 200);
    }

    public function register(Request $request, $eventId)
    {
        $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'mobile' => 'string',
            'national_code' => 'string',
        ]);
        $table = DB::table("event_{$eventId}_participants");

        if ($table->where('national_code', $request->national_code)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'شرکت کننده قبلا ثبت شده است',
            ], 400);
        }

        $table->insert([
            'first_name' => (string)trim($request->first_name),
            'last_name' => (string)trim($request->last_name),
            'national_code' => (string)trim($request->national_code),
            'mobile' => (string)trim($request->mobile),
            'is_verified' => true,
            'verified_by' => auth()->id() . ' ' . auth()->user()->name,
            'verified_at' => now(),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'شرکت کننده با موفقیت ثبت شد',
        ], 200);
    }
}