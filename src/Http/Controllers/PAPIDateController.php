<?php

namespace Blashbrook\Papi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PAPIDateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static public function getDate()
    {
            return Carbon::now()->format('D, d M Y H:i:s \G\M\T');
    }
}
