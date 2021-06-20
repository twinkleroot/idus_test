<?php

namespace App\Interfaces\Services;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface CRUDService
{
    public function getList(array $searchCondition) : Collection;
    public function add(Collection $collection) : bool;
}