<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CRUDService
{
    public function getList() : Collection;
    public function getById(int $id) : Collection;
}