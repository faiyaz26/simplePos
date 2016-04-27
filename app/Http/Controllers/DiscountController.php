<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Discount;
use App\Http\Requests\RuleRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;

use Illuminate\Http\Request;


class DiscountController extends Controller
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
        $discounts = Discount::all();
        return view('discount.index')->with('discounts', $discounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('discount.create');
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
        $discount = new Discount;
        $discount->name = Input::get('name');
        $discount->type = Input::get('type');
        $discount->amount = Input::get('amount');
        $discount->active = Input::get('active') || 0;
        $discount->automatic = Input::get('automatic') || 0;
        $discount->description = Input::get('description');
        $discount->save();
        Session::flash('message', 'You have successfully added new Discount rule');
        return Redirect::to('discounts');
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
        $discount = Discount::find($id);
        return view('discount.edit')
            ->with('discount', $discount);
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

        $discount = Discount::find($id);
        $discount->name = Input::get('name');
        $discount->type = Input::get('type');
        $discount->amount = Input::get('amount');
        $discount->active = Input::get('active') || 0;
        $discount->automatic = Input::get('automatic') || 0;
        $discount->description = Input::get('description');
        $discount->save();
        Session::flash('message', 'You have successfully updated Discount rule');
        return Redirect::to('discounts');
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
            $rule = Discount::find($id);
            $rule->delete();
            // redirect
            Session::flash('message', 'You have successfully deleted a discount rule');
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
