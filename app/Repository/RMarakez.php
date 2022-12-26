<?php
namespace App\Repository;

use App\Models\MarakezModel;
use App\Models\PelakkhanModel;
use App\CustomClasses\BarcodeQR;

class RMarakez
{
    protected $model;
    protected $pelakkhan;

    public function __construct()
    {
        $this->model = new MarakezModel();
        $this->pelakkhan = new PelakkhanModel();
    }


    public function EditPelakkhanValue($request)
    {
        try{
            $markaz = $this->model->find($request->id);
            $row = $this->pelakkhan->where('CodeEtehadie', $markaz->CodeEtehadie)->first();
    
            if(is_null($row)){
                $row =  $this->pelakkhan;
                $row->CodeEtehadie = $markaz->CodeEtehadie;
            }
    
            //create qr image
            if(!is_null($this->createqr($row)))
                return $this->createqr($row);
    
            //update
            $file = $request->file( 'DeliveryReceipts' );
            if( !empty($file) )
            {
                $file_type = strtolower($file->getClientOriginalExtension());
                if($file->getSize() > 300000)
                {
                    return 'حجم فایل بیش از 300 کیلو بایت است';
                }
            
                if($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg')
                {
                    $path = 'public/marakez/' . $row->CodeEtehadie ;
                    $filename = rand(10000,99999). "." . strtolower($file->getClientOriginalExtension());
                    $row->DeliveryReceipts = $path .'/'. $filename ;
                    $file->move( $path, $filename );
                }else
                {
                    return 'فقط فرمت jpg / png / jpeg';
                }
            }
            $row->Receiver = $request->Receiver;
            $row->Batch = $request->Batch;
            $row->PlateReader = $request->PlateReader;
            $row->Receiver = $request->Receiver;
            $row->save();
            
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function createqr($row)
    {
        try{
            $qr = new BarcodeQR();

            if(!$row)
            {
                return 'یافت نشد. ابتدا افزودن بارکد را بزنید';
            }
    
            if(empty($row->code)){
                $code = $row->CodeEtehadie * rand(1000,9999);
                PelakkhanModel::where('CodeEtehadie', $row->id)->update([ 'code' => $code ]);
                $row->refresh();
            }
    
            $qr->url("http://altfuel.ir/pelakkhan/?code=$row->code");
            $qr->draw(75,"public/qrimages/$row->CodeEtehadie");
        }
        catch(Exception $e){
            return $e->getMessage();
        }       
        
    }
}