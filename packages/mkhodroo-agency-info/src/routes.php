<?php

use App\Models\FinInfo;
use App\Models\HidroModel;
use App\Models\KamFesharModel;
use App\Models\MarakezModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AgencyInfo\Controllers\AgencyController;
use Mkhodroo\AgencyInfo\Controllers\AgencyDocsController;
use Mkhodroo\AgencyInfo\Controllers\AgencyListController;
use Mkhodroo\AgencyInfo\Controllers\CreateAgencyController;
use Mkhodroo\AgencyInfo\Controllers\DebtController;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\UserRoles\Controllers\GetRoleController;
use Rap2hpoutre\FastExcel\FastExcel;

Route::name('agencyInfo.')->prefix('agency-info')->middleware(['web', 'auth'])->group(function () {
    // Route::get('import-data', function () {
    //     $marakez = MarakezModel::get();
    //     echo "<pre>";
    //     foreach ($marakez as $agency) {
    //         $main = new AgencyInfo();
    //         $main->key = 'customer_type';
    //         $main->value = 'agency';
    //         $main->save();
    //         $main->parent_id = $main->id;
    //         $main->save();

    //         AgencyInfo::create(['key' => 'firstname', 'value' => $agency->Name, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'national_id', 'value' => $agency->NationalID, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'enable', 'value' => $agency->enable, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'receiving_code_year', 'value' => $agency->ReceivingCodeYear, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'agency_code', 'value' => $agency->CodeEtehadie , 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'mobile', 'value' => $agency->Cellphone, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'phone', 'value' => $agency->Tel, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'guild_number', 'value' => $agency->GuildNumber, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'issued_date', 'value' => $agency->IssueDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'exp_date', 'value' => $agency->ExpDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'province', 'value' => CityController::create($agency->Province, $agency->City)->id, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'address', 'value' => $agency->Address, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'location', 'value' => $agency->Location, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'description', 'value' => $agency->Details, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'inspection_user', 'value' => $agency->InsUserDelivered, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'fin_green', 'value' => $agency->FinGreen, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'irngv', 'value' => $agency->IrngvFee, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'irngv_pay_date', 'value' => $agency->IrngvFee_PayDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'irngv_ref_id', 'value' => $agency->IrngvFee_Refid, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'plate_reader', 'value' => $agency->LockFee, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'plate_reader_pay_date', 'value' => $agency->LockFee_PayDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'plate_reader_ref_id', 'value' => $agency->LockFee_Refid, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1', 'value' => $agency->debt, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1_pay_date', 'value' => $agency->LockFee_PayDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1_ref_id', 'value' => $agency->debt_RefID, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1_description', 'value' => $agency->debt_description, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'fin_details', 'value' => $agency->FinDetails, 'parent_id' => $main->id]);

            
    //         $fin_infos = FinInfo::where('agency_table', 'marakez1')->where('agency_id', $agency->id)->groupBy('name', 'agency_id')->get();
    //         echo "number of fin info for $agency->id $agency->Name: ". count($fin_infos) . "<br>";

    //         foreach($fin_infos as $fin_info){
    //             $key = $fin_info->name;
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->price;
    //             $record->parent_id = $main->id;
    //             $record->save();

    //             $key = $fin_info->name. '_pay_date';
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->pay_date;
    //             $record->parent_id = $main->id;
    //             $record->save();

    //             $key = $fin_info->name. '_ref_id';
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->ref_id;
    //             $record->parent_id = $main->id;
    //             $record->save();

    //             $key = $fin_info->name. '_description';
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->description;
    //             $record->parent_id = $main->id;
    //             $record->save();
    //         }
    //         // print_r($fin_info);
    //     }

    // });
    // Route::get('import-kamfeshar', function () {
    //     $marakez = KamFesharModel::get();
    //     echo "<pre>";   
    //     foreach ($marakez as $agency) {
    //         $main = new AgencyInfo();
    //         $main->key = 'customer_type';
    //         $main->value = 'low-pressure';
    //         $main->save();
    //         $main->parent_id = $main->id;
    //         $main->save();

    //         AgencyInfo::create(['key' => 'firstname', 'value' => $agency->Name, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'national_id', 'value' => $agency->NationalID, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'enable', 'value' => $agency->enable, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'receiving_code_year', 'value' => $agency->ReceivingCodeYear, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'agency_code', 'value' => $agency->CodeEtehadie , 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'mobile', 'value' => $agency->Cellphone, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'phone', 'value' => $agency->Tel, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'guild_number', 'value' => $agency->GuildNumber, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'issued_date', 'value' => $agency->IssueDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'exp_date', 'value' => $agency->ExpDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'province', 'value' => CityController::create($agency->Province, $agency->City)->id, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'address', 'value' => $agency->Address, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'location', 'value' => $agency->Location, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'description', 'value' => $agency->Details, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'inspection_user', 'value' => $agency->InsUserDelivered, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'fin_green', 'value' => $agency->FinGreen, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'irngv', 'value' => $agency->IrngvFee, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'irngv_pay_date', 'value' => $agency->IrngvFee_PayDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'irngv_ref_id', 'value' => $agency->IrngvFee_Refid, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'plate_reader', 'value' => $agency->LockFee, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'plate_reader_pay_date', 'value' => $agency->LockFee_PayDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'plate_reader_ref_id', 'value' => $agency->LockFee_Refid, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1', 'value' => $agency->debt, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1_pay_date', 'value' => $agency->LockFee_PayDate, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1_ref_id', 'value' => $agency->debt_RefID, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'debt1_description', 'value' => $agency->debt_description, 'parent_id' => $main->id]);
    //         AgencyInfo::create(['key' => 'fin_details', 'value' => $agency->FinDetails, 'parent_id' => $main->id]);

            
    //         $fin_infos = FinInfo::where('agency_table', 'kamfeshar')->where('agency_id', $agency->id)->groupBy('name', 'agency_id')->get();
    //         foreach($fin_infos as $fin_info){
    //             $key = $fin_info->name;
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->price;
    //             $record->parent_id = $main->id;
    //             $record->save();

    //             $key = $fin_info->name. '_pay_date';
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->pay_date;
    //             $record->parent_id = $main->id;
    //             $record->save();

    //             $key = $fin_info->name. '_ref_id';
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->ref_id;
    //             $record->parent_id = $main->id;
    //             $record->save();

    //             $key = $fin_info->name. '_description';
    //             $record = new AgencyInfo();
    //             $record->key = $key;
    //             $record->value = $fin_info->description;
    //             $record->parent_id = $main->id;
    //             $record->save();
    //         }
    //         // print_r($fin_info);
    //         echo "######################<br>";
    //     }
    // });

    // Route::get('import-hidro', function () {
    //     $marakez = HidroModel::get();
    //     $i=1;
    //     foreach ($marakez as $agency) {
    //         if($agency->CodeEtehadie){
    //             $parent_id = AgencyInfo::where('key', 'agency_code')->where('value', $agency->CodeEtehadie)->first()->parent_id;
    //             echo $i. ' - '. $parent_id .' - '.$agency->CodeEtehadie.' - '.  $agency->PostalCode. '<br>';
    //             $i++;
    //             AgencyInfo::create(['key' => 'postal_code', 'value' => (string)$agency->PostalCode, 'parent_id' => $parent_id]);
    //             AgencyInfo::create(['key' => 'standard_certificate_exp_date', 'value' => $agency->standardCertificateExpDate, 'parent_id' => $parent_id]);
    //             AgencyInfo::create(['key' => 'standard_certificate_number', 'value' => $agency->standardCertificateNumber, 'parent_id' => $parent_id]);
    //         }elseif($agency->legalNationalId){
    //             $parent_id = AgencyInfo::where('key', 'legal_national_id')->where('value', $agency->legalNationalId)->first()->parent_id;
    //             echo $i. ' - '. $parent_id .' - '.$agency->CodeEtehadie.' - '.  $agency->PostalCode. '<br>';
    //             $i++;
    //             AgencyInfo::create(['key' => 'postal_code', 'value' => (string)$agency->PostalCode, 'parent_id' => $parent_id]);
    //             AgencyInfo::create(['key' => 'standard_certificate_exp_date', 'value' => $agency->standardCertificateExpDate, 'parent_id' => $parent_id]);
    //             AgencyInfo::create(['key' => 'standard_certificate_number', 'value' => $agency->standardCertificateNumber, 'parent_id' => $parent_id]);
    //         }
            

            
    //     }

    //     $marakez = MarakezModel::get();
    //     $i=1;
    //     foreach ($marakez as $agency) {
    //         if($agency->CodeEtehadie){
    //             $parent_id = AgencyInfo::where('key', 'agency_code')->where('value', $agency->CodeEtehadie)->first()->parent_id;
    //             echo $i. ' - '. $parent_id .' - '.$agency->CodeEtehadie.' - '.  $agency->PostalCode. '<br>';
    //             $i++;
    //             AgencyInfo::create(['key' => 'postal_code', 'value' => (string)$agency->PostalCode, 'parent_id' => $parent_id]);
    //         }
    //     }

    //     $marakez = KamFesharModel::get();
    //     $i=1;
    //     foreach ($marakez as $agency) {
    //         if($agency->CodeEtehadie){
    //             $parent_id = AgencyInfo::where('key', 'agency_code')->where('value', $agency->CodeEtehadie)->first()->parent_id;
    //             echo $i. ' - '. $parent_id .' - '.$agency->CodeEtehadie.' - '.  $agency->PostalCode. '<br>';
    //             $i++;
    //             AgencyInfo::create(['key' => 'postal_code', 'value' => (string)$agency->PostalCode, 'parent_id' => $parent_id]);
    //         }
    //     }
    // });
    Route::get('create-form', [CreateAgencyController::class, 'view'])->name('createForm');
    Route::post('create', [CreateAgencyController::class, 'create'])->name('create');
    Route::get('list-form', [AgencyListController::class, 'view'])->name('listForm');
    Route::get('list', [AgencyListController::class, 'list'])->name('list');
    Route::post('filter-list', [AgencyListController::class, 'filterList'])->name('filterList');
    Route::get('edit/{parent_id}', [AgencyController::class, 'view'])->name('editForm');
    Route::post('edit', [AgencyController::class, 'edit'])->name('edit');
    Route::post('fin-edit', [AgencyController::class, 'finEdit'])->name('finEdit');
    Route::post('docs-edit', [AgencyDocsController::class, 'docsEdit'])->name('docsEdit');
    Route::post('delete-info', [AgencyController::class, 'deleteByKey'])->name('deleteByKey');
});

Route::prefix('/bedehi')->group(function () {
    Route::get('/', [DebtController::class, 'bedehiHomePage']);
    Route::post('/confirm-debt', [DebtController::class, 'confirmForm'])->name('confirmForm');
    Route::post('/', [DebtController::class, 'confirmBedehi'])->name('confirm-bedehi');
    Route::post('/pay', [DebtController::class, 'pay'])->name('pay');
    Route::get('/callback', [DebtController::class, 'callback'])->name('callback');
});


Route::prefix('api/agencies')->group(function(){
    Route::get('{type?}', [AgencyListController::class, 'getValidAgencies']);
});
