<?php

namespace App\Http\Livewire;

use App\Http\Controllers\MarakezController;
use App\Interfaces\FinanceServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FinComponent extends Component
{
    public $agency;
    public $agency_id;
    public $results;

    public function mount(array $agency, $agency_id, FinanceServiceInterface $finService){
        $this->agency_id = $agency_id;
        $this->agency = $agency;
        $this->results = $finService->getFinInfo($agency['table'], $agency_id);
    }

    public function get()
    {
        // $this->emit('results', $this->results);
        // $this->emit('agency_info', $this->agency_info);
    }

    public function render()
    {
        return view('livewire.fin-component',[
            'agency_info' => DB::table($this->agency['table'])->find($this->agency_id)
        ]);
    }
}
