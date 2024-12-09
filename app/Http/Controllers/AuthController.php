<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('login');

    }
    public function loginSubmit(Request $request){

        //validation
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16',

            ],
            [
                'text_username.required' =>'O username é origatório',
                'text_username.email' =>'O username deve ser um email válido',
                'text_password.required' =>'O password é origatório',
                'text_password.min' =>'O password deve ter pelo menos :min caracteres',
                'text_password.max' =>'O password deve ter pelo menos :max caracteres',

            ]
        );
        //get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // get all users from database
        // $users = User::all()->toArray();
        // as an object instance of the model's class
        // $usersModel = new User();
        // $users = $usersModel->all()->toArray();


        //check if user exists
        $user = User::where('username', $username)
                    ->where('deleted_at', null)
                    ->first();
        if(!$user)
        {
            return redirect()->back()->withInput()->with('loginError', 'Username ou password inccoreto');
        }

        if(!password_verify($password, $user->password)){
            return redirect()->back()->withInput()->with('loginError', 'Username ou password inccoreto');
        }

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user'=>[
                'id'=>$user->id,
                'username'=> $user->username
            ]
        ]);

        return redirect()->to('/');
    }

    public function logout(){
        //logout provisório
        session()->forget('user');
        return redirect()->to('/login');
    }
}
