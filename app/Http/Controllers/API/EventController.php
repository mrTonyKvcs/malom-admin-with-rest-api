<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Get all events",
     *     tags={"events"},
     *     @OA\Parameter(
     *      name="Authorization",
     *      in="header",
     *      description="Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTViY2I2YzNmMTk3NDI3YTMwMTIxNzk5NjRhZjE1M2Y5NzcwMGI5NTY2MzFlYTdmNTM0YmNlZjM5NTExNDY4ZDkzY2RmNGFkNDY5MTc3ODYiLCJpYXQiOjE2NDc3NzI0MTYuNDgxOTA1LCJuYmYiOjE2NDc3NzI0MTYuNDgxOTA3LCJleHAiOjE2NzkzMDg0MTYuNDcxMDQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.chJLl-gz3k-GuhTXGIbM9oYuzkh5qsnz5rVqBj2gLJg-0YwX0y1Mn5s5YZtutkWx3cQnfRyZ5x38w80ljlKb3zzMrT0X-rW8Kbf8xDdA9xKu6nWBmxZi6L9qMKmp_cCNbarwV_dpQzL9Uv3ALCOi_fgiMiQOr6DO9cMKKhQf--AZ4Zu-xNl6ZkdmjFt0MA1NZ2tT7k7NnoUw8laoYx7P3K3NwIM-jReBNQyCyXuptJwpYuZaeXRe4waA5OZG2SycgQ3LZSbpuXB_qEOtMIkASyCnyVz29OY3-HTNidLMGlfddl0aSheygTvBnk84BzIQlal1NMQnHnw8cN_P8PEtBL9aHcJ2Gs7Zr1WeIzpgQce7wi9Mna_W1Wa1iDYr9GLRatMxCuT853SAN-SdBKK9jGfLzPJPkFzTEqAbQYriduLlYY_BIYsqUndDRSrnl76HSoS1_vIKtNyhKTXWtXwgIXFQBB_CnCbSYWwT34pt4VJ6bSd8Ed2V9yCHubu_wXHi62vfcEhl7aH9g-GybRT9ih-pWE94jAIVwoVK1cNeS4Heh0iLE7KgcHy2bkvQQGinXBALgcsME0Nz-0Lo7kbsG5iG4tMcjvyAkcudKDobJbvo4RCq4_2GvjcvZhUjOI01IkN4B6fkwGvBqtxkfgySh3ZMnVA66-4gqef5CbBkU1E"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get all events"
     *     ),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */  
    public function index()
    {
        $events = Event::orderBy('started_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => EventResource::collection($events)
        ]);
    }
}
