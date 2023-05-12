<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\throwException;

class AuthController extends Controller
{

    protected function createToken($email, $password): array
    {

        try {
            if (! $token = auth()->attempt([ "email" => $email, "password" => $password ])) {
                return ['success' => false, 'msg' => "invalid credentials"];
            }
        } catch (Exception $e) {
            return ['success' => false, 'msg' => e->getMessage()];

        }
        return ['success' => true, 'token' => $token];
    }

    /**
     * Store a newly created user in storage and return a token session.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse{
        $validatedData = $request->validated();
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->save();

        $response = $this->createToken($validatedData['email'], $validatedData['password']);
        if(!$response['success']) return response()->json(['error' => $response['msg']], 400);
        return $this->respondWithToken($response['token']);
    }

    /**
     * Generate a new token for the session.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request):JsonResponse
    {
        $request = $request->validated();
        $response = $this->createToken($request['email'], $request['password']);
        if(!$response['success']) return response()->json(['error' => $response['msg']], 400);
        return $this->respondWithToken($response['token']);
    }

    /**
     * Return the user data from token session.
     */
    public function me():JsonResponse
    {
        try {
            if (!$user = auth()->user()) {
                return response()->json(['error' => 'user_not_found'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($user);
    }



    /**
     * Destroy token session.
     */
    public function logout():JsonResponse
    {

        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token):JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
