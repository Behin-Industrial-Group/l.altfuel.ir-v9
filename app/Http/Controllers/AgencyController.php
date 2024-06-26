<?php

namespace App\Http\Controllers;

use App\CustomClasses\Access;
use App\Http\Controllers\Controller;
use App\Interfaces\FinanceServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{
    private $finServiceInterface;
    public function __construct(FinanceServiceInterface $finServiceInterface) {
        $this->finServiceInterface = $finServiceInterface;
    }

    public function listForm()
    {
        return view('admin.agencies.list');
    }
    public function get($table_name, $agency_id)
    {
        return DB::table($table_name)->find($agency_id);
    }

    public function editForm(Request $r)
    {
        $agency_config = $this->getAgencyConfigByName($r->agency_name);
        Access::check($agency_config['table'] . "-edit-form");
        return view('admin.agencies.edit', [
            'agency' => $this->get($agency_config['table'], $r->agency_id),
            'agency_config' => $agency_config
        ]);
    }

    public function edit(Request $r)
    {
        Access::check($r->agency_table . "-edit");
        $data = $r->except(['agency_table']);
        $data['enable'] = $r->enable ? 1 : 0;
        $data['InsUserDelivered'] = $r->InsUserDelivered ? 'ok' : 'not ok';
        return DB::table($r->agency_table)->where('id', $r->id)->update($data);
    }

    public function list(Request $r, $table_name = null)
    { 
        if($r->agency_name){
            $agency_config = $this->getAgencyConfigByName($r->agency_name);
            $table_name = $agency_config['table'];
        }
        if(!$table_name){
            return [
                'data' => []
            ];
        }
        Access::check($agency_config['table'] . "-list");
        return DB::table($table_name)->get()->each(function($row) use( $agency_config){
            $row->fin_info = $this->finServiceInterface->getFinInfo($agency_config['table'], $row->id); 
        });
    }

    public function getAgencyConfigByName($agency_name)
    {
        return config("app.agencies.$agency_name");
    }

    public function addForm()
    {
        return view('admin.agencies.add');
    }

    public function add(Request $r)
    {
        Access::check($r->agency_table . "-add");
        return DB::table($r->agency_table)->insert($r->only('Name'));
    }
}
