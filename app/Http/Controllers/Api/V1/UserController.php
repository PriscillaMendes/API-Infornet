<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        return User::select('name', 'email')->get();
    }

    public function show(string $id)
    {
        return User::select('name', 'email')->where('id', $id)->first();
    }

}
