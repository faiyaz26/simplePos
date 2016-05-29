<?php

/*
 * Developer: Ahmad Faiyaz
 */


namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use \Auth, \Redirect, \Validator, \Input, \Session, \Hash;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index')->with('users', $users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        // store
        $users = new User;
        $users->name = Input::get('name');
        $users->username = Input::get('username');
        $users->email = Input::get('email');
        $users->password = Hash::make(Input::get('password'));
        $users->save();

        Session::flash('message', 'You have successfully added an user with username: '.$users->username);
        return Redirect::to('users');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit')
            ->with('user', $user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if(0)
        {
            Session::flash('message', 'You cannot edit admin on Simple Pos');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::to('users');
        }
        else
        {
            $rules = array(
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id .'',
                'password' => 'min:6|max:30|confirmed',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails())
            {
                return Redirect::to('employees/' . $id . '/edit')
                    ->withErrors($validator);
            } else {
                $users = User::find($id);
                $users->name = Input::get('name');
                $users->email = Input::get('email');
                if(!empty(Input::get('password')))
                {
                    $users->password = Hash::make(Input::get('password'));
                }
                $users->save();
                // redirect
                Session::flash('message', 'You have successfully updated an user');
                return Redirect::to('users');
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if($id == 1)
        {
            Session::flash('message', 'You cannot delete admin on the system');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::to('users');
        }
        else
        {
            try
            {
                $users = User::find($id);
                $users->delete();
                // redirect
                Session::flash('message', 'You have successfully deleted an user');
                return Redirect::to('users');
            }
            catch(\Illuminate\Database\QueryException $e)
            {
                Session::flash('message', 'Integrity constraint violation: You Cannot delete a parent row');
                Session::flash('alert-class', 'alert-danger');
                return Redirect::to('users');
            }
        }
    }
}