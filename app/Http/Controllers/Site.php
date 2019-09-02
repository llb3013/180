<?php
namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

class Site extends Controller
{
    public function Index()
    {
        return view('site/sign');
    }

    public function Sign(Request $request)
    {
        // return  $request;
        $this->validate($request, [
            'email' => 'required|unique:users',
            'phone' => 'required',
            'user_pwd' => 'required',
        ]);
        
        
        $email=$request['email'].$request['emailnext'];
        $users=new Users();
        $users->email=$email;
        $users->user_pwd=md5($request['user_pwd']);
        $users->name="sign".rand(10000000,99999999);
        $users->phone=$request['phone'];
        if($users->save()){
            return redirect('login');
        }else{
            echo "error";
        }

    

    }

    public function Login()
    {
        return view('site/login');
    }

    public function Logins(Request $request)
    {
    //    return $request;
       $this->validate($request, [
        'email' => 'required|unique:users',
        'emailnext'=>'required',
        'user_pwd' => 'required',
        ]);

        $email=$request['email'].$request['emailnext'];
        $users=new Users();
        $res=$users->where('email',$email)->where('user_pwd',md5($request['user_pwd']))->first();
        if(empty($res)){
            return redirect('login');
        }else{
            return view('site/show',['res'=>$res]);
        }

    }

}