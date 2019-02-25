<?php

namespace App\Http\Controllers\API;

#use Illuminate\Http\Request;
use App\User;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class UserController extends Controller
{
	public function authenticate(Request $request)
	{
		$credentials = $request->only('email', 'password');

		try {
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 400);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

		return response()->json(compact('token'));
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
			'phone' => ['required', 'string', 'min:11'],
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}
	
		$a = mt_rand(100000,999999);
        Cache::put('myCache', $a, 2);
        $x = Cache::get('myCache');
        $message = $x;
       $user = User::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => Hash::make($request->get('password')),
			'phone' => $request->get('phone'),
		]);
       Mail::to($request['email'])->send(new SendMailable($message));
		
		$token = JWTAuth::fromUser($user);

		return response()->json(compact('user','token'),201);
	}

	public function new_scheme(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'Name'=>  'required|unique:admins',
            'Amount'=>  'required',
            'Members'=>  'required'
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}
       $data = Admin::create([
			'Name' => $request['Name'],
            'Amount' => $request['Amount'],
            'Members' => $request['Members'],
		]);
		
		return response()->json(compact('data'),201);
	}

	public function getAuthenticatedUser()
	{
		try {

			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}

		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

			return response()->json(['token_expired'], $e->getStatusCode());

		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

			return response()->json(['token_invalid'], $e->getStatusCode());

		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

			return response()->json(['token_absent'], $e->getStatusCode());

		}

		return response()->json(compact('user'));
	}

}
