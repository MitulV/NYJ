<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'type' => ['required', 'string', 'in:user,organizer']
        ]);

        $user = User::where('email', $request->email)->with('profile')->first();

        if (!$user ||  !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'UnAuthenticated'], 401);
        }

        if($request->input('type')=='user' && $user->isOrganizer()){
            return response()->json(['error' => 'Invalid Inputs'], 401);
        }else if($request->input('type')=='organizer' && $user->isUser()){
            return response()->json(['error' => 'Invalid Inputs'], 401);
        }

        $SECRET = env("SENCTUM_SECRET", "APP_SECRET");
        $token = $user->createToken($SECRET)->plainTextToken;


        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        /** @var User|null $user */
        $user = auth()->user();
        
        $user->tokens()->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
