<?php

namespace ExcelReader\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mkhodroo\AgencyInfo\Controllers\AgencyController;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\Cities\Controllers\ProvinceController;

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
            $header = ExcelController::headerRenameAndFilter($header);
            // $query = DB::table('agency_info as a1')
            // ->join('agency_info as a2', function ($join) {
            //     $join->on('a1.parent_id', '=', 'a2.parent_id')
            //         ->where('a1.key', 'agency_code');
            // });
            $i = 0;
            $numberOfUpdatedRows = 0;
            $numberOfAddedRows = 0;
            $errorRows = [];
            $insertData = [];
            foreach ($xlsx->rows() as $index => $row) {
                if ($index == 0) {
                    continue;
                }

                $data = array_combine($header, $row);
                // $data = ExcelController::headerRenameAndFilter($data);

                $searchQuery = AgencyInfo::where('key', 'agency_code')->where('value', $data['agency_code'])->first();

                // $searchQuery = (clone $query)
                //     ->where('a1.value', $data['agency_code'])
                //     ->select('a1.parent_id')
                //     ->first();
                $parentId = $searchQuery?->parent_id;
                if ($parentId) {
                    foreach ($data as $key => $value) {
                        // AgencyController::create($parentId, $key, trim($value));
                        $insertData[] = [
                            'key' => $key,
                            'value' => trim($value),
                            'parent_id' => $parentId
                        ];
                    }
                    $numberOfUpdatedRows++;
                } else {
                    $errorRows[] = [ 'row' => $index+1, 'file_number' => $data['agency_code'] ];
                }
                $i++;
            }
            foreach($insertData as $row){
                AgencyController::create($row['parent_id'], $row['key'], trim($row['value']));
            }
            // AgencyInfo::upsert($insertData, ['key', 'parent_id'], ['value']);
            return response()->json([
                'msg' => "تعداد $i ردیف ذخیره شد",
                "numberOfAddedRows" => $numberOfAddedRows,
                "numberOfUpdatedRows" => $numberOfUpdatedRows,
                "errorRows" => $errorRows
            ]);
        } else {
            echo ExcelReader::parseError();
        }
    }

    public static function headerRenameAndFilter($array)
    {

        $keysToRename = [
            'کد مرکز' => 'agency_code',
            'مبلغ بدهی' => 'debt2',
            'توضیحات' => 'debt2_description',
        ];

        $result = [];
        foreach ($array as $ar) {
            if (isset($keysToRename[$ar])) {
                $result[] = $keysToRename[$ar];
            } else {
                $result[] = $ar;
            }
        }
        return $result;

        foreach ($keysToRename as $oldKey => $newKey) {
            if (array_key_exists($oldKey, $array)) {
                $result[$newKey] = $array[$oldKey];
            }
        }

        return $result;
    }
}
