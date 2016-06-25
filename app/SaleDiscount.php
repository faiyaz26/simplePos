<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ahmad Faiyaz
 * Date: 4/19/2016
 * Time: 1:56 AM
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SaleDiscount extends Model {
    use SoftDeletes;
    protected $table = 'sales_discounts';


    public function sale(){
        return $this->belongsTo('App\Sale');
    }

    public function original(){
        return $this->belongsTo('App\Discount','discount_id', 'id');
    }

}