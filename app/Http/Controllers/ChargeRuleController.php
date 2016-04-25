<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ChargeRule;
use App\Http\Requests\RuleRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;

use Illuminate\Http\Request;


class ChargeRuleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rules = ChargeRule::all();
        return view('chargerule.index')->with('rules', $rules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('chargerule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RuleRequest $request)
    {
        //
        // store
        $rule = new ChargeRule;
        $rule->name = Input::get('name');
        $rule->type = Input::get('type');
        $rule->amount = Input::get('amount');
        $rule->active = Input::get('active') || 0;
        $rule->description = Input::get('description');
        $rule->save();
        Session::flash('message', 'You have successfully added new charge rule');
        return Redirect::to('rules');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $rules = ChargeRule::find($id);
        return view('chargerule.edit')
            ->with('rule', $rules);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RuleRequest $request, $id)
    {
        //

        $rule = ChargeRule::find($id);
        $rule->name = Input::get('name');
        $rule->type = Input::get('type');
        $rule->amount = Input::get('amount');
        $rule->active = Input::get('active') || 0;
        $rule->description = Input::get('description');
        $rule->save();
        // redirect
        Session::flash('message', 'You have successfully updated rule');
        return Redirect::to('rules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try
        {
            $rule = ChargeRule::find($id);
            $rule->delete();
            // redirect
            Session::flash('message', 'You have successfully deleted a rule');
            return Redirect::to('rules');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            Session::flash('message', 'Integrity constraint violation: You Cannot delete a parent row');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::to('rules');
        }
    }
}
