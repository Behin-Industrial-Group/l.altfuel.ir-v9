<?php

namespace App\Services;

use App\CustomClasses\Access;
use App\Interfaces\FinanceServiceInterface;
use App\Models\FinInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FinanceService implements FinanceServiceInterface
{
    protected $finInfo;

    public function __construct(FinInfo $finInfo)
    {
        $this->finInfo = $finInfo;
    }

    public function createFinInfo(array $data)
    {
        return $this->finInfo->create($data);
    }

    public function getFinInfo(string $agency_type, int $agency_id)
    {
        return $this->finInfo
            ->where('agency_table', $agency_type)
            ->where('agency_id', $agency_id)
            ->get();
    }

    public function updateFinInfo(string $agency, int $agency_id, object $request)
    {
        Access::check(config("app.agencies.$agency.table") . "-edit-fin-info");
        $this->updateAgencyFinInfo($agency, $agency_id, $request);
        $agency_table = config("app.agencies.$agency.table");
        $agency_payment = "app.agencies." . $agency . ".payment" ; 
        foreach(config($agency_payment) as $p){
            $name = $p['name'];
            $this->finInfo->updateOrCreate(
                [
                    'agency_table' => $agency_table,
                    'agency_id' => $agency_id,
                    'name' => $name
                ],
                [
                    'price' => str_replace(",", "", $request->$name['price']) ,
                    'pay_date' => $request->$name['pay_date'],
                    'ref_id' => $request->$name['ref_id'],
                ]
                );
        }

        $agency_extra_payment = "app.agencies.$agency.extra-payment";
        foreach(config($agency_extra_payment) as $p){
            $name = $p['name'];
            $this->finInfo->updateOrCreate(
                [
                    'agency_table' => $agency_table,
                    'agency_id' => $agency_id,
                    'name' => $name
                ],
                [
                    'price' => str_replace(",", "", $request->$name['price']) ,
                    'pay_date' => $request->$name['pay_date'],
                    'ref_id' => $request->$name['ref_id'],
                ]
                );
        }
    }

    public function updateAgencyFinInfo(string $agency, int $agency_id, object $r)
    {
        $agency_table = config("app.agencies.$agency.table");
        $data = $r->only(['debt', 'debt_description', 'FinGreen', 'FinDetails']);
        $data['FinGreen'] = ($r->FinGreen) ? 'ok' : 'not ok';
        $data['debt'] = str_replace(",", "", $r->debt); 
        return DB::table($agency_table)->where('id',$agency_id)->update($data);
    }

    public function deleteFinInfo(int $id)
    {
        $this->finInfo->findOrFail($id)->delete();
    }
}
