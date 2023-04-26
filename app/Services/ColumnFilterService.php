<?php 

namespace App\Services;

use App\Interfaces\ColumnFilterServiceInterface;
use Illuminate\Database\Eloquent\Builder;

class ColumnFilterService implements ColumnFilterServiceInterface
{
    /**
     * Apply requested filters on columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $column => $value) {
            if (!empty($value)) {
                $query->where($column, $value);
            }
        }
        
        return $query;
    }
}