<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
  public function __construct() {

    $this->middleware('auth');
}
    public function index()
    {
      return view('workcenter.search.index');
    }

}
