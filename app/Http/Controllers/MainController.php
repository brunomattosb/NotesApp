<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class MainController extends Controller
{

    public function index(){

        $id = session('user.id');
        // $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes'=>$notes]);
    }

    public function newNote(){
        echo 'Criar uma nova nota';
    }

    public function editNote($id){
        try
        {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }

    }
}
