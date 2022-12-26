<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;
    protected $table = 'workshop';
    protected $fillable = [
        'workshop_name', 'name', 'national_id', 'mobile', 'type', 'type_des', 'province'
    ];

    public function workshop_name()
    {
        return WorkshopClasses::find($this->workshop_name);
    }

    public function type()
    {
        if($this->type == 'agency')
            return 'مرکز خدمات فنی';
        if($this->type == 'hidro')
            return 'آزمایشگاه هیدرو استاتیک';
        else    
            return 'سایر';
    }
}
