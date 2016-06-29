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
use App\Log;
use DB;


class SaleApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('sale.index');
    }

    public function show($id){
        $sale = Sale::findOrFail($id);
        $ret  = $sale->toArray();
        $ret['items'] = array();
        $ret['discounts'] = array();
        $ret['charges'] = array();

        foreach($sale->items as $item){
            $curData = $item->toArray();
            $originalItem = $item->original;
            $curData['id'] = $originalItem->id;
            $curData['name']= $originalItem->name;
            $curData['category'] = $originalItem->category;
            $ret['items'][] = $curData;
        }

        foreach($sale->discounts as $discount){
            $curData = $discount->toArray();
            $originalItem = $discount->original;
            $curData['name']= $originalItem->name;
            $curData['id'] = $discount->discount_id;
            $ret['discounts'][] = $curData;
        }

        return Response::json($ret);
    }

    public function store(){
        $data = Input::get('saleData');
        $data = json_decode($data, true);

        DB::beginTransaction();

        try {
            // Validate, then create if valid
            /* Storing Sale Information */
            $sale = new Sale;
            $sale->user_id      = Auth::user()->id;
            $sale->customer_id  = $data['customerId'] || NULL;
            $sale->service_type = $data['serviceType'];
            $sale->payment_mode = $data['paymentMode'];
            $sale->reference_number = $data['referenceNumber'];
            $sale->table_info   = $data['tableInfo'];
            $sale->paid         = $data['paid'];
            $sale->comment      = $data['comment'];
            $sale->status       = $data['status'];

            $sale->save();

        } catch(ValidationException $e)
        {
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Response::json(array('success' => false));
        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

        /* Storing Items */
        foreach($data['saleItems'] as $item){
            try {
                $saleItem = new SaleItem;
                $saleItem->sale_id = $sale->id;
                $saleItem->item_id = $item['id'];
                $saleItem->quantity = $item['quantity'];
                $saleItem->cost_price = $item['cost_price'];
                $saleItem->selling_price = $item['selling_price'];

                $saleItem->save();
            } catch(ValidationException $e){
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Response::json(array('success' => false));
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
        }


        /* Storing Charges */
        foreach($data['charges'] as $charge){
            try {
                $saleCharge = new SaleCharge;
                $saleCharge->sale_id = $sale->id;
                $saleCharge->charge_id = $charge['id'];
                $saleCharge->type      = $charge['type'];
                $saleCharge->amount    = $charge['amount'];
                $saleCharge->save();
            } catch(ValidationException $e){
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Response::json(array('success' => false));
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
        }


        /* Storing Discounts */
        foreach($data['discounts'] as $discount){
            try {
                $saleDiscount = new SaleDiscount;
                $saleDiscount->sale_id = $sale->id;
                $saleDiscount->discount_id = $discount['id'];
                $saleDiscount->type      = $discount['type'];
                $saleDiscount->amount    = $discount['amount'];
                $saleDiscount->save();
            } catch(ValidationException $e){
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Response::json(array('success' => false));
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
        }


        $logData = array(
            'activity' => 'insert',
            'sale_id'  => $sale->id,
            'user_id'  => Auth::user()->id,
            'user_name' => Auth::user()->username,
            'data' => $data
        );

        $log = new Log;
        $log->log_message = json_encode($logData);
        $log->save();


        DB::commit();

        return Response::json(array('success' => true, "data" => $sale->toArray()));
    }

    public function update($id){
        $data = Input::get('saleData');
        $data = json_decode($data, true);

        $ret = DB::table('settings')->where('key', 'pinCode')->first();

        $sale = Sale::findOrFail($id);

        if($sale->status == "done"){
            return Response::json(array('success' => false, "message" => "You cannot update a complete sale"));
        }
        if($data['pinCode'] != $ret->value){
            return Response::json(array('success' => false, "message" => 'Pin Code is not correct'));
        }


        DB::beginTransaction();

        try {
            // Validate, then create if valid
            /* Storing Sale Information */

            $sale->user_id      = Auth::user()->id;
            $sale->customer_id  = $data['customerId'] || NULL;
            $sale->service_type = $data['serviceType'];
            $sale->payment_mode = $data['paymentMode'];
            $sale->reference_number = $data['referenceNumber'];
            $sale->table_info   = $data['tableInfo'];
            $sale->paid         = $data['paid'];
            $sale->comment      = $data['comment'];
            $sale->status       = $data['status'];

            $sale->save();

        } catch(ValidationException $e)
        {
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Response::json(array('success' => false));
        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

        foreach($sale->items as $saleItem){
            $saleItem->delete();
        }

        /* Storing Items */
        foreach($data['saleItems'] as $item){
            try {
                $saleItem = new SaleItem;
                $saleItem->sale_id = $sale->id;
                $saleItem->item_id = $item['id'];
                $saleItem->quantity = $item['quantity'];
                $saleItem->cost_price = $item['cost_price'];
                $saleItem->selling_price = $item['selling_price'];

                $saleItem->save();
            } catch(ValidationException $e){
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Response::json(array('success' => false));
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
        }

        foreach($sale->charges as $charge){
            $charge->delete();
        }

        /* Storing Charges */
        foreach($data['charges'] as $charge){
            try {
                $saleCharge = new SaleCharge;
                $saleCharge->sale_id = $sale->id;
                $saleCharge->charge_id = $charge['id'];
                $saleCharge->type      = $charge['type'];
                $saleCharge->amount    = $charge['amount'];
                $saleCharge->save();
            } catch(ValidationException $e){
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Response::json(array('success' => false));
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
        }

        foreach($sale->discounts as $discount){
            $discount->delete();
        }

        /* Storing Discounts */
        foreach($data['discounts'] as $discount){
            try {
                $saleDiscount = new SaleDiscount;
                $saleDiscount->sale_id = $sale->id;
                $saleDiscount->discount_id = $discount['id'];
                $saleDiscount->type      = $discount['type'];
                $saleDiscount->amount    = $discount['amount'];
                $saleDiscount->save();
            } catch(ValidationException $e){
                // Rollback and then redirect
                // back to form with errors
                DB::rollback();
                return Response::json(array('success' => false));
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }
        }




        $logData = array(
            'activity' => 'update',
            'sale_id'  => $sale->id,
            'user_id'  => Auth::user()->id,
            'user_name' => Auth::user()->username,
            'data' => $data
        );

        $log = new Log;
        $log->log_message = json_encode($logData);
        $log->save();

        DB::commit();

        return Response::json(array('success' => true, "data" => $sale->toArray()));
    }

    public function destroy($id){

        $data = Input::get('pinCode');

        $ret = DB::table('settings')->where('key', 'pinCode')->first();

        if($data  != $ret){
            return Response::json(array('success' => false, "message" => 'Pin Code is not correct'));
        }

        DB::beginTransaction();

        try {
            $sale = Sale::findOrFail($id);

            foreach($sale->items as $saleItem){
                $saleItem->delete();
            }

            foreach($sale->discounts as $discount){
                $discount->delete();
            }

            foreach($sale->charges as $charge){
                $charge->delete();
            }

            $logData = array(
                'activity' => 'delete',
                'sale_id'  => $sale->id,
                'user_name' => Auth::user()->username,
                'user_id'  => Auth::user()->id
            );


            $log = new Log;
            $log->log_message = json_encode($logData);
            $log->save();



            $sale->delete();

        } catch(ValidationException $e)
        {
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Response::json(array('success' => false));
        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        return Response::json(array('success' => true));
    }
}