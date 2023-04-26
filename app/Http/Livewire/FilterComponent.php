<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class FilterComponent extends Component
{
    public $model;
    public $filters;

    public function mount($model)
    {
        $this->model = $model;
        $this->filters = collect($model->getAttributes());
    }

    public function filter()
    {
        $this->emit('filter', $this->filters);
    }
    
    public function render()
    {
        return view('livewire.filter-component');
    }
}
