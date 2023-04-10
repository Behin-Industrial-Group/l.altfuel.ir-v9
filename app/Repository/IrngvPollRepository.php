<?php 

namespace App\Repository;

use App\Enums\EnumsEntity;
use App\Interfaces\DateFilterInterface;
use App\Models\IrngvPollAnswer;
use App\Models\YourModel;

class IrngvPollRepository implements DateFilterInterface
{
    public function getByCreatedAtRange(string $startDate, string $endDate)
    {
        return IrngvPollAnswer::whereBetween('created_at', [$startDate, $endDate])->get()->each(function($r){
            $r->irngv_user = $r->irngv_user();
            $r->answer_string = EnumsEntity::irngv_poll_question[$r->question]['answers'][$r->answer];
            $r->question = EnumsEntity::irngv_poll_question[$r->question]['question'];
        });
    }
}