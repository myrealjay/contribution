<?php

namespace App\Http\Controllers;

use App\Admin;
use Mail;
use App\Member;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Mail\Members_mail;

class AdminController extends Controller
{
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
            'token'=>  'required'
        ]);
        if ($request->token == $x) {
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
        ]);

         Session::put('Scheme', $request['Name']);
         Session::flash('info','Registration successful');
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
        $Scheme = admin::all();
        return view('admin.MyScheme')->with('admin', $Scheme);
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

        for ($i=0; $i < count($email); $i++) { 
            Member::create([
            'name' => $name[$i],
            'email' => $email[$i],
            'phone' => $phone[$i],
            'scheme' => $request['Scheme'],
            'amount' => $request['amount'],
        ]);
        }
        
        $inv = \Auth::user()->name;

        #::::::::::SENDING MAIL TO EACH SCHEME MEMBERS::::::::::::::
        $message = 'by '.$inv.'. the group will be contriuting NGN'.$request['amount'].' per week which will be disbussed to selected members every week in a round robin format. Login using the link below in order to join new members of the scheme';
       Mail::to($request['email'])->send(new Members_mail($message));

         Session::flash('info','Registration successful');
            return redirect('/home');
    }

    
}
