<?php

namespace App\Interfaces;

interface DateFilterInterface 
{
    public function getByCreatedAtRange(string $startDate, string $endDate);
}