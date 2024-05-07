<?php

namespace IrngvPoll\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IrngvPollAnswer;
use App\Models\IrngvUsersInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GetIrngvUserController extends Controller
{


    public static function getUsers($agencyCode){
        $irngvUsersId = IrngvUsersInfo::where('agency_code', $agencyCode)->pluck('id');
        $agenciesQuestions = IrngvPollAnswer::whereIn('irngv_user_id', $irngvUsersId)->get();
        $questionOneAvg = $agenciesQuestions->where('question', 'q1')->avg('answer');
        $questionTwoAvg = $agenciesQuestions->where('question', 'q2')->avg('answer');
        $questionThreeAvg = $agenciesQuestions->where('question', 'q3')->avg('answer');
        $questionFourAvg = $agenciesQuestions->where('question', 'q4')->avg('answer');
        $questionFiveAvg = $agenciesQuestions->where('question', 'q5')->avg('answer');
        return [
            'numberOfSms' => count($irngvUsersId),
            'avgOfquestion1' => $questionOneAvg,
            'avgOfquestion2' => $questionTwoAvg,
            'avgOfquestion3' => $questionThreeAvg,
            'avgOfquestion4' => $questionFourAvg,
            'avgOfquestion5' => $questionFiveAvg

        ];
    }

}

