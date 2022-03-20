<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('started_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => EventResource::collection($events)
        ]);
    }
}
