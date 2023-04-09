<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LableController;
use App\Http\Controllers\QrController;
use App\Models\IrngvUsersInfo;
use App\Models\KamFesharModel;
use App\Models\MarakezModel;
use App\Models\MessageModel;
use App\Models\MobileVerfication;
use App\Models\Workshop;
use App\Repository\RGenCode;
use App\Repository\RReport;
use App\Repository\RSendExpSms;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Translation\MessageCatalogue;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('hamayesh/barname', function(){
    header("Location: http://altfuel.ir/wp-content/uploads/2022/06/همایش-1401-VER-24.pdf");
});

Route::get('redirect/{site}', function($site){
   
    return file_get_contents($site);
});

Route::get('/migrate', function(){
    Artisan::call('cache:clear');
    Artisan::call('migrate');
});

Route::get('test-sms', function(){
    // $s = new SMSController();
    // $c = true;
    // while($c){
    //     $lists = IrngvUsersInfo::where('sms_delivery', '0')->take(5)->get();
    //     $messages = array();
    //     foreach($lists as $li){
    //         $msg = "مالک محترم خودروی گازسوز $li->car_name به شماره شاسی $li->chassis ضمن تشکر از مراجعه شما به مرکز خدمات فنی شماره ";
    //         $msg .= "$li->agency_code ، خواهشمند است با تخصیص زمان ارزشمندتان و شرکت در نظرسنجی ذیل، ما را در ارائه هر چه بهتر خدمات یاری رسانید. لینک نظرسنجی: \n";
    //         $msg .= config('irngv')['irngv-poll-link'] ."$li->link \n";
    //         $msg .= "برای ورود به لینک نظرسنجی لازم است فیلترشکن خود را خاموش کنید.\n";
    //         $msg .= "شماره مرکز تماس اتحادیه کشوری سوخت های جایگزین و خدمات وابسته: 02191013791";
    //         $messages[] = [
    //             'sender' => '9820003807',
    //             'recipient' => $li->owner_mobile,
    //             'body' => $msg,
    //             'customerId' => 1,
    //         ];
    //         $li->sms_delivery = 1;
    //         $li->save();
    //         echo "sms send for id: $li->id </br>";
    //     }
    //     $s->send_multiple($messages);
    //     $lists = IrngvUsersInfo::where('sms_delivery', '0')->take(5)->get();
    //     if(!$lists){
    //         $c=false;
    //     }
    // }
    
    
});

Route::post('/mv/send-code', [MobileVerificationController::class, 'send_code_sms']);
Route::any('/mv/check-code/{mobile}/{code}', [MobileVerificationController::class, 'check_code']);


Route::get('/GenCode/{type}/{province}', function($type,$province){
    $a = new RGenCode($province);
    if($type === 'markaz')
        return $a->Markaz();
    if($type === 'hidro')
        return $a->Hidro();
    if($type === 'kamfeshar')
        return $a->Kamfeshar();
});

Route::get('generate-code/', function () {
    $all = KamFesharModel::whereNotNull('Province')->get();
    foreach ($all as $a) {
        $c = new RGenCode($a->Province);
        $a->CodeEtehadie = $c->Kamfeshar();
        $a->save();
    }
});

Route::get('/', function () {
    return "
    <center dir='rtl'><h3>جهت خرید برچسب به پنل کاربری خود در سایت 
    <a href='https://irngv.mimt.gov.ir'>irngv.mimt.gov.ir</a> مراجعه کنید.</h3></center>
    ";
    return redirect('http://lable.altfuel.ir');
});

