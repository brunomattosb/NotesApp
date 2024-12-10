<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
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
        return view('new_note');
    }

    public function newNoteSubmit(Request $request){

        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',

            ],
            [
                'text_title.required' =>'O título é origatório',
                'text_title.min' =>'O título deve ter pelo menos :min caracteres',
                'text_title.max' =>'O título deve ter pelo menos :max caracteres',

                'text_note.required' =>'A nota é origatório',
                'text_note.min' =>'A nota deve ter pelo menos :min caracteres',
                'text_note.max' =>'A nota deve ter pelo menos :max caracteres',

            ]
        );

        $id = session('user.id');

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        return redirect()->route('home');
    }

    public function deleteNote($id){
        $id = Operations::decryptId($id);
        // $id = $this->decryptId($id);
    }

    public function editNote($id){
        $id = Operations::decryptId($id);

        $note = Note::find($id);

        return view('edit_note', ['note'=>$note]);
    }

    public function editNoteSubmit(Request $request){

        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',

            ],
            [
                'text_title.required' =>'O título é origatório',
                'text_title.min' =>'O título deve ter pelo menos :min caracteres',
                'text_title.max' =>'O título deve ter pelo menos :max caracteres',

                'text_note.required' =>'A nota é origatório',
                'text_note.min' =>'A nota deve ter pelo menos :min caracteres',
                'text_note.max' =>'A nota deve ter pelo menos :max caracteres',

            ]
        );
        if($request->note_id == null){
            return redirect()->route('home');
        }
        $id = Operations::decryptId($request->note_id);

        $note = Note::find($id);
        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        return redirect()->route('home');
    }

}
