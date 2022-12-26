<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\ContractorsModel;
use App\ProvinceModel;
use App\CustomClasses\Access;
use File;

class ContractorsController extends Controller
{
    public function index()
    {
        $Marakez = ContractorsModel::orderBy('id')->get();
        return view('admin.contractors.contractors', [
            'Marakez' => $Marakez,
        ]);
    }

    public function show($id)
    {
        $markaz = ContractorsModel::where('id', $id)->first();

        return view('admin.contractors.editcontractors', [
            'markaz' => $markaz
        ]);
    }

    public function edit(Request $r, $id)
    {
        
        
        $markaz = ContractorsModel::find($id);

        if( $r->input('FormType') == 'SodurForm' ){
            if(Gate::allows('Level1') ):
            else:
                abort(403);
            endif;
            $contractors = ContractorsModel::find($id);
            
            $contractors->name = $r->name;
            $contractors->nationalId = $r->nationalId;
            $contractors->phone = $r->phone;
            $contractors->address = $r->address;

            
            if($hidro->save()){
                $contractors->refresh();
                $message = "ویرایش شد.";
                return view('admin.contractors.editcontractors', [
                    'message' => $message,
                    'markaz' => $contractors
                ]);
            }else{
                $error = "ناموفق";
                return view('admin.contractors.editcontractors', [
                    'error' => $error,
                    'markaz' => $contractors
                ]);
            }
        }
        
    }
    
    public function addform()
    {
        Access::check('Hidro_addform');
        
        $Provinces = ContractorsModel::get();
        return view('admin.contractors.addcontractors');
    }
    
    public function addmarkaz(Request $request)
    {
        Access::check('Hidro_addmarkaz');
        
        $markaz = new ContractorsModel($request->all());
        $markaz->save();

        $message = "ثبت شد.";
        return view('admin.contractors.addcontractors', [  'message' => $message ]);

    }
    
    public function createApi()
    {
        $contractors = ContractorsModel::whereNotNull( 'name' )->get();
        
        return $contractors;
    }
}
