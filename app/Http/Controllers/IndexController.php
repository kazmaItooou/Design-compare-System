<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    // Indexページの表示
    public function index() {
        return view('index');
    }

}
