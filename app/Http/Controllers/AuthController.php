<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // dd("aku di sini");
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function loginproses(Request $request)
    {
        $this->validate($request,$this->validate,$this->message);
        $count = User::where('kd_pegawai', '=', $request->username)->count();
        if ($count > 0) {   
            $data = User::where('kd_pegawai', '=', $request->username)->first();           
            if (Auth::attempt(['kd_pegawai'=>$request->username,'password'=>$request->password])) {
                $user = array(
                    'kd_pegawai' => $data['username'],
                    'nama_pegawai' => $data['name'],
                    'role' => $data['role'],                                    
                );
                Session::put('user',$user);               
                return redirect('admin/home');                   
            } else {
                return redirect()->route('login')->with("type","error")->with("message","Password Doesn't Match");                
            }
        } else {
            return redirect()->route('login')->with("type","error")->with("message","Username Not Fount");
           
        }
    }

    public function logout(){
        Session::flush();
        return redirect()->route('login');
    }
    
    private $validate=[        
        'username' => 'required|string|',
        'password' => 'required|string', 
    ];

    private $message=[        
        'username.required'  => 'Username harus di isi',
        // 'email.email'  => 'Valid format email',        
        'password.required' => 'Password harus di isi',        
    ];

}
