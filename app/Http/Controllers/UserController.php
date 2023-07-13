<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Actions\Jetstream\DeleteUser;

class UserController  extends Controller
{
   
    public function getLists () {
        $user = Auth::user();
        $users = User::all();
        return Inertia::render('Users/Lists',[
        'user'=>$user,
        'users'=>$users
        ]);
    }

    public function create(Request $request)
    {
             
        $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|boolean',
            'civility' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);
    
        $user_created = User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'status' => $request->status,
            'civility' => $request->civility,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);
    
    
        return response()->json([
            'user' => $user_created,
        ], Response::HTTP_OK);
    
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'status' => 'required|boolean',
            'civility' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'id'=>'required'
        ]);

        $user = User::findOrFail($request->id);

        $user->update([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'status' => $request->status,
            'civility' => $request->civility,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return response()->json([
            'user' => $user,
        ], Response::HTTP_OK);
    }
    public function deleteUser(User $user)
    {
   // May be there is an error according to jetstream :/
    $user->forceDelete();
        return response()->json([
            
            'user' => $user
        ], Response::HTTP_OK);
    }
}