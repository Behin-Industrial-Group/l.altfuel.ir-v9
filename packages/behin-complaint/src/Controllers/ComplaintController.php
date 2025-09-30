<?php

namespace Behin\Compliant\Controllers;

use App\Http\Controllers\Controller;
use Behin\Complaint\Mail\ComplaintSubmitted;
use Behin\Compliant\Models\Complaint;
use FileService\Controllers\FileServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mkhodroo\AgencyInfo\Controllers\FileController;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('ComplaintViews::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name_last_name' => 'required|string|max:255',
            'national_code' => 'required|string|size:10',
            'mobile' => 'required|string|size:11',
            'vin' => 'nullable|string|max:50',
            'business_name' => 'required|string|max:255',
            'manager_name' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'center_type' => 'required|string|max:255',
            'complaint_subject' => 'required|string|max:255',
            'visit_date' => 'required',
            'description' => 'nullable|string',
        ]);
        $data = $request->except('_token');
        $attachment = null;

        if($request->file('file'))
        {
            $filePath = FileController::store($request->file('file'), 'complaint');
            if($filePath['status'] == 200)
            {
                $data['file'] = $filePath['dir'];
                $attachment = public_path($filePath['dir']);
            }
            else
            {
                return redirect()->back()->withErrors(['file' => trans($filePath['message'])]);
            }
        }



        Complaint::create([
            'content' => json_encode($data)
        ]);

        Mail::to('info@altfuel.ir')->send(new ComplaintSubmitted($data, $attachment));

        return redirect()->route('complaint.create')->with('success', 'شکایت با موفقیت ثبت شد');
    }

    public function list()
    {
        $complaints = Complaint::get();
        return view('ComplaintViews::list')->with([
            'complaints' => $complaints
        ]);
    }
}
