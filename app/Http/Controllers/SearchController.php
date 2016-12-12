<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    /**
    * .
    *
    * @param  Request  $request
    * @return Response
    */
    public function index(Request $request)
    {
        return view('search.index');
    }

    /**
    * Main handler when user submits search form.
    *
    * @param  Request  $request
    * @return Response
    */
    public function search(Request $request)
    {
        $this->validate($request, [
            'haystackText' => 'required|max:4000'
        ]);
    }
}
