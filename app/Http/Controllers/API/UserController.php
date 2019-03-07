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
use DB;

class UserController extends Controller
{
	public function authenticate(Request $request)
	{
		$credentials = $request->only('email', 'password');

		try {
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 200);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 200);
		}
		$user = \Auth::user();
		if(!($user->confirm==2)){
			return response()->json(['error' => 'user not confirmed','token'=>$token], 200);
		}

		return response()->json(compact('token'));
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string',
			'phone' => ['required', 'string', 'min:11'],
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 200);
		}

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

		return response()->json(compact('user','token'),200);
	}

	public function new_scheme(Request $request)
	{
		$email=\Auth::user()->email;
		$validator = Validator::make($request->all(), [
			'Name'=>  'required|unique:admins',
			'Amount'=>  'required',
			'Members'=>  'required'
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 200);
		}
		if($request['Members']<5){
			return response()->json(['error'=>'This scheme can take a minimum of 5 members'], 200);
		}
		$data = Admin::create([
			'Name' => $request['Name'],
			'Amount' => $request['Amount'],
			'Members' => $request['Members'],
			'creator'=>$email
		]);
		
		return response()->json(compact('data'),200);
	}

	public function join(Request $request)
	{
		$date;
		$member=DB::table('scheme_members')->orderBy('id', 'desc')->first();
		$x = $member->payday;
		$date = date('Y-m-d H:i:s', strtotime($x . " +168 hours"));
		
		$data = Scheme_member::create([
			'scheme' => $request['scheme'],
			'name' => $request['name'],
			'email' => $request['email'],
			'phone' => $request['phone'],
			'amount' => $request['amount'],
			'payday' => $date,
		]);
		$email=$request['email'];
		Member::where('email', $email)->where('scheme',$request['scheme'])->update([
			'active' => 1,
		]);

		return response()->json(['message'=>'successfully joined'],200);
	}

	public function MyScheme()
	{
	#::::::::::::GET THE EMAIL FROM YOUR END::::::::::::::::::
		$email = \Auth::user()->email;
		#::::::::::::GETTING THE SCHEME I CREATED::::::::::::::::::
		$my_scheme = Admin::where('creator', $email)->get();
		$scheme = Member::where([['email',"=", $email],['creator','!=',$email]])->get();
		return response()->json(compact('my_scheme','scheme'),200);
	}

	public function verifynow(Request $request)
	{
		$validator = Validator::make($request->all(), [
			
			'token'=>  'required',
		]);

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 200);
		}
		$x = Cache::get('myCache');

		if ($request->token == $x) {
			User::where('id',\Auth::user()->id)->update([
				"confirm"=>2
			]);
			return response()->json(['message'=>'successful'],200);
		}
		else{
			return response()->json(['incorrect token'], 200);
		}
		
	}

	public function getAuthenticatedUser()
	{
		try {

			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 200);
			}

		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

			return response()->json(['token_expired'], 200);

		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

			return response()->json(['token_invalid'], 200);

		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

			return response()->json(['token_absent'], 200);

		}

		return response()->json(compact('user'));

	}

		public function RegMember(Request $request)
		{
			$validator = Validator::make($request->all(), [
				'name'=>  'required',
				'email'=>  'required',
				'phone'=>  'required'
			]);

			$email=$request->email;
			$phone=$request->phone;
			$name=$request->name;
			$useremail = \Auth::user()->email;

			if($validator->fails()){
				return response()->json($validator->errors()->toJson(), 200);
			}

			$x = date('Y-m-d H:i:s', time());
			$date = date('Y-m-d H:i:s', strtotime($x . " +48 hours"));
			
			for ($i=0; $i < count($email); $i++) { 
				Member::create([
					'name' => $name[$i],
					'email' => $email[$i],
					'phone' => $phone[$i],
					'scheme' => $request['scheme'],
					'amount' => $request['amount'],
					'expire' => $date,
					'creator' => $useremail,
				]);
			}
		#:::::COLLECT THE BELOW DATA::::::
			$name = \Auth::user()->name;
			$email = \Auth::user()->email;
			$phone = \Auth::user()->phone;
			$PayDate = date('Y-m-d H:i:s', strtotime($x . " +672 hours"));

			Member::create([
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'scheme' => $request['scheme'],
				'amount' => $request['amount'],
				'expire' => $date,
				'creator' => $useremail,
			]);
    #:::::HERE THE SCHEME CREATOR IS THE FIRST ACTIVE MEMBER OF THE SCHEME::::::::
			Scheme_member::create([
				'scheme' => $request['scheme'],
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'amount' => $request['amount'],
				'expire' => $date,
				'payday' => $PayDate,
			]);
	
	
    #::::THE SCHEME CREATOR SHOULD BE AN ACTIVE MEMBER::::::
		Member::where('email', $email)->where('scheme',$request['scheme'])->update([
			'active' => 1, 
		]); 

			#::::UPDATE THE ADMIN TABLE TO SHOW THAT MEMBERS HAVE BEEN ADDED::::::
			Admin::where('creator', $email)->where('Name',$request['scheme'])->update([
                'mem_added' => 1, 
            ]); 
    
        #:::::::::::GET THE NAME OF THE USER AND SAVE IN $inv:::::::::::::
		$inv = \Auth::user()->name;
         #:::::::::::GET THE NAME OF THE USER AND SAVE IN $inv:::::::::::::

        #::::::::::SENDING MAIL TO EACH SCHEME MEMBERS::::::::::::::
			/*$message = 'by '.$inv.'. the group will be contriuting NGN'.$request['amount'].' per week which will be disbussed to selected members every week in a round robin format. Login using the link below in order to join new members of the scheme';
			Mail::to($request['email'])->send(new Members_mail($message));*/

			return response()->json(['message'=>'members added successfully'],200);
		}


		public function getSchemeMembers($scheme){
			$members=Member::where('scheme',$scheme)->get();
			return response()->json(compact('members'));
		}

		public function checkJoined($scheme){
			$user=\Auth::user();
			$member=Member::where([['scheme',"=",$scheme],["email","=",$user->email]])->get()->first();
			if($member){
				return response()->json(["message"=>$member->active]);
			}
			return response()->json(['error'=>"member not found"]);
		}

		public function getActiveMembers($scheme){
			$members=Scheme_member::where('scheme',$scheme)->get();
			return response()->json(compact('members'));
		}


}
