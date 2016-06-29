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
use \Auth, \Redirect, \Validator, \Input, \Session;
use \DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if(Auth::user()->username != 'admin'){
            return abort(403);
        }
    }

    public function index(){
        $ret = DB::table('settings')->get();
        $data['company'] = $ret[2]->value;
        $data['receiptHeader'] = $ret[3]->value;
        $data['pinCode'] = $ret[4]->value;
        return view('settings.index')->with('data', $data);
    }

    public function store(){
        DB::table('settings')->where('key', 'company')->update(['value' => Input::get('company')]);
        DB::table('settings')->where('key', 'receiptHeader')->update(['value' => Input::get('receiptHeader')]);
        DB::table('settings')->where('key', 'pinCode')->update(['value' => Input::get('pinCode')]);
        $ret = DB::table('settings')->get();
        $data['company'] = $ret[2]->value;
        $data['receiptHeader'] = $ret[3]->value;
        $data['pinCode'] = $ret[4]->value;
        Session::flash('message', 'Settings updated');
        return view('settings.index')->with('data', $data);
    }
}