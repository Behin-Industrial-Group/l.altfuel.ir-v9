<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\ArchiveModel;
use App\StatusModel;
use App\ArchiveStatusModel;
use App\ArchiveStatusBackupModel;
use App\ProvinceModel;
use App\RasteModel;
use Verta;
use App\CustomClasses\Access;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        
    }
    
    public function index()
    {
        $access = Access::check('Archive_addarchiveform');
        $Province = ProvinceModel::get();
        $Raste = RasteModel::get();
        return view('admin.addarchive', [ 'Province' => $Province , 'Raste' => $Raste ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $access = Access::check('Archive_addarchive');
        
        $name = $request->input('name');
        $nationalCode = $request->input('nationalCode');
        $province = $request->input('province');
        $raste = $request->input('raste');
        $No = $request->input('ID');
        $cellphone = $request->input('cellphone');

        $No = ArchiveModel::where('ostan' , $province)->get();
        $No = $No->count() +1;

        $insert = ArchiveModel::create([
            'name' => $name,
            'codemeli' => $nationalCode,
            'ostan' => $province, 
            'No' => $No,
            'raste' => $raste,
            'cellphone' => $cellphone
        ]);

        if( $insert )
        {
            $message = "$No - $province - ثبت شد";
            $Province = ProvinceModel::get();
            $Raste = RasteModel::get();
            return view('admin.addarchive', [ 
                'message' => $message,
                'Province' => $Province,
                'Raste' => $Raste ]);
        }
    }

    public function addstatusform()
    {
        $access = Access::check('Archive_addstatusform');
        //return var_dump($access);
        $archive = ArchiveModel::get();
        $status = StatusModel::orderby('status')->get();
        return view('admin.addstatus', [
            'Archive' => $archive,
            'Status' => $status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addstatus(Request $request)
    {
        $access = Access::check('Archive_addstatus');
        
        
        $archive_id = $request->input('archive_id');
        $Status_id = $request->input('Status_id');
        $Date = Verta();
        
        $status = StatusModel::where('id', $Status_id)->first();

        //$row = ArchiveStatusModel::join('status' ,'ArchiveStatus.Status_id', 'status.id')->where('ArchiveStatus.archive_id', $archive_id)->where('status.catagory', $status->catagory)->first();
        $row = ArchiveStatusModel::where('archive_id' , $archive_id)->first();
        if(!empty($row->ID))
        {
            ArchiveStatusModel::where('archive_id', $archive_id)->update( [
                                                        'Status_id' => $Status_id,
                                                        'Date' => $Date
                                                        ] );
                
            ArchiveStatusBackupModel::create( [
                'archive_id' => $archive_id,
                'Status_id' => $Status_id,
                'Date' => $Date
                ] );
            $message = "وضعیت ثبت شد";
        }
        else
        {
            ArchiveStatusModel::create( [
                                'archive_id' => $archive_id,
                                'Status_id' => $Status_id,
                                'Date' => $Date
                                ] );
                
            ArchiveStatusBackupModel::create( [
                'archive_id' => $archive_id,
                'Status_id' => $Status_id,
                'Date' => $Date
                ] );
            $message = "وضعیت ثبت شد";
        }
        $archive = ArchiveModel::get();
            $status = StatusModel::orderby('status')->get();
            return view('admin.addstatus', [
            'Archive' => $archive,
            'Status' => $status,
            'Message' => $message
            ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
