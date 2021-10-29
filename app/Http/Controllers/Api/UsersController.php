<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(): Response
	{
		//TODO pagination
		return new Response(User::where('admin', 'NOT', true)->get());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request): Response
	{
		// Changing name
		if ($request->name) {
			$validated = $request->validate([
				'name' => 'required',
				'id' => 'required|numeric'
			]);

			/** @var User $user */
			$user = $validated ? User::find((int)$request->id) : null;

			if ($validated && $user) {
				$user->name = $request->name;
				$user->save();
				return new Response('Name changed', 200);
			}
			return new Response('error', 400);
		}

		// Changing password
		if ($request->password) {
			$validated = $request->validate([
				'password' => 'required',
				'id' => 'required|numeric'
			]);

			/** @var User $user */
			$user = $validated ? User::find((int)$request->id) : null;

			if ($validated && $user) {
				$user->password = Hash::make($request->password);
				$user->save();
				return new Response('Password changed', 200);
			}
			return new Response('error', 400);
		}
		return new Response('error', 400);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function show(int $id): Response
	{
		$user = User::find($id);
		return new Response($user ?? 'error', $user ? 200 : 400);
	}

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param Request $request
//     * @param  int  $id
//     * @return Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy(int $id): Response
	{
		$user = User::find($id);
		if ($user) {
			$user->delete();
		}
		return new Response();
	}
}
