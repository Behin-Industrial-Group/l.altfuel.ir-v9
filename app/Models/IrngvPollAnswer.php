<?php

namespace App\Models;

use App\Interfaces\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

class IrngvPollAnswer extends Model
{
    use HasFactory;
    protected $table = "irngv_poll_answers";
    protected $fillable = [
        'irngv_user_id', 'question', 'answer'
    ];


    public function irngv_user()
    {
        return IrngvUsersInfo::find($this->irngv_user_id);
    }
}
