<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ahmad Faiyaz
 * Date: 4/19/2016
 * Time: 1:54 AM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sale extends Model {
    use SoftDeletes;
    protected $table = 'sales';

    public function items(){
        return $this->hasMany('App\SaleItem');
    }

    public function discounts(){
        return $this->hasMany('App\SaleDiscount');
    }

    public function charges(){
        return $this->hasMany('App\SaleCharge');
    }

    public function getTotalPrice(){
        return $this->items->sum(function($item) {
            return $item->totalPrice();
        });
    }

    public function getTotalCost(){
        return $this->items->sum(function($item) {
            return $item->totalCost();
        });
    }

    private function getGrossTotal(){
        $data = [];
        $data ['items'] = $this->items->toArray();
        $data['grossTotal'] = 0.0;

        foreach($data['items'] as $key => $item){
            $data['items'][$key]['name'] = Item::find($item['item_id'])->name;
            $data['grossTotal'] += ($item['quantity'] * $item['selling_price']);
        }

        return $data['grossTotal'];
    }

    private function getDiscountTotal($grossTotal){
        $data = [];
        $data['discounts'] = $this->discounts->toArray();
        $discountSum = 0.0;
        
        foreach($data['discounts'] as $key => $discount){
            $val = 0.0;

            if($discount['type'] == 1){ // %
                $val = ($grossTotal * $discount['amount'])/100.0;
            }else{ // -
                $val = ($discount['amount']);
            }
            $data['discounts'][$key]['name'] = Discount::find($discount['discount_id'])->name;
            $data['discounts'][$key]['value'] = $val;
            $discountSum += $val;
        }

        return $discountSum;
    }

    private function getChargeTotal($sum){
        $data = [];
        $data['charges']   = $this->charges->toArray();
        $chargeSum = 0.0;
        foreach($data['charges'] as $key => $charge){
            $val = 0.0;

            if($charge['type'] == 1){
                $val = (($sum) * $charge['amount'])/100.0;
            }else{
                $val = ($charge['amount']);
            }

            $data['charges'][$key]['name'] = ChargeRule::find($charge['charge_id'])->name;
            $data['charges'][$key]['value'] = $val;

            $chargeSum += $val;
        }
        return $chargeSum;
    }

    public function saleAmountWithOutCharge(){
        $grossSum = $this->getGrossTotal();
        $discountSum = $this->getDiscountTotal($grossSum);

        return $grossSum - $discountSum;
    }

    public function saleAmountWithCharge(){
        $sum  = $this->saleAmountWithOutCharge();
        $chargeSum = $this->getChargeTotal($sum);
        $totalPayment = $sum + $chargeSum;
        return $totalPayment;
    }
}
