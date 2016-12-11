<?php

namespace App\Http\Controllers;

use App\Cliche;
use App\Variant;

use Illuminate\Http\Request;

use App\Http\Requests;

class ClicheController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Display a list of all cliches.
    *
    * @param  Request  $request
    * @return Response
    */
    public function index(Request $request)
    {
        $cliches = Cliche::orderBy('created_at', 'asc')->get();

        return view('cliches.index', ['cliches' => $cliches]);
    }

    /**
    * Create a new cliche.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'description' => 'required|max:4000'
        ]);


        //$request->user()->cliches()->create([
        $createdCliche = Cliche::create([
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        if ($request->pattern && (0 < strlen($request->pattern))) {
            Variant::create([
                'natural' => "",
                'pat_lang' => "re.1",
                'pattern' => $request->pattern,
                'cliche_id' => $createdCliche->id
            ]);
        }

        return redirect('/cliches');
    }
}
