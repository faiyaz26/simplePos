<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ahmad Faiyaz
 * Date: 4/18/2016
 * Time: 4:18 AM
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Item;
use App\Http\Requests\ItemRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;
use Illuminate\Http\Request;


class ItemController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Item::all();
        return view('item.index')->with('item', $items);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ItemRequest $request)
    {
        $items = new Item;
        $items->code = Input::get('code');
        $items->name = Input::get('name');
        $items->category = Input::get('category');
        $items->description = Input::get('description');
        $items->cost_price = Input::get('cost_price');
        $items->selling_price = Input::get('selling_price');
        $items->save();

        Session::flash('message', 'You have successfully added item named '. $items->name);
        return Redirect::to('items/create');
    }

    public function edit($id)
    {
        $items = Item::find($id);
        return view('item.edit')
            ->with('item', $items);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ItemRequest $request, $id)
    {
        $items = Item::find($id);

        // save update
        $items->code = Input::get('code');
        $items->name = Input::get('name');
        $items->category = Input::get('category');
        $items->description = Input::get('description');
        $items->cost_price = Input::get('cost_price');
        $items->selling_price = Input::get('selling_price');
        $items->save();

        Session::flash('message', 'You have successfully updated item named '. $items->name);
        return Redirect::to('items');
    }


}