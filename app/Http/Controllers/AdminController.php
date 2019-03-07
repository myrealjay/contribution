<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Mail;
use App\Member;
use App\Scheme_member;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Mail\Members_mail;

class AdminController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function confirm()
    {
        $x = Cache::get('myCache');
        return view('admin.verify',compact('x'));
    }

    public function verifynow(Request $request)
    {
        $x = Cache::get('myCache');
        $this->validate($request,[
            'email'=>  'email',
            'token'=>  'required',
        ]);
        if ($request->token == $x) {
            $email = $request->email;
            User::where('email', $email)->update([
                'confirm' => 2, 
            ]); 
            Session::flash('info','Token is correct');
            return redirect('/home');
        }
        else{
            Session::flash('info','Token incorrect');
            return redirect()->back();
        }
    }

    public function new_scheme()
    {
        return view('admin.new_scheme');
    }

    public function reg_scheme(Request $request)
    {
        $this->validate($request,[
            'Name'=>  'required|unique:admins',
            'Amount'=>  'required',
            'Members'=>  'required'
        ]);

        Admin::create([
            'Name' => $request['Name'],
            'Amount' => $request['Amount'],
            'Members' => $request['Members'],
            'creator' => $request['Email'],
        ]);

        Session::put('Scheme', $request['Name']);
        Session::flash('info','Registration successful');
        return redirect('/AddMembers');
    }

    public function add_mem(Request $request)
    {
        $name = $request['name'];
        Session::put('Scheme', $name);
        return redirect('/AddMembers');
    }

    public function AddMembers()
    {
        $chk = Session::get('Scheme');
        $data = Admin::where('Name', $chk)->get();
        return view('admin.AddSchemeMembers', compact('data'));
    }

    public function MyScheme()
    {
        $email = \Auth::user()->email;
        $Scheme = Member::where('email', $email)->get();
        $my_scheme = Admin::where('creator', $email)->get();
        return view('admin.MyScheme', compact('Scheme'), compact('my_scheme'));
    }

    public function view_members(Request $request)
    {
        $name = $request['name'];
        Session::put('Scheme', $name);
        $data = Member::where('scheme', $name)->get();
        return view('admin.SchMember', compact('data'));
    }

    public function chk_scheme(Request $request)
    {
        $this->validate($request,[
            'scheme'=>  'required'
        ]);
        $email = \Auth::user()->email;
        $scheme = $request['scheme'];

        $data = Member::where('scheme', $scheme)
        ->where('email', $email)->get();

        if (!$data->isEmpty()) 
        {
            $chk = Scheme_member::where('scheme', $scheme)
            ->where('email', $email)->get();
            if (!$chk->isEmpty()) {
             Session::flash('not_found','you are already a member of this scheme');
             return redirect('/home');
         }
         else{
            #::::::GETTING THE PAY DATE OF THE LAST PERSON ON THE LIST::::::
            $day = Scheme_member::where('scheme', $scheme)
            ->orderBy('id', 'desc')->first();
        #    dd($day->payday);

            Session::put('scheme', $scheme);
            $data = Member::where('scheme', $scheme)->get();
            return view('admin.join', compact('data'), compact('day'));
        }
    } 
    else 
    {
        Session::flash('not_found','no record found');
        return redirect('/home');
    }

}

public function RegMember(Request $request)
{
    $this->validate($request,[
        'email'=>  'required',
        'phone'=>  'required'
    ]);
    #    dd($request->all());
    $email = $request['email'];
    $phone = $request['phone'];
    $name = $request['name'];

    #::::EXPIRE DATE:::::
    $x = date('Y-m-d H:i:s', time());
    $date = date('Y-m-d H:i:s', strtotime($x . " +48 hours"));
    #:::::CREATOR'S EMAIL:::::
    $creator = \Auth::user()->email;
    for ($i=0; $i < count($email); $i++) { 
        Member::create([
            'name' => $name[$i],
            'email' => $email[$i],
            'phone' => $phone[$i],
            'scheme' => $request['Scheme'],
            'amount' => $request['amount'],
            'expire' => $date,
            'creator' => $creator,
        ]);
    }
    #:::GETTING THE DATE FIRST MEMBER WILL BE PAID:::::
    $PayDate = date('Y-m-d H:i:s', strtotime($x . " +672 hours"));
    #:::::COLLECT THE BELOW DATA::::::
    $name = \Auth::user()->name;
    $email = \Auth::user()->email;
    $phone = \Auth::user()->phone;
    #:::::HERE THE SCHEME CREATOR IS THE FIRST ACTIVE MEMBER OF THE SCHEME::::::::
    Scheme_member::create([
        'scheme' => $request['Scheme'],
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'payday' => $PayDate,
        'amount' => $request['amount'],
    ]);
    #::::THE SCHEME CREATOR SHOULD BE AN ACTIVE MEMBER::::::
    Member::where('email', $email)->update([
        'active' => 1, 
    ]); 

    #::::UPDATE THE ADMIN TABLE TO SHOW THAT MEMBERS HAVE BEEN ADDED::::::
    Admin::where('creator', $email)->update([
        'mem_added' => 1, 
    ]); 

    $inv = \Auth::user()->name;

        #::::::::::SENDING MAIL TO EACH SCHEME MEMBERS::::::::::::::
    $message = 'by '.$inv.'. the group will be contriuting NGN'.$request['amount'].' per week which will be disbussed to selected members every week in a round robin format. Login using the link below in order to join new members of the scheme';
    Mail::to($request['email'])->send(new Members_mail($message));

    Session::flash('info','Scheme registration successful');
    return redirect('/home');
}

public function join(Request $request)
{
    Scheme_member::create([
        'scheme' => $request['scheme'],
        'name' => $request['name'],
        'email' => $request['email'],
        'phone' => $request['phone'],
        'amount' => $request['amount'],
        'payday' => $request['payday'],
    ]);
    Member::where('email', $request['email'])->update([
        'active' => 1, 
    ]); 
    Session::flash('info','you have been sucessfully registered as an active member of '.$request["scheme"].' scheme');
    return redirect('/home');
}


}
