<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ReturnValidator;

class Base extends Controller
{
    public function validateParameters($datas, $rules) : ReturnValidator
    {
        return Validator::make($datas, $rules);
    }
}