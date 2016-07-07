<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ahmad Faiyaz
 * Date: 4/18/2016
 * Time: 4:18 AM
 */
namespace App\Http\Controllers;
use App\Item, App\Customer, App\Sale;
use App\User;
use \DB, \Input;
use App;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller {

    /*
	|--------------------------------------------------------------------------
	| Dashboard Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    private function getSaleInfoOnADay($date = null){
        if($date == null){
            $date = date("Y-m-d");
        }

        $sales = Sale::where( DB::raw('DATE(created_at)'), '=', $date)->get();


        $ret = [];

        $ret['saleCount'] = $sales->count();
        $ret['saleItemCount'] = 0;
        $ret['saleAmount'] = 0.0;
        $ret['salePaymentReceived'] = 0.0;

        foreach($sales as $sale){
            $ret['saleItemCount'] += $sale->items->count();
            $ret['saleAmount'] += $sale->saleAmountWithCharge();
            $ret['salePaymentReceived'] += $sale->paid;
        }

        return $ret;
    }

    public function index(){
        $date = date('Y-m-d');

        if(Input::has('date')) {
            $date = Input::get('date');
        }
        $sale = new Sale;
        $saleInfo = $sale->getSaleInfoOnADay($date);
        $saleInfo['date'] = $date;
        return view('home')->with('saleInfo', $saleInfo);
    }

    public function query(){

    }
}