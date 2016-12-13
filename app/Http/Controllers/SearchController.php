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

    /**
    * Main handler when user submits search form.
    *
    * @param  Request  $request
    * @return Response
    */
    public function search(Request $request)
    {
        $this->validate($request, [
            'haystackText' => 'required|max:40000'
        ]);

        $highlightedText = $request->haystackText;

        $variants = Variant::orderBy('created_at', 'asc')->get();
        foreach ($variants as $variant) {
            //var_dump($variant->pattern);
            preg_match_all('/' . $variant->pattern . '/', $request->haystackText, $matches, PREG_OFFSET_CAPTURE);
            if (0 < sizeof($matches[0])) {
                $fmtOpen = "<span style='background-color: yellow;'>";
                $fmtClose = "</span>";
                $startMatchPosn = $matches[0][0][1];
                $endMatchPosn = $matches[0][0][1] + strlen($matches[0][0][0]);

                $highlightedText = substr_replace($highlightedText, $fmtClose, $endMatchPosn, 0);
                $highlightedText = substr_replace($highlightedText, $fmtOpen, $startMatchPosn, 0);
            }
        }

        return view('search.index', ['haystackText' => $highlightedText]);
    }
}
