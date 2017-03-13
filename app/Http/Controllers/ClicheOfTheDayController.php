<?php

namespace App\Http\Controllers;

use App\ClicheOfTheDay;

use Illuminate\Http\Request;

use App\Http\Requests;

class ClicheOfTheDayController extends Controller
{
    /**
    * .
    *
    * @param  Request  $request
    * @return Response
    */
    public function index(Request $request)
    {
        $clicheOfTheDay = ClicheOfTheDay::get()->first();
    /*
        $clicheOfTheDay = ClicheOfTheDay::filter(function($cotd) {
            return (strtotime($cotd->date) == strtotime('today'));
        })->first();
*/
        //$cliches = Cliche::orderBy('created_at', 'asc')->get();

        return view('clicheOfTheDay.index', ['clicheOfTheDay' => $clicheOfTheDay]);
    }

}
