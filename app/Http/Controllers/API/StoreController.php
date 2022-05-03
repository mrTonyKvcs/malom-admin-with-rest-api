<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('api')['secret_key'];
    }

    /**
     * @OA\Get(
     *     path="/api/stores",
     *     summary="Get all stores",
     *     tags={"stores"},
     *     @OA\Parameter(
     *      name="secretkey",
     *      in="header",
     *      description="Example: P6hlLNn9axgOQp9cJCEYKpHZEj7zWpl9"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get all stores"
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
            $stores = Store::query()
                ->exceptions()
                ->get();

            return response()->json([
                'status'   => 200,
                'data'      => StoreResource::collection($stores)
            ]);
        }

        return response()->json([
            'status'   => 401,
            'error'      => 'Invalid secret key!'
        ]);
    }
    
    public function show(Request $request, $id)
    {
        $headerSecretKey = $request->header('secretkey');

        if ($this->secretKey === $headerSecretKey) {
            $store = Store::where('id', $id)->get();

            return response()->json([
                'status'   => 200,
                'data'      => StoreResource::collection($store)
            ]);
        }

        return response()->json([
            'status'   => 401,
            'error'      => 'Invalid secret key!'
        ]);
    }
}