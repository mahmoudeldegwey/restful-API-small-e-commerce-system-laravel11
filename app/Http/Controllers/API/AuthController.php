<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
    	try {
		
		    $user = User::where('email', $request->email)->first();
		 
		    if (! $user || ! Hash::check($request->password, $user->password)) {
		        throw ValidationException::withMessages([
		            'email' => ['The provided credentials are incorrect.'],
		        ]);
		    }
		     		
    	} catch (\Exception $e) {
    		return response()->json(['error' => true,'message' => $e->getMessage()]);
    	}

	    return response()->json(['user' => $user, ...['token' => $user->createToken($request->email)->plainTextToken]]);
    }
}
