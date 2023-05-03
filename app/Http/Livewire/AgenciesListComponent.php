<?php

namespace App\Http\Livewire;

use App\Http\Controllers\AgencyController;
use Livewire\Component;

class AgenciesListComponent extends Component
{
    public $agency_table;
    public $centers;
    public $showModal = false;
    public $center;

    public function render()
    {
        return view('livewire.agencies-list-component', [
            'agency_table' => $this->agency_table,
            'centers' => AgencyController::list($this->agency_table),
        ]);
    }

    public function mount($agency_table)
    {
        $this->agency_table = $agency_table;
        $this->centers = AgencyController::list($this->agency_table);
    }

    public function filter()
    {
        $this->centers = AgencyController::list($this->agency_table);
    }

    public function openModal($id)
    {
        $this->center = AgencyController::get($this->agency_table, $id);
        $this->showModal = true;
    }

    public function save()
    {
        $this->center->save();
        $this->showModal = false;
    }
}
