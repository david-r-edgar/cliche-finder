<?php

namespace App\Http\Controllers;

use App\ClicheOfTheDay;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $clicheOfTheDay =  ClicheOfTheDay::get()->first();

        return view('home', [
            'clicheOfTheDay' => $clicheOfTheDay]);
    }
}
