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
use \Auth, \Redirect, \Validator, \Input, \Session, \Response;
use Illuminate\Http\Request;

use App\Sale;
use App\SaleItem;
use App\SaleCharge, App\SaleDiscount;
use DB;

class SaleController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getTotalSaleAmountWithCharge($data){
    	$ret = 0.0;
    	foreach($data as $sale){
    		$ret += $sale->saleAmountWithCharge();
    	}
    	return $ret;
    }

    public function index(){
        $data = Sale::all()->sortByDesc("id");;

        if(Input::get('q')){
            $data = Sale::where('status', Input::get('q'))->get()->sortByDesc('id');
        }
        return view('sale.index')->with('sales', $data);
    }
}
