<?php

namespace App\Http\Controllers\API;

#use Illuminate\Http\Request;
use App\User;
use App\Admin;
use App\Member;
use App\Scheme_member;
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
		/****
		$a = mt_rand(100000,999999);
		Cache::put('myCache', $a, 2);
		$x = Cache::get('myCache');
		dd($x);
		*****/
		$a = mt_rand(100000,999999);
		Cache::put('myCache', $a, 10);
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

	public function join(Request $request)
	{
		$data = Scheme_member::create([
			'scheme' => $request['scheme'],
			'name' => $request['name'],
			'email' => $request['email'],
			'phone' => $request['phone'],
			'amount' => $request['amount'],
		]);
		Member::where('email', $email)->update([
                'active' => 1,
		
		return response()->json(compact('data'),200);
	}

	public function MyScheme()
	{
	#::::::::::::GET THE EMAIL FROM YOUR END::::::::::::::::::
		$email = \Auth::user()->email;
		#::::::::::::GET THE EMAIL FROM YOUR END::::::::::::::::::
		$scheme = Member::where('email', $email)->get();
		return response()->json(compact('scheme'),200);
	}

	public function view_members(Request $request)
	{
		$name = $request['name'];
		$data = Member::where('scheme', $name)->get();
		return response()->json(compact('data'),200);
	}

	public function join(Request $request)
	{
		
		Scheme_member::create([
			'scheme' => $request['scheme'],
			'name' => $request['name'],
			'email' => $request['email'],
			'phone' => $request['phone'],
			'amount' => $request['amount'],
		]);
		$data = ('info','you have been sucessfully registered as an active member of '.$request["scheme"].' scheme');
		return response()->json(compact('data'),200);
	}

	public function verifynow(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email'=>  'email',
			'token'=>  'required',
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}
		$x = Cache::get('myCache');

		if ($request->token == $x) {
			$email = $request->email;
			User::where('email', $email)->update([
				'confirm' => 2, 
			]); 
			$data = 'email confirmed';
			return response()->json(compact('data'),200);
		}
		else{
			return response()->json(['incorrect token'], 404);
		}

	}

	public function chk_scheme(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'scheme'=>  'required',
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 200);
		}
		#:::GET THE EMAIL FROM YOUR END:::
		$email = \Auth::user()->email;
		$scheme = $request['scheme'];

		$data = Member::where('scheme', $scheme)
		->where('email', $email)->get();

		if (!$data->isEmpty()) 
		{
 			$chk = Scheme_member::where('scheme', $scheme)
			->where('email', $email)->get();
			if (!$chk->isEmpty()) {
				$data = ('you are already a member of this scheme');
				return response()->json(compact('data'),200);
			}
			else{

				$data = Member::where('scheme', $scheme)->get();
				return response()->json(compact('data'),200);
			}
		}
		else{
			return response()->json(['no record found'], 404);
		}

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

	public function RegMember(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'Name'=>  'required',
			'email'=>  'required',
			'phone'=>  'required'
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
		}
		for ($i=0; $i < count($email); $i++) { 
			Member::create([
				'name' => $name[$i],
				'email' => $email[$i],
				'phone' => $phone[$i],
				'scheme' => $request['Scheme'],
				'amount' => $request['amount'],
			]);
		}
        #:::::::::::GET THE NAME OF THE USER AND SAVE IN $inv:::::::::::::
		$inv = \Auth::user()->name;
         #:::::::::::GET THE NAME OF THE USER AND SAVE IN $inv:::::::::::::

        #::::::::::SENDING MAIL TO EACH SCHEME MEMBERS::::::::::::::
		$message = 'by '.$inv.'. the group will be contriuting NGN'.$request['amount'].' per week which will be disbussed to selected members every week in a round robin format. Login using the link below in order to join new members of the scheme';
		Mail::to($request['email'])->send(new Members_mail($message));

		return response()->json(compact($request->all()),201);
	}


}
