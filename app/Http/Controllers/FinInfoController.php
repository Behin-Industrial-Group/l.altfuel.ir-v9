<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\FinanceServiceInterface;
use Illuminate\Http\Request;

class FinInfoController extends Controller
{
    protected $financeService;

    public function __construct(FinanceServiceInterface $financeService)
    {
        $this->financeService = $financeService;
    }

    public function create(Request $request)
    {
        $finInfo = $this->financeService->createFinInfo($request->all());
        return response()->json($finInfo);
    }

    public function get($agency_type, $agency_id)
    {
        $finInfo = $this->financeService->getFinInfo($agency_type, $agency_id);
        return response()->json($finInfo);
    }

    public function update(Request $r)
    {
        $finInfo = $this->financeService->updateFinInfo($r->agency, $r->agency_id, $r);
        return response()->json($finInfo);
    }

    public function delete($id)
    {
        $this->financeService->deleteFinInfo($id);
        return response()->json(['message' => 'Fin info deleted']);
    }
}
