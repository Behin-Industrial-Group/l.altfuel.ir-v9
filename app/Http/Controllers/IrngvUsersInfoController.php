<?php

namespace App\Http\Controllers;

use App\CustomClasses\Access;
use App\CustomClasses\IrngvUserInfoFilterBy;
use App\Enums\EnumsEntity;
use App\Http\Validations\IrngvUsersInfoValidation;
use App\Models\IrngvPollAnswer;
use App\Models\IrngvUsersInfo;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class IrngvUsersInfoController extends Controller
{
    
    public function store(Request $r)
    {
        $row = IrngvUsersInfo::create($r->except(['api_token']));
        $row->link = $this->create_random_unique_link();
        $row->save();
        return $row;
    }

    public function create_random_unique_link()
    {
        $r = RandomStringController::Generate(10);
        if(IrngvUsersInfo::where('link', $r)->first()){
            $this->create_random_unique_link();
        }
        return $r;
    }

    public function show()
    {
        Access::check('irngv');
        return view('admin.irngv.list');
    }

    public function get_users_info(Request $r)
    {
        if($r->created_from || $r->created_to){
            return IrngvUserInfoFilterBy::created_at($r->created_from, $r->created_to);
        }

        return json_encode(
            [
                'data' => IrngvUserInfoFilterBy::created_at(Verta::today(), Verta::yesterday()),
            ]
        );
    }

    public function get_user_by_link($link)
    {
        return IrngvUsersInfo::where('link', $link)->first();
    }

    public function show_poll($link, $test = 0)
    {
        if($test){
            return view('irngv.poll-test')->with([
                'info' => IrngvUsersInfo::where('link', $link)->first(),
                'questions' => EnumsEntity::irngv_poll_question,
                'poll_info' => IrngvPollAnswer::where('irngv_user_id', IrngvUsersInfo::where('link', $link)->first()->id)->get(),
                'test' => $test
            ]);
        }
        return view('irngv.poll')->with([
            'info' => IrngvUsersInfo::where('link', $link)->first(),
            'questions' => EnumsEntity::irngv_poll_question,
            'poll_info' => IrngvPollAnswer::where('irngv_user_id', IrngvUsersInfo::where('link', $link)->first()->id)->get(),
            'test' => $test
        ]);
    }

    public function show_poll_answers_list()
    {
        return view('admin.irngv.answer-list')->with([
            'rows' => IrngvPollAnswer::get()->each(function($c){
                $c->user = IrngvUsersInfo::find($c->irngv_user_id);
                if(array_key_exists($c->question, EnumsEntity::irngv_poll_question)){
                    if(array_key_exists($c->answer, EnumsEntity::irngv_poll_question["$c->question"]["answers"]) ){
                        $c->answer_value = EnumsEntity::irngv_poll_question["$c->question"]["answers"][$c->answer];
                    }else{
                        $c->answer_value = "پاسخ این سوال معتبر نیست";
                    }
                    $c->question = EnumsEntity::irngv_poll_question["$c->question"]["question"];
                }else{
                    $c->question = "سوال تعریف نشده است";
                    $c->answer_value = "پاسخ تعریف نشده است";
                }
                
                
            })
        ]);
    }
}
