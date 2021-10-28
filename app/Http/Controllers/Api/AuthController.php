<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function getToken(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);

		/** @var User $user */
		$user = $validated ? User::where(['email' => $request->email, 'admin' => true])->first() : null;
		if (!$validated || !$user || !Hash::check($request->password, $user->getAuthPassword())) {
			return new JsonResponse('error');
		}

		$user->tokens()->where('name', '=', 'app')->delete();

		/** @var PersonalAccessToken $token */
		$token = $user->createToken('spa')->plainTextToken;

		return new JsonResponse($token ? ['token' => $token] : 'error');
	}

}