Route::get('hidro', [HidroController::class, 'createApi']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/irngv.php';


Route::get('/rsgs', function(){
    header("Location: http://altfuel.ir/wp-content/uploads/2020/12/%D8%B1%D8%A7%D9%87%D9%86%D9%85%D8%A7%DB%8C-%D9%85%D8%B1%D8%A7%DA%A9%D8%B2-%D8%AE%D8%AF%D9%85%D8%A7%D8%AA-%D9%85%D8%AA%D9%82%D8%A7%D8%B6%DB%8C-%D8%B5%D8%AF%D9%88%D8%B1-%DA%AF%D9%88%D8%A7%D9%87%DB%8C-%D8%B3%D9%84%D8%A7%D9%85%D8%AA-01-1.pdf");
});

Route::get('/tel', [TelegramController::class, 'test']);
Route::get('/webhook', [TelegramController::class, 'webhook']);

Route::post( '/shopinglable', [ShopingController::class, 'index']);
Route::get( '/shopinglable/verify', [ShopingController::class, 'verify']);

Route::any('/irobot', [IssuesRobotController::class, 'getRequest']);

Route::get( '/issues', [IssuesController::class, 'selectIssuesCatagoryForm']);
Route::get( '/issues/{id}', [IssuesController::class, 'issuesCatagoryForm']);
Route::get( '/issues/survay/{id}', [IssuesController::class, 'SetSurvay']);
Route::post( '/issues', [IssuesController::class, 'Register']);

Route::get('/answer', [IssuesController::class, 'answerform']);
Route::post('/answer', [IssuesController::class, 'showanswer']);

Route::get('/platereader', [DownloadController::class, 'PlatereaderForm']);
Route::post('/platereaderdownload', [DownloadController::class, 'Platereader']);

//*** BIMEH MARAKEZ
/*
Route::get( '/bimeh', 'BimehController@index' );
Route::post( '/bimeh', 'BimehController@calculatePrice' );
Route::post( '/bimeh/pay', 'BimehController@pay' );
Route::get( '/bimeh/success/{codeEtehadie}/{price}/{pType}/{number}', 'BimehController@success' );
*/

Route::prefix('/hamayesh/')->group(function(){
    Route::get('workshop', [HamayeshController::class, 'register_workshop_form']);
});


Route::prefix('/takmili')->group(function(){
    Route::get( '/', [BimehController::class, 'registerForm'])->name('takmiliform');
    Route::post( '/', [BimehController::class, 'register']);
    Route::get( '/success/{key}/{price}', [BimehController::class, 'takmiliSuccess']);

    Route::get( '/login', [BimehController::class, 'loginForm']);
    Route::post( '/login', [BimehController::class, 'show']);
});

Route::prefix('/bedehi')->group(function(){
    Route::get( '/', [FinController::class, 'bedehiHomePage']);
    Route::post( '/', [FinController::class, 'confirmBedehi'])->name('confirm-bedehi');
    Route::post( '/pay', [FinController::class, 'pay'])->name('bedehi-pay');
    Route::get( '/success/{type}/{code}/{price}', [FinController::class, 'success']);
    Route::get('/{type}/{nid}/{mobile}/{code}', [FinController::class, 'confirmForm'])->name('confirm-form');
});

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function(){
    Route::get('/', [HomeController::class, 'index']);

    Route::post('/setComments', [CommentsController::class, 'set']);

    Route::get('/lable',[LableController::class, 'index']);
    Route::post('/lable', [LableController::class, 'register']);

    Route::get('/addqr', [QrController::class, 'index']);
    Route::post('/addqr', [QrController::class, 'store']);

    Route::get('/createqr', [QrController::class, 'createqrform']);
    Route::post('/createqr', [QrController::class, 'createqr']);

    Route::get('/printqr',[QrController::class, 'printqr'] );
    Route::get('/editqr/{id}', [QrController::class, 'editform']);
    Route::post('/editqr/{id}',[QrController::class, 'edit']);

    Route::get('/addarchive', 'ArchiveController@index');
    Route::post('/addarchive', 'ArchiveController@create');

    Route::get('/addstatus', 'ArchiveController@addstatusform');
    Route::post('/addstatus', 'ArchiveController@addstatus');

    Route::prefix('/marakez')->group(function(){
        Route::get('/',[MarakezController::class, 'index'] );
        Route::get('/addyear',[MarakezController::class, 'addCodeYear']);
        Route::get('/edit/{id}',[MarakezController::class, 'editmarkazform']);
        Route::post('/edit/{id}',[MarakezController::class, 'editmarkaz']);
        Route::get('/get-all',[MarakezController::class, 'get_all'])->name('get-all-marakez');
        Route::get('/get-info/{id}',[MarakezController::class, 'get_fin_info'])->name('get-markaz-fin-info');
        Route::any('/edit-fin-info/{id}',[MarakezController::class, 'edit_fin_info'])->name('edit-markaz-fin-info');
        Route::any('/edit-markaz-info/{id}',[MarakezController::class, 'edit_markaz_info'])->name('edit-markaz-info');
        Route::post('/edit-pelakkhan', [MarakezController::class, 'EditPelakkhan']);
        Route::get('/{fin}',[MarakezController::class, 'index'] );

        Route::get('/get/{code}', [MarakezController::class, 'getMarakez']);


    });

    Route::get('/editmarkaz',[MarakezController::class, 'editmarkazform']);
    Route::post('/editmarkaz',[MarakezController::class, 'editmarkaz']);

    Route::get('/addmarkaz',[MarakezController::class, 'addmarkazform']);
    Route::post('/addmarkaz',[MarakezController::class, 'addmarkaz']);

    Route::prefix('/hidro')->group(function(){
        Route::get('/',[HidroController::class, 'index']);

        Route::get('/show/{id}',[HidroController::class, 'show']);
        Route::post('edit/{id}',[HidroController::class, 'edit']);

        Route::get('/fin',[HidroController::class, 'show_fin_form_view'] )->name('show-hidro-fin-form');
        Route::get('/get-all',[HidroController::class, 'get_all'])->name('get-all-marakez');
        Route::get('/get-info/{id}',[HidroController::class, 'get_fin_info'])->name('get-markaz-fin-info');
        Route::any('/edit-fin-info/{id}',[HidroController::class, 'edit_fin_info'])->name('edit-markaz-fin-info');
        Route::any('/edit-markaz-info/{id}',[HidroController::class, 'edit_markaz_info'])->name('edit-markaz-info');

        Route::get('/add',[HidroController::class, 'addform']);
        Route::post('/add',[HidroController::class, 'addmarkaz']);
    });

    Route::prefix('/kamfeshar')->group(function(){
        Route::get('/',[KamFesharController::class, 'index']);

        Route::get('/show/{id}',[KamFesharController::class, 'show']);
        Route::post('edit/{id}',[KamFesharController::class, 'edit']);

        Route::get('/fin',[KamFesharController::class, 'show_fin_from_view'] )->name('show_fin_from_view');
        Route::get('/get-all',[KamFesharController::class, 'get_all'])->name('get-all-marakez');
        Route::get('/get-info/{id}',[KamFesharController::class, 'get_fin_info'])->name('get-markaz-fin-info');
        Route::any('/edit-fin-info/{id}',[KamFesharController::class, 'edit_fin_info'])->name('edit-markaz-fin-info');
        Route::any('/edit-markaz-info/{id}',[KamFesharController::class, 'edit_markaz_info'])->name('edit-markaz-info');

        Route::get('/add',[KamFesharController::class, 'addform']);
        Route::post('/add',[KamFesharController::class, 'addmarkaz']);
    });

    Route::prefix('/contractors')->group(function(){
        Route::get('/', 'ContractorsController@index');

        Route::get('/show/{id}', 'ContractorsController@show');
        Route::post('edit/{id}', 'ContractorsController@edit');

        Route::get('/add', 'ContractorsController@addform');
        Route::post('/add', 'ContractorsController@addmarkaz');
    });

    Route::prefix('/search-issue')->group(function(){
        //ISSUES SEARCH
        Route::get('/{catagory}/{field}/{q}',[IssuesController::class, 'search']);
    });

    Route::prefix('/search-box')->group(function(){
        //ISSUES SEARCH
        Route::get('/', [SearchBoxController::class, 'search']);
        Route::get('/gettablecolumns/{q}', [SearchBoxController::class, 'getTableColumns']);
    });

    Route::prefix('/irngv/')->group(function(){
        Route::get('receive-data', [IrngvUsersInfoController::class, 'show'])->name('admin.irngv.show.list');
        Route::any('get-data', [IrngvUsersInfoController::class, 'get_users_info'])->name('admin.irngv.get.users.info');
        Route::get('poll-answers', [IrngvUsersInfoController::class, 'show_poll_answers_list'])->name('admin.irngv.show.answers');

    });


    Route::prefix('/issues')->group(function(){
        Route::get('/catagories',[IssuesController::class, 'catagories_form']);
        Route::get('/add-catagory',[IssuesController::class, 'add_catagory']);
        Route::get('/createIssue',[IssuesController::class, 'create_issue_form']);
        Route::post('/createIssue',[IssuesController::class, 'create_issue']);
        Route::post('/create-new-issue',[IssuesController::class, 'register_issue']);
        Route::post('/reg-answer', [IssuesController::class, 'RegisterAnswer']);
        Route::post('/set-comment', [CommentsController::class, 'set']);
        Route::post('/sendto', [IssuesController::class, 'sendto']);

        Route::prefix('/show')->group(function(){
            Route::prefix('/{catagory}')->group(function(){
                Route::get('/',[IssuesController::class, 'issues_show']);
                Route::get('/{tracking}',[IssuesController::class, 'issues_show']);
                Route::get('/national-id/{q}',[IssuesController::class, 'issue_show']);
                Route::post('/national-id/{id}',[IssuesController::class, 'Reganswer']);
            });
        });

        Route::prefix('/get')->group(function(){
            Route::get('/{catagory}',[IssuesController::class, 'GetIssues']);
            Route::get('/{catagory}/{tracking}',[IssuesController::class, 'GetIssues']);
        });

        Route::get('/get-issues-no/{no}', [IssuesController::class, 'GetIssuesNumberDatalist']);
        Route::post('/set-related-issue/{issue_id}', [IssuesController::class, 'SetRelatedIssue']);
    });

    Route::prefix('/videos')->group(function(){
        Route::get('show/{catagory}',[VideosController::class, 'showList']);

        Route::get('add',[VideosController::class, 'addForm']);
        Route::post('add',[VideosController::class, 'add']);

        Route::get('addCatagory',[VideosController::class, 'addCatagoryForm']);
        Route::post('addCatagory',[VideosController::class, 'addCatagory']);
    });

    Route::get('/smstemplate', function(){
        return view('admin.smstemplate');
    });

    Route::prefix('/forms')->group(function(){
        Route::get('/parvane', function(){
            return view('admin.forms');
        });
    });

    Route::prefix('/whatsapp')->group(function(){
        Route::get('/writeMsg', function(){
            return view('admin.sendMessage.write');
        });
        Route::post('/sendMsg', 'WhatsappController@sendMessage');
    });

    Route::prefix('/user')->group(function(){
        Route::get('/{id}',[Auth\UserController::class, 'index']);
        Route::post('/{id}',[Auth\UserController::class, 'AccessReg']);

        Route::post('/{id}/changepass',[Auth\UserController::class, 'ChangePass']);
        Route::post('/{id}/change-ip',[Auth\UserController::class, 'ChangeIp'])->name('change-user-ip');

        Route::post('/{id}/changeShowInReport', [Auth\UserController::class, 'changeShowInReport']);
    });

    Route::name('report.')->prefix('/report')->group(function(){
        Route::get('/count-issues',[RReport::class, 'get_number_of_issues']);
        Route::get('/count-today-issues',[RReport::class, 'number_of_today_issues']);
        Route::get('/count-my-answered-issues',[RReport::class, 'my_answered_issues']);
        Route::get('/count-my-today-answered-issues',[RReport::class, 'my_today_answered_issues']);
        Route::get('/ticket',[ReportController::class, 'ticketform']);
        Route::get('/ticket/avgtime', [ReportController::class, 'answerTimeAvg']);

        Route::prefix('/license')->group(function(){
            Route::get('/', [ReportController::class, 'license']);
            Route::post('/upload-license-request', [RReport::class, 'upload_license_request_excel']);
            Route::post('/upload-license', [RReport::class, 'upload_license_excel']);
            Route::get('/calculate-time', [RReport::class, 'calculate_issued_request_diff_date']);
        });
        
        Route::name('call.')->prefix('/call')->group(function(){
            Route::get('/',[ReportController::class, 'CreateCallReportForm']);
            Route::post('/',[ReportController::class, 'CreateCallReport']);
            Route::get('/show', [ReportController::class, 'ShowCallReport']);
            Route::get('/get-data/{date?}', [ReportController::class, 'GetCallReport'])->name('get_data');
        });

        Route::name('irngv.')->prefix('irngv-poll')->group(function(){
            Route::get('', [ReportIrngvPollController::class, 'show_list'])->name('poll');
        });
    });

    Route::prefix('/takmili')->group(function(){
        Route::get('/registerors',[BimehController::class, 'showAll']);
    });

    Route::prefix('/ins')->group(function(){
        Route::get('asign/ins/form',[InsController::class, 'asignInsForm']);
        Route::post('asign/ins',[InsController::class, 'asignIns']);

        Route::get('asign/get/nids/{nid}',[InsController::class, 'GetNids']);
        Route::get('asign/get/{column}/{value}',[InsController::class, 'GetData']);

        Route::get('show/all', [InsController::class, 'asignInsList']);
    });

    Route::prefix('/request')->group(function(){
        Route::get('asign/ins/show/{id}',[RequestController::class, 'asignInsList'])->name('request.show.all');
        Route::get('asign/ins/edit/{markaz_code}',[RequestController::class, 'asignInsEditForm'] );
        Route::post('asign/ins/edit/{id}',[RequestController::class, 'asignInsEdit']);
    });

    Route::prefix('/messages')->group(function(){
        Route::get('/list', [MessageController::class, 'list']);
        Route::get('/show/{id}', [MessageController::class, 'show']);
        Route::get('/number-of-unread', [MessageController::class, 'numberOfUnread']);
    });

    Route::prefix('/robot')->group(function(){
        Route::get('/add', [IssuesRobotController::class, 'AddCatagoryForm']);
        Route::get('/edit', [IssuesRobotController::class, 'EditAnswerForm']);
        Route::post('/edit', [IssuesRobotController::class, 'EditAnswer']);

        Route::get('/get/catagory', [IssuesRobotController::class, 'GetCatagory']);
        Route::get('/get/answer/{value}', [IssuesRobotController::class, 'GetAnswer']);
        Route::post('/set', [IssuesRobotController::class, 'Store']);
        Route::get('/receive_answer/{id}', [IssuesRobotController::class, 'RecieveAnswer']);
    });

    Route::get('/chang', [IssuesController::class, 'chang']);

    Route::prefix('/disable')->group(function(){
        Route::get('/', [DisableAppController::class, 'Index']);
        Route::post('/', [DisableAppController::class, 'SetDisable']);
        Route::get('/get-all-ips', [DisableAppController::class, 'GetAllIps']);
        Route::post('/enable-app', [DisableAppController::class, 'EnableApp']);
        Route::get('/ip', [DisableAppController::class, 'CheckClientIP']);
    });

    Route::get('options', [OptionsController::class, 'show_options']);
    Route::post('options', [OptionsController::class, 'update_options']);

    Route::get('/clear-cache', function(){
        Artisan::call('cache:clear');
    });

    Route::get('send-sms-3month-to-expired', [RSendExpSms::class, '_3months_to_exp_marakez_list']);
    Route::get('get-3month-sms-sended-list', [RSendExpSms::class, 'get_3month_sms_sended_list']);

    Route::get('send-sms', function(){
        return view('admin.sms.send');
    });
    Route::post('send-sms', [MobileVerificationController::class, 'send_newpass_sms']);


    Route::prefix('/hamayesh/')->group(function(){
        Route::get('add-class', [HamayeshController::class, 'add_class_form'])->name('add-class-form');
        Route::get('edit-class/{id}', [HamayeshController::class, 'get_edit_class_data']);
        Route::POST('add-class', [HamayeshController::class, 'add_class'])->name('add-class');
        Route::POST('edit-class', [HamayeshController::class, 'edit_class'])->name('edit-class');
        Route::get('list', [HamayeshController::class, 'list'])->name('hamayesh-list');
    });



});
