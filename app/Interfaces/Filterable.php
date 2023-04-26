<?php

namespace App\Interfaces;

interface Filterable {
    public function filter(array $filters = []);
}
