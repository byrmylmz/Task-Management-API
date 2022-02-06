<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   

   public function __construct()
   {
    // $this->middleware('permission:see boards')->only('index');
    // $this->middleware('permission:create boards')->only('store');
    // $this->middleware('permission:updateAll boards')->only('updateAll');
    // $this->middleware('permission:update boards')->only('update');
    // $this->middleware('permission:delete boards')->only('destroy');
   } 

   public function index()
   {
       return UserResource::collection(User::paginate(10));
   }

   public function show(User $user)
   {
       return new UserResource($user);
   }

   public function users()
   {
       return new UserResource(Auth::user());
   }

}
