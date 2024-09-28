<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class ApiEventController extends Controller
{
    //

    public function index()
    {
        $events = \App\Models\Event::all();
        return response()->json($events, 200);
    }
}
