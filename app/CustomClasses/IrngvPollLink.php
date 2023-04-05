<?php 


namespace App\CustomClasses;

class IrngvPollLink
{
    public static function create($link)
    {
        return config('irngv')['irngv-poll-link'] . "$link";
    }
}