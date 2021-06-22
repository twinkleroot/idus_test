<?php

namespace App\Interfaces\Services;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface CRUDService
{
    public function getList(array $searchCondition) : array;
    public function getById(int $id) : array;
    public function add(array $collection) : int;
}