<?php

namespace App\Http\Controllers;

use App\ClicheOfTheDay;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $cotd = "";
        $cotdNote = "";

        //first try to get cotd for current date
        $clicheOfTheDay = ClicheOfTheDay::with('cliche')->whereDate('date', '=', date('Y-m-d'))->get()->first();
        if ($clicheOfTheDay)
        {
            $cotd = $clicheOfTheDay->cliche->display_name;
            $cotdNote = $clicheOfTheDay->note;
        }
        else
        {
            //if none, select a random one from those with no date yet
            $clicheOfTheDay = ClicheOfTheDay::with('cliche')->where('date', NULL)->get()->random();

            if (!$clicheOfTheDay)
            {
                //and if none of those, select a random one from those with older dates
                $clicheOfTheDay = ClicheOfTheDay::with('cliche')->get()->random();
            }

            if ($clicheOfTheDay)
            {
                $cotd = $clicheOfTheDay->cliche->display_name;
                $cotdNote = $clicheOfTheDay->note;

                //and update its date
                $clicheOfTheDay->date = date('Y-m-d');
                $clicheOfTheDay->save();
            }
        }

        return view('home', [
            'clicheOfTheDay' => $cotd,
            'cotdNote' => $cotdNote]);
    }
}
