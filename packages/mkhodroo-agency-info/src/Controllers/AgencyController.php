<?php

namespace Mkhodroo\AgencyInfo\Controllers;

use App\Http\Controllers\Controller;
use App\Repository\RGenCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\AgencyInfo\Requests\AgencyInfoRequest;

class AgencyController extends Controller
{
    public static function docDir($id, $type = "fin")
    {
        $prefix = "user_docs";
        $user_dir = $prefix . "/u_" . $id . "/";

        //create user directory
        $full_path = public_path($user_dir);
        if (!is_dir($full_path)) {
            mkdir($full_path);
        }

        if ($type === 'doc') {
            return $user_dir . config('agency_info.doc_uploads');
        }
        if ($type === 'fin') {
            return $user_dir . config('agency_info.fin_uploads');
        }
        if ($type === 'ins') {
            return $user_dir . config('agency_info.ins_uploads');
        }
    }

    public static function view($parent_id)
    {
        $agency_fields =  AgencyInfo::where('parent_id', $parent_id)->get();
        return view('AgencyView::edit')->with(['agency_fields' => $agency_fields]);
    }

    public static function edit(Request $r)
    {
        $agency_fields =  AgencyInfo::where('parent_id', $r->id)->get();
        $data = $r->except('id');
        foreach ($data as $key => $value) {
            $row = $agency_fields->where('key', $key)->first();
            if ($row) {
                $row->update([
                    'value' => str_replace(',', '', $value)
                ]);
            } else {
                $row = new AgencyInfo();
                $row->key = $key;
                $row->value = str_replace(',', '', $value);
                $row->parent_id = $r->id;
                $row->save();
            }
        }
        return $agency_fields->first();
    }

    public static function finEdit(Request $r)
    {
        $agency_fields =  AgencyInfo::where('parent_id', $r->id)->get();
        $data = $r->except('id');
        foreach ($data as $key => $value) {
            //files
            if (gettype($r->$key) === 'object') {
                $value = FileController::store($r->file($key), self::docDir($r->id, 'fin'));
                if ($value['status'] !== 200) {
                    return response($value['message'], $value['status']);
                } else {
                    $value = $value['dir'];
                }
            }
            $row = $agency_fields->where('key', $key)->first();
            if ($row) {
                $row->update([
                    'value' => str_replace(',', '', $value)
                ]);
            } else {
                $row = new AgencyInfo();
                $row->key = $key;
                $row->value = str_replace(',', '', $value);
                $row->parent_id = $r->id;
                $row->save();
            }
        }
        return $agency_fields->first();
        // return view('AgencyView::edit')->with([ 'agency_fields' => $agency_fields ]);
    }

    public static function InspectionEdit(Request $r)
    {
        $agency_fields =  AgencyInfo::where('parent_id', $r->id)->get();
        $data = $r->except('id');
        foreach ($data as $key => $value) {
            //files
            if (gettype($r->$key) === 'object') {
                $value = FileController::store($r->file($key), self::docDir($r->id, 'ins'));
                if ($value['status'] !== 200) {
                    return response($value['message'], $value['status']);
                } else {
                    $value = $value['dir'];
                }
            }
            $row = $agency_fields->where('key', $key)->first();
            if ($row) {
                $row->update([
                    'value' => str_replace(',', '', $value)
                ]);
            } else {
                $row = new AgencyInfo();
                $row->key = $key;
                $row->value = str_replace(',', '', $value);
                $row->parent_id = $r->id;
                $row->save();
            }
        }
        return $agency_fields->first();
        // return view('AgencyView::edit')->with([ 'agency_fields' => $agency_fields ]);
    }

    public static function foremanEdit(Request $r)
    {
        $agency_fields =  AgencyInfo::where('parent_id', $r->id)->get();

        $data = $r->except('id');
        foreach ($data as $key => $value) {
            //files
            if (gettype($r->$key) === 'object') {
                $value = FileController::store($r->file($key));
                if ($value['status'] !== 200) {
                    return response($value['message'], $value['status']);
                } else {
                    $value = $value['dir'];
                }
            }
            $row = $agency_fields->where('key', $key)->first();
            if ($row) {
                $row->update([
                    'value' => str_replace(',', '', $value)
                ]);
            } else {
                $row = new AgencyInfo();
                $row->key = $key;
                $row->value = str_replace(',', '', $value);
                $row->parent_id = $r->id;
                $row->save();
            }
        }
        return $agency_fields->first();
        // return view('AgencyView::edit')->with([ 'agency_fields' => $agency_fields ]);
    }

    public static function create($parent_id, $key, $value, $des = null)
    {
        AgencyInfo::updateOrCreate(
            [
                'key' => $key,
                'parent_id' => $parent_id,
            ],
            [
                'value' => $value,
                'description' => $des
            ]
        );
    }

    public static function deleteByKey(Request $r)
    {
        $row = GetAgencyController::getByKey($r->parent_id, $r->key);
        $row->delete();
        return $row;
    }

    public static function getAgencyFieldsByParentId($parent_id)
    {
        return AgencyInfo::where('parent_id', $parent_id)->get();
    }

    public static function codeGenerator(Request $request)
    {

        $type = $request->customer_type;
        $province = $request->city;

        $exists = DB::table('agency_info as a1')
            ->join('agency_info as a2', function ($join) {
                $join->on('a1.parent_id', '=', 'a2.parent_id')        // رکوردها باید متعلق به یک مرکز باشند
                    ->where('a1.key', 'national_id')          // ستون key در a1 باید national_code باشد
                    ->where('a2.key', 'postal_code');           // ستون key در a2 باید postal_code باشد
            })
            ->where('a1.value', $request->national_id)  // مقدار کد ملی
            ->where('a2.value', $request->postal_code)    // مقدار کد پستی
            ->exists();

        if (!$province) {
            return response(trans("Province is not set"), 300);
        }
        $a = new RGenCode($province, $type);
        if ($type === 'agency')
            $agency_code = $a->Markaz();
        if ($type === 'hidrostatic')
            $agency_code = $a->Hidro();
        if ($type === 'low-pressure')
            $agency_code = $a->Kamfeshar();

        if (AgencyInfo::where('key', 'agency_code')->where('value', $agency_code)->first()) {
            return response(trans("Unfortunately Generated Code Is Not Unique. Contact Support"), 300);
        }

        if ($exists) {
            return response()->json([
                'msg' => "هشدار : با این کد ملی و کد پستی قبلا مرکزی ثبت شده است \n کد جدید : $agency_code"
            ]);
        } else {
            return response()->json([
                'msg' => $agency_code
            ]);
        }

    }
}
