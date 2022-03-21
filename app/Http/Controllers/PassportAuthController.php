<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\Parameter(
     *  name="Accept",
     *  in="header",
     * description="application/json"
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Login successful",
     *    @OA\JsonContent(
     *       @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmMyZDlkZmU5NGQwMjAxNWY1OGY1OGIzOTdjYWJiMDM1Yjk3NjYxYWNjOGQzMGNhYWM0YWVmMjY3OTNkMmFkMjRmZWM2MWFlMDg3MTYwZTQiLCJpYXQiOjE2NDc4NTMzMTEuMjk1MjAzLCJuYmYiOjE2NDc4NTMzMTEuMjk1MjA2LCJleHAiOjE2NzkzODkzMTEuMjg4MDgzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.ydo4C7nBjG6lFnY6YK5h02Xubu87kZehsbx_bgK63EjfKfdfC0nTsfb5bjl7G795ckMvY6GoqmK25BhKfrlDzWrbfOd0yGz5_uCDod5ODsp9EUybi8S3h6RE8jOFyO-Kv0Yq88AwoMYo_DI2ZMbvHk5wdD5HgFSDEhF4v8vl3d7Jlj50VI48lLpdzkm7Dx-C93QJcvYkX3_oXrvJiAMelWcv0Wed5xqC_s4tLVg81_eI9s2xdPGFSDY74rVZqJ_bcU9HTvXb1FY7-G5Uhc6aAJKG5BCyMrgm5bstw0Z7YwLcGXxkV9FFq4Q9KswcOQrtc2v7IgDRQbCUGJ_QI5vajJzPlUvAHgbqgpfVaeWPIOd7FUpEJ_gV5kTurLqmLBJJOAwF5YUA3CGE7q3xw8MOs-MiLz9ROPPRXeg4zLsw7GPpIRA21PsefFLNQ1JRr0HAclgAurtFuyVLhDbW5mANDxpLRT2AM45ztqWmTJtVfGrnQHB12saRfpepfSwIwrcP6c7t77qS7gm3fcIEtrZOJQ09hkkAAjcAPJ4XuSW_EVFaqeN_UFyceAlZzHBH8KAOloHANL9l1LcD3oiMy7z25Fg2ZvySqnYxq63LP2iQ-ojVxTGjGKzIS1FLQlqwKgGxK3cshdz_iA7qO_XHI17MyELZoDmXjDYhowLWImh59i0")
     *        )
     *     )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   
}