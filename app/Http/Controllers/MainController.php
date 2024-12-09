<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
