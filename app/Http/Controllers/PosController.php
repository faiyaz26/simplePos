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
use Illuminate\Http\Request;
use App\Sale;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = array(
          'edit' => 0,
            'id' => 0
        );
        return view('pos.index')->with('data', $data);
    }

    public function edit($id){
        $check = Sale::findOrFail($id);

        if($check->status == 'done'){
            return "You cannot edit a completed sale\n";
        }
        $data = array(
            'edit' => 0,
            'id' => $id
        );
        return view('pos.index')->with('data', $data);
    }
}