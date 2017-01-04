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

    //FIXME commented because I think this is unused - DELETEME?
    /**
    * Main handler when user submits search form.
    *
    * @param  Request  $request
    * @return Response
    */
    /*
    public function search(Request $request)
    {
        $this->validate($request, [
            'haystackText' => 'required|max:20000'
        ]);

        $highlightedText = $request->haystackText;

        $variants = Variant::orderBy('created_at', 'asc')->get();
        foreach ($variants as $variant) {
            preg_match_all('/' . $variant->pattern . '/', $request->haystackText, $matches, PREG_OFFSET_CAPTURE);
            //var_dump($matches);

            if (0 < sizeof($matches[0])) {
                //foreach ($matches[0] as $match) {
                $matchIndex = count($matches[0]);
                while($matchIndex) {
                    $match = $matches[0][--$matchIndex];
                    $fmtOpen = "<span style='background-color: yellow;'>";
                    $fmtClose = "</span>";
                    $startMatchPosn = $match[1];
                    $endMatchPosn = $match[1] + strlen($match[0]);

                    $highlightedText = substr_replace($highlightedText, $fmtClose, $endMatchPosn, 0);
                    $highlightedText = substr_replace($highlightedText, $fmtOpen, $startMatchPosn, 0);
                }
            }
        }

        return view('search.index', ['haystackText' => $highlightedText]);
    }
*/


    public function apiSearch(Request $request)
    {
        //FIXME need to make a JSON response for api validation errors
        $this->validate($request, [
            'input' => 'required|max:20000',
            'content-type' => 'max:100' //FIXME we should check for text/plain and what else?
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
            'inputReceived' => $request->input,
            'matches' => $outputMatches
        ]);
    }
}
