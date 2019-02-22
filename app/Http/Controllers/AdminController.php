<?php

namespace App\Http\Controllers;

use App\Admin;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

         Session::flash('info','Registration successful');
            return redirect('/new_scheme');
    }

    public function MyScheme()
    {
        $Scheme = admin::all();
        return view('admin.MyScheme');
    }

    
}
