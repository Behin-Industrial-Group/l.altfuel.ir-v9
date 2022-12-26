<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TakmiliModel extends Model
{
    protected $table = 'takmili';
    public $timestamps = false;
    protected $fillable = [
        'randkey', 'fname', 'lname', 'national_id', 'birthCertificateNumber', 'father', 'dateopened', 'gender', 'mobile', 'tel',
        'takafol_relation', 'takafol_fname', 'takafol_lname', 'takafol_birthDate', 'takafol_nationalID', 'takafol_birthCertificateNumber', 
        'takafol_father', 'takafol_gender',
        'postalCode', 'address', 'bank', 'sheba', 'plan', 'acc', 'numberOfTakafolPerson', 'RefID',
        'price', 'updated_at', 'created_at'
    ];
}
