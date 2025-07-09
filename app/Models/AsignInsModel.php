<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignInsModel extends Model
{
    protected $table = 'asigninsrequest';
    protected $fillable = [
        'insCo', 'ins_nationalId', 'ins_fname', 'ins_lname', 'ins_cellphone' , 'ins_email', 'markaz_code', 'status', 'asign', 'description'
    ];
}
