<?php
/**
 * Created by IntelliJ IDEA.
 * User: ASUS
 * Date: 5/13/2016
 * Time: 12:17 AM
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Auth, \Redirect, \Validator, \Input, \Session, \Hash, \DB;
use Illuminate\Http\Request;


use App\User;
use App\Sale;
use App\Item;
use App\Discount;
use App\ChargeRule;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show($id){
        $sale = Sale::findOrFail($id);

        $data = [];

        $data = array_merge($data, $sale->toArray());
        $data ['items'] = $sale->items->toArray();
        $data['discounts'] = $sale->discounts->toArray();
        $data['charges']   = $sale->charges->toArray();

        $data['grossTotal'] = 0.0;

        foreach($data['items'] as $key => $item){
            $data['items'][$key]['name'] = Item::find($item['item_id'])->name;
            $data['grossTotal'] += ($item['quantity'] * $item['selling_price']);
        }


        $discountSum = 0.0;
       // dd($data['discounts']);
        foreach($data['discounts'] as $key => $discount){
            $val = 0.0;
            //dd($discount);
            if($discount['type'] == 1){ // %
                $val = ($data['grossTotal'] * $discount['amount'])/100.0;
            }else{ // -
                $val = ($discount['amount']);
            }
            $data['discounts'][$key]['name'] = Discount::find($discount['discount_id'])->name;

            //dd($data['discounts'][$key]['name']);
            $data['discounts'][$key]['value'] = $val;
            $discountSum += $val;
        }


        $chargeSum = 0.0;
        foreach($data['charges'] as $key => $charge){
            $val = 0.0;

            if($charge['type'] == 1){
                $val = (( $data['grossTotal'] - $discountSum) * $charge['amount'])/100.0;
            }else{
                $val = ($charge['amount']);
            }

            $data['charges'][$key]['name'] = ChargeRule::find($charge['charge_id'])->name;
            $data['charges'][$key]['value'] = $val;

            $chargeSum += $val;
        }


        $data['totalPayment'] = $data['grossTotal'] - $discountSum + $chargeSum;
        $data['returnAmount'] = $data['paid'] - $data['totalPayment'];

        if($data['returnAmount'] >= 0.0){
            $data['paymentDone'] = "PAID";
        }else{
            $data['paymentDone'] = "NOT PAID";
        }


        $ret = DB::table('settings')->get();
        $data['company'] = $ret[2]->value;
        $data['receiptHeader'] = $ret[3]->value;

        return view('receipt.show')
            ->with('data', $data);
    }





}