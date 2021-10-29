<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
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
