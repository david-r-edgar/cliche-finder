<?php

namespace App\Http\Controllers;

use App\Variant;

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




    public function apiSearch(Request $request)
    {
        //FIXME need to make a JSON response for api validation errors
        $this->validate($request, [
            'input' => 'required|max:20000',
        ]);

        $outputMatches = array();
        $variants = Variant::orderBy('created_at', 'asc')->get();
        foreach ($variants as $variant) {
            preg_match_all('/' . $variant->pattern . '/', $request->input, $matches, PREG_OFFSET_CAPTURE);
            if (0 < sizeof($matches[0])) {
                foreach($matches[0] as $match) {
                    $thisMatch = (object)array(
                        'beginPosn' => $match[1],
                        'endPosn' => $match[1] + strlen($match[0]),
                        'cliche' => $variant->cliche->display_name,
                        'descr' => $variant->description);
                    $outputMatches[] = $thisMatch;
                }
            }
        }

        return response()->json([
            'inputLen' => strlen($request->input),
            'inputReceived' => $request->input,
            'matches' => $outputMatches
        ]);
    }
}
