<?php

namespace App\Http\Controllers;

use App\Variant;

use Illuminate\Http\Request;

use App\Http\Requests;









////////// unicode replacement for preg_match_all ///////////////

mb_internal_encoding('UTF-8');

    /**
    * Returns array of matches in same format as preg_match or preg_match_all
    * @param bool   $matchAll If true, execute preg_match_all, otherwise preg_match
    * @param string $pattern  The pattern to search for, as a string.
    * @param string $subject  The input string.
    * @param int    $offset   The place from which to start the search (in bytes).
    * @return array
    */
function pregMatchCapture($matchAll, $pattern, $subject, $offset = 0)
{
    $matchInfo = array();
    $method    = 'preg_match';
    $flag      = PREG_OFFSET_CAPTURE;
    if ($matchAll) {
        $method .= '_all';
    }
    $n = $method($pattern, $subject, $matchInfo, $flag, $offset);
    $result = array();

    if ($n !== 0 && !empty($matchInfo)) {
        if (!$matchAll) {
            $matchInfo = array($matchInfo);
        }
        foreach ($matchInfo as $matches) {
            $positions = array();
            foreach ($matches as $match) {
                $matchedText   = $match[0];
                $matchedLength = $match[1];
                $positions[]   = array(
                    $matchedText,
                    mb_strlen(mb_strcut($subject, 0, $matchedLength))
                );
            }
            $result[] = $positions;
        }
        if (!$matchAll) {
            $result = $result[0];
        }
    }

    return $result;
}











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
            $matches = pregMatchCapture(true, '/' . $variant->pattern . '/u', $request->input);
            if (0 < sizeof($matches) && 0 < sizeof($matches[0])) {
                foreach($matches[0] as $match) {
                    $thisMatch = (object)array(
                        'beginPosn' => $match[1],
                        'endPosn' => $match[1] + mb_strlen($match[0]),
                        'cliche' => $variant->cliche->display_name,
                        'descr' => $variant->description);
                    $outputMatches[] = $thisMatch;
                }
            }
        }

        return response()->json([
            'inputLen' => mb_strlen($request->input),
            'inputReceived' => $request->input,
            'matches' => $outputMatches
        ]);
    }
}
