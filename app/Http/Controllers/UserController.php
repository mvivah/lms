<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:20',
            'gender' => 'required|string|max:10',
            'birthdate' => 'required|date|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20',
        ]);
        User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'created_by'=>Auth::user()->id
        ]);
        return ['success','User added succesfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return User::findOrFail($user->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return User::findOrFail($user->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // return $request;
        $data = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'email' => 'required|string|email',
            'phone' => 'required|string',
        ]);

        $user->update([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'updated_by'=>Auth::user()->id
        ]);

        return['success','User Updated Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ['success','User Deleted succesfully !'];
    }
}
