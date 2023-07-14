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
use Mail;
use App\Mail\ResetPassword;
use App\Mail\SendPassword;
use Illuminate\Support\Str;
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
            'profile_photo_path'=> 'nullable|string|max:255'
        ]);
        // $photo = $this->updateProfile($request);
    
        $user_created = User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'status' => $request->status,
            'civility' => $request->civility,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'role' => $request->role,
            'profile_photo_path'=>$request->profile_photo_path
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
            'id'=>'required',
            'profile_photo_path'=> 'nullable|string|max:255'
        ]);
        // $photo = $this->updateProfile($request);
       
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
            'profile_photo_path'=>$request->profile_photo_path
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

    public function updateProfile(Request $request)
    {  
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',]);
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profiles'), $imageName);
            return response()->json([
                'url_path' => 'images/profiles/' . $imageName,
            ], Response::HTTP_OK);
        }
        return response()->json([
            'url_path' => null
        ], Response::HTTP_OK);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);
        $password = Str::random(8);

        $mailData = [
            'password' => $password,
            'host' => env('APP_HOST', '')
        ];

        Mail::to($request->email)->send(new ResetPassword($mailData));

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
        }

        return redirect()->back();
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'id'=>'required'
        ]);
        $password = Str::random(8);

        $mailData = [
            'password' => $password,
            'host' => env('APP_HOST', '')
        ];
        Mail::to($request->email)->send(new SendPassword($mailData));

        $user = User::where('id', $request->id)->first();
        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
           
        }

        return redirect()->back();
    }
}