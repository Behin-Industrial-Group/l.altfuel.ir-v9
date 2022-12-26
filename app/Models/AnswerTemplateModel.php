<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerTemplateModel extends Model
{
    protected $table = 'answer_template';
    public $timestamps = false;
    protected $fillable = [
        'catagory', 'text'
    ];
}
