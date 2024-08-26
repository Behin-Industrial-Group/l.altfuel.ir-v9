<?php

namespace IrngvPoll\Controllers;

use App\Enums\EnumsEntity;
use App\Http\Controllers\Controller;
use App\Models\IrngvPollAnswer;
use App\Models\IrngvUsersInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetIrngvUserController extends Controller
{


    public static function getUsers($agencyCode){

        // $irngvUsersId = IrngvUsersInfo::where('agency_code', $agencyCode)->pluck('id');
        // $agenciesQuestions = IrngvPollAnswer::whereIn('irngv_user_id', $irngvUsersId)->get();
        // $questionOneAvg = $agenciesQuestions->where('question', 'q1')->avg('answer');
        // $questionTwoAvg = $agenciesQuestions->where('question', 'q2')->avg('answer');
        // $questionThreeAvg = $agenciesQuestions->where('question', 'q3')->avg('answer');
        // $questionFourAvg = $agenciesQuestions->where('question', 'q4')->avg('answer');
        // $questionFiveAvg = $agenciesQuestions->where('question', 'q5')->avg('answer');
        // return [
        //     'numberOfSms' => count($irngvUsersId),
        //     'avgOfQuestion1' => $questionOneAvg,
        //     'avgOfQuestion2' => $questionTwoAvg,
        //     'avgOfQuestion3' => $questionThreeAvg,
        //     'avgOfQuestion4' => $questionFourAvg,
        //     'avgOfQuestion5' => $questionFiveAvg

        // ];

        $irngvUsersId = IrngvUsersInfo::where('agency_code', $agencyCode)->pluck('id');
        $agenciesQuestions = IrngvPollAnswer::whereIn('irngv_user_id', $irngvUsersId)->get();
        $uniqueQuestions = IrngvPollAnswer::groupBy('question')->pluck('question');
        $averageAnswers = [];
        foreach($uniqueQuestions as $uniqueQuestion){
            $key = EnumsEntity::irngv_poll_question[$uniqueQuestion]['question'];
            $averageAnswer[$key] = number_format($agenciesQuestions->where('question', $uniqueQuestion)->avg('answer'), 2);

        }

        $data = [];
        $data['numberOfSms'] = count($irngvUsersId);
        $data['data'] = $averageAnswer;
        return $data;
    }

    public function getAnswers(Request $request){
        if(!$request->created_from){
            return [ 'data' => [] ];
        }
        $enums = EnumsEntity::irngv_poll_question;
        $fromDate = Carbon::createFromTimestamp($request->created_from / 1000);
        $toDate = Carbon::createFromTimestamp($request->created_to / 1000);
        $fromFormattedDate = $fromDate->format('Y-m-d');
        $toFormattedDate = $toDate->format('Y-m-d');
        $results = IrngvPollAnswer::whereBetween('created_at', [$fromFormattedDate, $toFormattedDate])->get()->each(function($row) use ($enums){
            $row->irngv_user = $row->irngv_user();
            $row->question_value = $enums["$row->question"]['question'];
            $row->answer_string = $enums[$row->question]['answers'][$row->answer];
        });

        return $results;
    }

}

