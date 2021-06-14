<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notes;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    protected function index()
    {
        $userId = Auth::id();
        $notes = Notes::orderBy('id', 'desc')->paginate(3);
       return response()->json($notes);
    }

    protected function validation($request){
        return $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
    }

    protected function add(Request $request){
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $userId = Auth::id();
            $date = Carbon::now()->format('Y-m-d H:i:s');
    
            $note = new Notes();
            $note->title = $request->title;
            $note->content = $request->content;
            $note->user_id = $userId;
            $note->created_at = $date;  
            if($note->save()) {
                return response($note->jsonSerialize(),Response::HTTP_CREATED);
            }
        }
    }

    protected function edit($id)
    {
        $userId = Auth::id();

        $notes = Notes::find($id);

        if($notes && $notes->user_id == $userId)
        {
            return response()->json($notes);
        }
        return response()->json(['error' => 'Unauthorised user'], 400);
    }

    protected function update(Request $request, $id)
    {
        $validator = $this->validation($request);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $notes = Notes::findOrFail($id);
            $userId = Auth::id();
            if($notes && $notes->user_id == $userId)
            {
                $notes->title = $request->title;
                $notes->content = $request->content;
                $notes->save();

                return response(null, Response::HTTP_OK);
          }
        return response()->json(['error' => 'Unauthorised user'], 400);
        }     
    }

    protected function delete($id)
    {
        $notes = Notes::find($id);
        $notes->delete();

        return response()->json('Note deleted successfully');
    }
}
