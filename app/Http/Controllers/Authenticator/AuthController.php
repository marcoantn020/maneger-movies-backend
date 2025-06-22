<?php

namespace App\Http\Controllers\Authenticator;

use App\Http\Controllers\Authenticator\Service\ServiceAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    public function __construct(
        protected ServiceAuth $serviceAuth
    )
    {}

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['E-mail e/ou senha inválidos'],
            ]);
        }

        return $this->respondWithToken($token);
    }

    public function me(): UserResource
    {
        $userLogged = Auth::guard('api')->user();
        return new UserResource($userLogged);
    }

    public function logout(): JsonResponse
    {
        Auth::guard('api')->logout();
        return response()->json(data: ['message' => 'Deslogado com sucesso',]);
    }

    public function refresh()
    {
        try {
            return $this->respondWithToken(Auth::guard('api')->refresh());
        } catch (TokenBlacklistedException $e) {
            return response()->json(['error' => 'Este token já foi usado e não é mais válido. Faça login novamente.'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expirado. Faça login novamente.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido.'], 401);
        }
    }

    private function respondWithToken($token)
    {
        $user = Auth::guard('api')->user();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
            'user_name'    => "$user->first_name $user->last_name",
            'photo'    => $user->photo ? asset('storage/' . $user->photo) : null,
        ]);
    }

    public function signup(CreateUserRequest $request)
    {
        $user = $this->serviceAuth->createUser($request->validated());
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = Auth::guard('api')->user();
        $isUpdated = $this->serviceAuth->updateUser($user, $request->validated());
        return response()->json(['data' => $isUpdated], Response::HTTP_ACCEPTED);
    }
}
