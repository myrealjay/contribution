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
use App\Detail;
use App\Payday;
use App\Bvndata;
use App\Bvnpayment;

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
			'platform'=>$request->platform,
		]);
		Mail::to($request['email'])->send(new SendMailable($message));
		
		$token = JWTAuth::fromUser($user);

		return response()->json(compact('user','token'),200);
	}

	public function getUnallocatedDays(Request $request){
		$scheme=$request->scheme;
		$members=Scheme_member::where('scheme',$scheme)->get();
		$num=count($members);
		$data=Payday::where('scheme',$scheme)->skip(0)->take($num)->get();
		
		$paydays=[];

		foreach($data as $payday){
			if($payday->active==1) array_push($paydays,$payday->payday);
		}

		return response()->json(compact('paydays'),200);
	}

	public function updatePayDay(Request $request){
		$scheme=$request->scheme;
		$payday=$request->payday;
		$email=$request->email;
		$oldPayDay=$request->oldPayDay;

		$x = date('Y-m-d', time());
		$date = date('Y-m-d', strtotime($x . " +96 hours"));

		if($payday < $date){
			return response()->json(['error'=>'Sorry the date cannot be chosen']);
		}

		$member=Scheme_member::where([['scheme','=',$scheme],['email','=',$email]])->first();
		$member->update(['payday'=>$payday]);

		$data=Payday::where([['scheme','=',$scheme],['payday','=',$payday]])->first();
		$data->update(['active'=>0]);
		
		$data2=Payday::where([['scheme','=',$scheme],['payday','=',$oldPayDay]])->first();
		$data2->update(['active'=>1]);

		return response()->json(['message'=>'Payday changed successfully']);
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

		$num_of_members=$request['Members'];
		$paydays=$request->paydays;
		
		//reformart the dates
		$startDate=date_format(date_create($request->startdate),"Y-m-d");
		$endDate=date_format(date_create($request->enddate),"Y-m-d");
		$selpayday=date_format(date_create($request->selpayday),"Y-m-d");

		foreach($paydays as $payday){
			Payday::create([
				'scheme' => $request['Name'],
				'payday' => date_format(date_create($payday),"Y-m-d"),
			]);
		}

		$data = Admin::create([
			'Name' => $request['Name'],
			'Amount' => $request['Amount'],
			'Members' => $request['Members'],
			'creator'=>$email,
			'startdate'=>$startDate,
			'enddate'=>$endDate
		]);

		//register the scheme creator
		#:::::COLLECT THE BELOW DATA::::::
		$name = \Auth::user()->name;
		$phone = \Auth::user()->phone;

		Member::create([
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'scheme' => $request['Name'],
			'amount' => $request['Amount'],
			'expire' => $startDate,
			'creator' => $email,
			'active'=>1
		]);

		#:::::HERE THE SCHEME CREATOR IS THE FIRST ACTIVE MEMBER OF THE SCHEME::::::::
		Scheme_member::create([
			'scheme' => $request['Name'],
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'amount' => $request['Amount'],
			'expire' => $startDate,
			'payday' => $selpayday,
		]);

		//deselect the payday selected by this user

		$payday=Payday::where([['scheme','=',$request['Name']],['payday','=',$selpayday]])->first();

		$payday->update(['active'=>0]);

		
		return response()->json(compact('data'),200);
	}

	public function join(Request $request)
	{
		$date;
		$member=DB::table('scheme_members')->orderBy('id', 'desc')->where('scheme',$request['scheme'])->first();
		//$x = $member->payday;
		$date =$request->payday; //date('Y-m-d H:i:s', strtotime($x . " +168 hours"));
		
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
		$data2=Payday::where([['scheme','=',$request['scheme']],['payday','=',$date]])->first();
		$data2->update(['active'=>0]);
	

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

	public function getPayDays($num,Request $request){
		$scheme=$request->scheme;

		$paydays=Payday::where([['scheme','=',$scheme],['active','=',1]])->pluck('payday');;
		return response()->json(compact('paydays'));
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

		$registered=Admin::where([['Name','=',$request['scheme']],['mem_added','=',1]])->first();
		if($registered){
			return response()->json(['error'=>'Scheme member already added'], 200);
		}

		$registered2=Admin::where('Name',$request['scheme'])->first();
		$date='';
		if($registered2){
			$date=$registered2->startdate;
		}

		if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 200);
		}
		
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

		#::::UPDATE THE ADMIN TABLE TO SHOW THAT MEMBERS HAVE BEEN ADDED::::::
		Admin::where('creator', \Auth::user()->email)->where('Name',$request['scheme'])->update([
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

		public function pay(Request $request)
		{
			$input=$request->except('authcode');
			//check for the week the person is paying
			$week=count(Detail::where('scheme_member_id',$request->scheme_member_id)->get())+1;
			$input['week']=$week;
			$payment=Detail::create($input);

			$authcode=$request->authcode;

			$user=\Auth::user();
			$user->update([
				'authorization_token'=>$authcode
			]);
			if($payment){
				return response()->json(compact('payment'));
			}
			return response()->json(['error'=>'Payment was not successful']);
		}

		public function getPayment($scheme){
			$payments=DB::table('details')->orderBy('week')->where('scheme',$scheme)->get();
			$payment=[];
			foreach($payments as $pay){
				$member=Scheme_member::where('id',$pay->scheme_member_id)->first();
				$data=[];
				array_push($data,$pay);
				array_push($data,$member);
				array_push($payment,$data);
			}
			return response()->json(compact('payment'));
		}

		public function getSchemeMember($scheme){
			$user=\Auth::user();
			$email=$user->email;
			$member=Scheme_member::where([['scheme','=',$scheme],['email','=',$email]])->first();
			return response()->json(compact('member'));
		}

	public function getBvn(Request $request)
	{
		//Initialization Code
		$curl = curl_init();

		$bvn = $request->bvn;  

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/bank/resolve_bvn/".$bvn,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => json_encode([
			'bvn'=>$bvn
			]),
			CURLOPT_HTTPHEADER => [
			"authorization: Bearer sk_test_7886fc90b896993395fbc27c623cacdf2bbf0bf6", //replace this with your own test key
			"content-type: application/json",
			"cache-control: no-cache"
			],
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
			// there was an error contacting the Paystack API
			return response()->json(['error'=>$err],200);
		}

		$tranx = json_decode($response, true);

		if($tranx['status']==false){
			return response()->json(['error'=>'unable to resolve bvn'],200);
		}

		$user=\Auth::user();
		
		if($tranx['data']){
			$checker=Bvndata::where('user_id',$user->id)->first();
			if(!$checker){
				Bvndata::create(
					[
						"firstname"=>$tranx['data']['first_name'],
						"lastname"=>$tranx['data']['last_name'],
						"dob"=>$tranx['data']['formatted_dob'],
						"phone"=>$tranx['data']['mobile'],
						"user_id"=>$user->id,
					]
				);
			}
		}

		return response()->json(['success'=>'bvn was successfuly accessed'],200);
	}

	public function checkBvn(){
		$user=\Auth::user();
		$bvndata=Bvndata::where('user_id',$user->id)->first();
		if($bvndata){
			return response()->json(['success'=>'bvn has been saved'],200);
		}
		return response()->json(['error'=>'bvn was not found'],200);
	}

	public function makeBvnPayment(Request $request){
		$user=\Auth::user();
		$amount=$request->amount;
		$authcode=$request->authcode;
		$scheme=$request->scheme;

		$user->update([
			"authorization_token"=>$authcode
		]);

		Bvnpayment::create([
			"user_id"=>$user->id,
			"amount"=>$amount,
			"scheme"=>$scheme
		]);
		return response()->json(['success'=>'payment was successfully made'],200);
	}

	public function checkBvnPayment(Request $request){
		$user=\Auth::user();
		$scheme=$request->scheme;
		$bvndata=Bvnpayment::where([['user_id','=',$user->id],['scheme','=',$scheme]])->first();
		if($bvndata){
			return response()->json(['success'=>'bvn has been saved'],200);
		}
		return response()->json(['error'=>'bvn was not found'],200);
	}


}
