<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface AuthServiceInterface{
    public function authenticate(Request $request): object;
}
