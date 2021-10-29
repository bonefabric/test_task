<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;

class PaymentsController extends Controller
{

	/**
	 * @param int $id
	 * @return Response
	 */
	public function list(int $id): Response
	{
		/** @var User $user */
		$user = User::find($id);
		return new Response($user ? $user->payments()->withTrashed()->get() : 'error', $user ? 200 : 400);
	}

}
