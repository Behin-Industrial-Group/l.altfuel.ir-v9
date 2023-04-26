<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use App\Interfaces\Filterable;

class FilterModel implements Filterable
{
    protected $model;

    public function __construct(Builder $model)
    {
        $this->model = $model;
    }

    public function filter(array $filters = [])
    {
        // Get all the columns of the model's table
        $columns = Schema::getColumnListing($this->model->getModel()->getTable());

        // Loop through each column and add a where clause if requested by the user
        foreach ($columns as $column) {
            if (isset($filters[$column])) {
                $this->model->where($column, $filters[$column]);
            }
        }

        // Get the filtered results
        return $this->model->get();
    }
}
