<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishRequest;
use App\Models\Wish;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class WishController extends Controller
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('api')['secret_key'];
    }

    /**
     * @OA\Get(
     *     path="/api/wish",
     *     summary="post wish",
     *     tags={"wish"},
     *     @OA\Parameter(
     *      name="secretkey",
     *      in="header",
     *      description="Example: P6hlLNn9axgOQp9cJCEYKpHZEj7zWpl9"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid secret key"
     *     ),
     * )
     */
    public function store(WishRequest $request)
    {
        $headerSecretKey = $request->header('secretkey');

        if ($this->secretKey === $headerSecretKey) {
            try {
                Wish::create(array_merge($request->all(), ['phone_number' => $request->phoneNumber]));
            } catch (Exception $e) {
                throw new HttpResponseException(response()->json([
                    'success'   => false,
                    'message'   => 'Error',
                    'data'      => $e->errorInfo[2]
                ], 500));
            }
        } else {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Error',
                'data'      => ['Invalid secret key']
            ], 401));
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success',
            'data'      => 'Sikeresen elküldted kívánságod!',
        ]);
    }
}
