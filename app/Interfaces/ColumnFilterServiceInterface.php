<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface ColumnFilterServiceInterface
{
    public function applyFilters(Builder $query, array $filters): Builder;
}