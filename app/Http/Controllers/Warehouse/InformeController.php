<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformeController extends Controller
{
  public function index($value='')
  {
    return view("warehouse/informe.index");
  }
}
