<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = [];
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $users = User::where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                ->get();
        } else {
            $users = User::all();
        }

        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required',
        //         'email' => 'required|email|unique:users',
        //     ],
        //     [
        //         'name.required' => 'Name field is required',
        //         'email.required' => 'Email field is required',
        //     ]
        // );

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()->all()], 422);
        // }

        User::insert($request->only([
            'name',
            'email'
        ]));

        return response()->json(
            [
                'message' => 'User added',
                'success' => true
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user->load('albums', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $user->update($request->only([
            'email',
            'name'
        ]));

        return response()->json(
            [
                'message' => 'User updated',
                'success' => true
            ],
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(
            [
                'message' => 'User deleted',
                'success' => true
            ],
            200
        );
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $user = User::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
            ->get();
        return response()->json($user);
    }
}
