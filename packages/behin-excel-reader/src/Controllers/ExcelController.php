<?php

namespace ExcelReader\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Controllers\AgencyController;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;

class ExcelController extends Controller
{
    public function input()
    {
        return view('ExcelView::input');
    }

    public static function read(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
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
                $data = ExcelController::headerRenameAndFilter($data);

                $parentId = DB::table('agency_info as a1')
                    ->join('agency_info as a2', function ($join) {
                        $join->on('a1.parent_id', '=', 'a2.parent_id')
                            ->where('a1.key', 'national_id')
                            ->where('a2.key', 'postal_code');
                    })
                    ->where('a1.value', $data['national_id'])
                    ->where('a2.value', $data['postal_code'])
                    ->select('a1.parent_id')
                    ->first()?->parent_id;

                if ($parentId) {
                    foreach ($data as $key => $value) {
                        AgencyController::create($parentId, $key, $value);
                    }
                } else {
                    $parentRecord = AgencyInfo::create(
                        [
                            'key' => 'customer_type',
                            'value' => $data['customer_type'],
                            'parent_id' => null
                        ]
                    );

                    $parentId = $parentRecord->id;

                    $parentRecord->parent_id = $parentId;
                    $parentRecord->save();

                    foreach ($data as $key => $value) {
                        if ($key !== 'customer_type') {
                            AgencyInfo::create([
                                'key' => $key,
                                'value' => $value,
                                'parent_id' => $parentId
                            ]);
                        }
                    }
                }
                $i++;
            }

            return response("تعداد $i ردیف ذخیره شد");
        } else {
            echo ExcelReader::parseError();
        }
    }

    public static function headerRenameAndFilter($array)
    {

        $keysToRename = [
            'کد ملی' => 'national_id',
            'کد پستی' => 'postal_code',
            'شماره موبایل' => 'mobile',
            'نوع مشتری' => 'customer_type'
        ];

        $result = [];

        foreach ($keysToRename as $oldKey => $newKey) {
            if (array_key_exists($oldKey, $array)) {
                $result[$newKey] = $array[$oldKey];
            }
        }

        return $result;
    }
}
