<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\PelakkhanModel;
use File;

class QrController extends Controller
{
    
    public function get($id)
    {
        $info = PelakkhanModel::find($id);
        return $info;
    }
    
    public function index()
    {
        return view('admin.addqr');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createqrform()
    {
        return view('admin.createqr');
    }

    public function createqr(Request $request)
    {
        $qr = new BarcodeQR();

        $id = $request->input('code');

        $row = PelakkhanModel::where('CodeEtehadie', $id)->first();

        if(!$row)
        {
            $message = 'یافت نشد. ابتدا افزودن بارکد را بزنید';
            return view('admin.createqr', [ 'error' => $message ]);
        }

        if(empty($row->code)){
            $code = $row->CodeEtehadie * rand(1000,9999);
            PelakkhanModel::where('CodeEtehadie', $id)->update([ 'code' => $code ]);
            $row->refresh();
        }

        $qr->url("http://altfuel.ir/pelakkhan/?code=$row->code");
        $qr->draw(75,"public/qrimages/$row->CodeEtehadie");

        $message = 'ایجاد شد.';
        return view('admin.createqr', [ 'message' => $message ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $code = $request->input('CodeEtehadie');
        $receiver = $request->input('Receiver');
        $batch = $request->input('BatchNo');

        $insert = PelakkhanModel::create([
            'CodeEtehadie' => $code,
            'Receiver' => $receiver,
            'Batch' => $batch,
        ]);

        if($insert)
        {
            $message = 'ثبت شد';
            return view('admin.addqr', [ 'message' => $message ]);
        }else{
            $error = 'خطا در ثبت اطلاعات';
            return view('admin.addqr', [ 'error' => $error ]);
        }

        
    }

    public function printqr()
    {
        $rows = PelakkhanModel::orderby('pelakkhan.CodeEtehadie')->get();

        return view('admin.printqr', [ 'rows' => $rows ]);
    }
    
    public function editform($id, $error = null, $message = null)
    {
        $info = $this->get($id);
        return view('admin.editqr')->with([ 'info' => $info, 'message' => $message, 'error' => $error ]);
    }
    
    public function edit(Request $request, $id)
    {
        $obj = PelakkhanModel::find($id);
        
        $obj->CodeEtehadie = $request->CodeEtehadie;
        $obj->Receiver = $request->Receiver;
        $obj->PlateReader = $request->PlateReader;
        
        $file = $request->file( 'DeliveryReceipts' );
        if( !empty($file) )
        {
            $file_type = strtolower($file->getClientOriginalExtension());
            if($file->getSize() > 300000)
	        {
	            $error = 'حجم فایل بیش از 300 کیلو بایت است';
	            return $this->editform($id,$error);
	        }
        
            if($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg')
            {
                $path = 'public/marakez/' . $request->input('CodeEtehadie') ;
                $filename = rand(10000,99999). "." . strtolower($file->getClientOriginalExtension());
                $obj->DeliveryReceipts = $path .'/'. $filename ;
                if(file_exists($path))
	            {
	
	            }else{
	                File::makeDirectory( $path,0777,true );
	            }
                $file->move( $path, $filename );
                $obj->save();
                return $this->editform($id);
            }else
            {
                $error = 'فقط فرمت jpg / png / jpeg';
	            return $this->editform($id,$error);
            }
        }
        
        $obj->save();
        return $this->editform($id);
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

final class BarcodeQR {
	/**
	 * Chart API URL
	 */
	const API_CHART_URL = "http://chart.apis.google.com/chart";

	/**
	 * Code data
	 *
	 * @var string $_data
	 */
	private $_data;

	/**
	 * Bookmark code
	 *
	 * @param string $title
	 * @param string $url
	 */
	public function bookmark($title = null, $url = null) {
		$this->_data = "MEBKM:TITLE:{$title};URL:{$url};;";
	}

	/**
	 * MECARD code
	 *
	 * @param string $name
	 * @param string $address
	 * @param string $phone
	 * @param string $email
	 */
	public function contact($name = null, $address = null, $phone = null, $email = null) {
		$this->_data = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
	}

	/**
	 * Create code with GIF, JPG, etc.
	 *
	 * @param string $type
	 * @param string $size
	 * @param string $content
	 */
	public function content($type = null, $size = null, $content = null) {
		$this->_data = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
	}

	/**
	 * Generate QR code image
	 *
	 * @param int $size
	 * @param string $filename
	 * @return bool
	 */
	public function draw($size = 150, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->_data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);

		if($img) {
			if($filename) {
				if(!preg_match("#\.jpg$#i", $filename)) {
					$filename .= ".jpg";
				}
				
				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/jpg");
				print $img;
				return true;
			}
		}

		return false;
	}

	/**
	 * Email address code
	 *
	 * @param string $email
	 * @param string $subject
	 * @param string $message
	 */
	public function email($email = null, $subject = null, $message = null) {
		$this->_data = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
	}

	/**
	 * Geo location code
	 *
	 * @param string $lat
	 * @param string $lon
	 * @param string $height
	 */
	public function geo($lat = null, $lon = null, $height = null) {
		$this->_data = "GEO:{$lat},{$lon},{$height}";
	}

	/**
	 * Telephone number code
	 *
	 * @param string $phone
	 */
	public function phone($phone = null) {
		$this->_data = "TEL:{$phone}";
	}

	/**
	 * SMS code
	 *
	 * @param string $phone
	 * @param string $text
	 */
	public function sms($phone = null, $text = null) {
		$this->_data = "SMSTO:{$phone}:{$text}";
	}

	/**
	 * Text code
	 *
	 * @param string $text
	 */
	public function text($text = null) {
		$this->_data = $text;
	}

	/**
	 * URL code
	 *
	 * @param string $url
	 */
	public function url($url = null) {
		$this->_data = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
	}

	/**
	 * Wifi code
	 *
	 * @param string $type
	 * @param string $ssid
	 * @param string $password
	 */
	public function wifi($type = null, $ssid = null, $password = null) {
		$this->_data = "WIFI:S:{$ssid};T:{$type};P:{$password};;";
	}
}
