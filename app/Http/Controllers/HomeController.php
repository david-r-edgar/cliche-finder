<?php

namespace App\Http\Controllers;

use App\ClicheOfTheDay;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $clicheOfTheDay = ClicheOfTheDay::with('cliche')->whereDate('date', '=', date('Y-m-d'))->get()->first();

        return view('home', [
            'clicheOfTheDay' => $clicheOfTheDay->cliche->display_name,
            'cotdNote' => $clicheOfTheDay->note]);
    }
}
