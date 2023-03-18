<?php

namespace App\Http\Controllers;

use App\Enums\EnumsEntity;
use App\Http\Controllers\Auth\UserController;
use App\Http\Validations\IrngvUsersInfoValidation;
use App\Models\IrngvPollAnswer;
use App\Models\IrngvUsersInfo;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IrngvPollAnswerController extends Controller
{
    use ResponseTrait;

    public function register_answer(Request $r)
    {
        $irngv_user_id = IrngvUsersInfo::where('link', $r->link)->first()->id;
        for($i=1; $i<=9; $i++){
            $q = "q$i";
            if($r->$q){
                $a = $this->find_with_irngv_user_id_and_question($irngv_user_id, $q);
                if($a){
                    $this->update($a->id, $r->$q);
                }else{
                    $this->store($irngv_user_id, $q, $r->$q);
                }
            }
        }
        return $this->jsonResponse("ثبت شد");
    }

    public function store($irngv_user_id, $question, $answer)
    {
        $a = new IrngvPollAnswer();
        $a->irngv_user_id = $irngv_user_id;
        $a->question = $question;
        $a->answer = $answer;
        $a->save();
    }

    public function update($row_id, $answer)
    {
        $a = IrngvPollAnswer::find($row_id);
        $a->answer = $answer;
        $a->save();
    }

    public function find_with_irngv_user_id_and_question($irngv_user_id, $question)
    {
        return IrngvPollAnswer::where('irngv_user_id', $irngv_user_id)->where('question', $question)->first();
    }

    public static function get_answer_avg_of_question(string $question)
    {
        return IrngvPollAnswer::where('question', $question)->avg('answer');
    }

    public static function get_answer_avg_of_all_question()
    {
        $report = [];
        foreach(EnumsEntity::irngv_poll_question as $key => $value){
            $report[$key] = self::get_answer_avg_of_question($key);
        }
        return $report;
    }

    public static function get_number_of_special_answer_of_all_question()
    {
        $report = [];
        foreach(EnumsEntity::irngv_poll_question as $key => $value){
            foreach($value['answers'] as $a_key => $a_value ){
                $report[$key][$a_key] = self::get_number_of_special_answer_of_question($key, "$a_key");
            }
        }
        return $report;
    }

    public static function get_number_of_special_answer_of_question(string $question, string $answer)
    {
        return IrngvPollAnswer::where('question', $question)->where('answer', $answer)->count();
    }

}
