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
    * New cliche submission form.
    *
    * @param  Request  $request
    * @return Response
    */
    public function newCliche(Request $request)
    {
        return view('cliches.edit');
    }

    /**
    * Edit cliche submission form.
    *
    * @param  Request  $request
    * @return Response
    */
    public function details(Request $request, Cliche $cliche)
    {
        return view('cliches.edit', ['cliche' => $cliche,
                                     'variants' => $cliche->variants]);
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
            'description' => 'max:4000'
        ]);

        $createdCliche = Cliche::create([
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        foreach ($request->pattern as $index => $variant) {
            if ($variant && (0 < strlen($variant))) {
                Variant::create([
                    'natural' => "",
                    'pat_lang' => "re.1",
                    'pattern' => $variant,
                    'cliche_id' => $createdCliche->id
                ]);
            }
        }

        return redirect('/cliches');
    }

    /**
    * Edit an existing cliche.
    *
    * @param  Request  $request
    * @return Response
    */
    public function edit(Request $request, Cliche $cliche)
    {
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'description' => 'max:4000'
        ]);

        $cliche->display_name = $request->display_name;
        $cliche->description = $request->description;
        $cliche->save();

        //FIXME better to edit them rather than delete
        //delete all variants belonging to this cliche, then recreate them
        foreach($cliche->variants as $variant) {
            $variant->delete();
        }
        foreach ($request->pattern as $index => $variant) {
            if ($variant && (0 < strlen($variant))) {
                Variant::create([
                    'natural' => "",
                    'pat_lang' => "re.1",
                    'pattern' => $variant,
                    'cliche_id' => $cliche->id
                ]);
            }
        }


        return redirect('/cliche/' . $cliche->id);
    }

}
