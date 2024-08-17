<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $user->sendRegistrationEmailNotification();
        // $user->sendEmailVerificationNotification();


        return $this->success([
            "user" => $user,
            "token" => $user->createToken('API Token of' . $user->token)->plainTextToken
        ]);

    }

    public function requestVerificationEmail(User $user) {
        if (!$user) {
            return $this->error(null, [
                "message"=> "Invalid id"
            ], 404);
        }
        $user->sendEmailVerificationNotification();

        return $this->success([
            "message"=> "Email verification sent successfully"
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error("", "Credentials do not match", 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            "user" => $user,
            "token" => $user->createToken("Api Token of " . $user->name)->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
         Auth::user()->currentAccessToken()->delete();

         return $this->success([
            "message"=> "You have successfully been logged out and your token has been deleted"
         ]);
    }

    public function verify($id)
    {
        $user = User::find($id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return $this->success([
            "message"=> "Email verified succesfully"
        ]);
    }
}