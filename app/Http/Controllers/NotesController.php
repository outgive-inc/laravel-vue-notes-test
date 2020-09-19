<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notes;
use App\User;
use Symfony\Component\HttpFoundation\Response;


class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $notes = Notes::where('user_id','=',$userId)->get();
        return $notes;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Notes
     */
    protected function add(Request $data)
    {
        $userId = Auth::id();
        $date = Carbon::now()->format('Y-m-d H:i:s');

        $notes = new Notes();
        $notes->title = $data->title;
        $notes->content = $data->content;
        $notes->user_id = $userId;
        $notes->created_at = $date;
        $notes->save();

        return response($notes->jsonSerialize(),Response::HTTP_CREATED);
    }


    // edit book
    public function edit($id)
    {
        $userId = Auth::id();

        $notes = Notes::find($id);

        if($notes && $notes->user_id == $userId)
        {
            return response()->json($notes);
        }

        return response()->json(['error' => 'User is not Authorized to Access Data or Data is not found.'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        $notes = Notes::findOrFail($id);
        if($notes && $notes->user_id == $userId)
        {
            $notes->title = $request->title;
            $notes->content = $request->content;
            $notes->save();

            return response(null, Response::HTTP_OK);
        }

        return response()->json(['error' => 'User is not Authorized to Access Data or Data is not found.'], 400);
    }

    public function delete($id)
    {
        $notes = Notes::find($id);
        $notes->delete();

        return response()->json('The note successfully deleted');
    }
}
