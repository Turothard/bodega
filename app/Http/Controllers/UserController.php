<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
      return 'Usuarios';
    }

    public function getpermisos()
    {
      return auth()->id();
    }
}
