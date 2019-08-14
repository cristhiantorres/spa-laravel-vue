<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
  /** 
   * A list the users
   * 
   * @return UserResource 
   */ 
  public function index()
  {
    return UserResource::collection(User::paginate(10));
  }


  /** 
   * Get user
   * 
   * @return UserResource
   */
  public function show(User $user)
  {
    return new UserResource($user);
  }

  /**
   * Update user
   * 
   * @return UserResource
  */
  public function update(User $user, Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|email'
    ]);

    $user->update($data);

    return new UserResource($user);
  }

  /**
   * Delete user
   * 
   * @return null
  */
  public function destroy(User $user)
  {
    $user->delete();

    return response(null, 204);
  }

  public function create(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:8',
    ]);

    return new UserResource(User::create([ 
      'name' => $data['name'], 
      'email' => $data['email'], 
      'password' => bcrypt($data['password']) 
    ]));
    
  }

}
