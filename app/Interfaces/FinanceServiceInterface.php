<?php

namespace App\Interfaces;

interface FinanceServiceInterface
{
    public function createFinInfo(array $data);
    public function getFinInfo(string $agency_table, int $agency_id);
    public function updateFinInfo(string $agency_table, int $agency_id, object $data);
    public function updateAgencyFinInfo(string $agency_table, int $agency_id, object $data);
    public function deleteFinInfo(int $id);
}