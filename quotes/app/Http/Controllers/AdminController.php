<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getLogIn(){

        return view('admin.login');

    }

    public function getLogout(){

        Auth::logout();
        return redirect()->route('index');
    }

    public function getDashboard(){
//     autentifikacija uradjena u rutama
//        if(!Auth::check()){
//            return redirect()->back();
//        }
        $authors = Author::all();
        return view('admin.dashboard',compact('authors'));

    }

    public function postLogIn(Request $request){

        $this->validate($request,[
            'name'      => 'required',
            'password'  => 'required'
        ]);
        if(!Auth::attempt(['name'=>$request['name'], 'password'=>$request['password']])){
            return redirect()->back()->with(['fail'=>'Could not log in!']);
        }
        return redirect()->route('admin.dashboard');
    }
}
