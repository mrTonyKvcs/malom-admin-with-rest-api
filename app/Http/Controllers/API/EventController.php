<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('api')['secret_key'];
    }

    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Get all events",
     *     tags={"events"},
     *     @OA\Parameter(
     *      name="secretkey",
     *      in="header",
     *      description="Example: P6hlLNn9axgOQp9cJCEYKpHZEj7zWpl9"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get all events"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid secret key"
     *     ),
     * )
     */  
    public function index(Request $request)
    {
        $headerSecretKey = $request->header('secretkey');

        if ($this->secretKey === $headerSecretKey) {
            $events = Event::orderBy('started_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data'    => EventResource::collection($events)
            ]);
        }

        return response()->json([
            'status'   => 401,
            'error'      => 'Invalid secret key!'
        ]);
    }
}
