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


class SaleApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('sale.index');
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
        DB::commit();

        return Response::json(array('success' => true, "data" => $sale->toArray()));
    }
}