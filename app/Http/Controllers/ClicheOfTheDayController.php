<?php

namespace App\Http\Controllers;

use App\Cliche;
use App\ClicheOfTheDay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SaveClichesOfTheDay;

class ClicheOfTheDayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * .
    *
    * @param  Request  $request
    * @return Response
    */
    public function index(Request $request)
    {
        $cliches = Cliche::with('clicheOfTheDay')->orderBy('created_at', 'asc')->get();

    /*
        $clicheOfTheDay = ClicheOfTheDay::filter(function($cotd) {
            return (strtotime($cotd->date) == strtotime('today'));
        })->first();
*/

        return view('clicheOfTheDay.index', ['cliches' => $cliches]);
    }

    public function save(SaveClichesOfTheDay $request)
    {
        foreach ($request->cotd as $key => $value)
        {
            if (array_key_exists("cbox", $value) && $value['cbox'] == "on")
            {
                $cotdToStore = ClicheOfTheDay::where('cliche_id', $key)->first();
                if (count($cotdToStore) > 0)
                {
                    $cotdToStore->date = $value['date'] === "" ? null : $value['date'];
                    $cotdToStore->note = $value['note'];
                    $cotdToStore->save();
                }
                else
                {
                    $newCotd = ClicheOfTheDay::create([
                        'cliche_id' => $key,
                        'date' => $value['date'] === "" ? null : $value['date'],
                        'note' => $value['note']
                    ]);
                }
            }
            else
            {
                $cotdToRemove = ClicheOfTheDay::where('cliche_id', $key);
                $cotdToRemove->delete();
            }
        }

        $cliches = Cliche::with('clicheOfTheDay')->orderBy('created_at', 'asc')->get();
        return view('clicheOfTheDay.index', ['cliches' => $cliches]);
    }
}
