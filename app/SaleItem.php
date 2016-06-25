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
class SaleItem extends Model {
    use SoftDeletes;
    protected $table = 'sales_items';


    public function sale(){
        return $this->belongsTo('App\Sale');
    }

    public function original(){
        return $this->belongsTo('App\Item','item_id', 'id');
    }

    /**
     * Returns the total price of a certain sale item
     * @return double
     */
    public function totalPrice(){
        return $this->attributes['selling_price'] * $this->attributes['quantity'];
    }

    public function totalCost(){
        return $this->attributes['cost_price'] * $this->attributes['quantity'];
    }
}