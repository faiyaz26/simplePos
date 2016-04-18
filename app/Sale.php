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

    public function getTotalPrice(){
        return $this->items->sum(function($item) {
            return $item->totalPrice();
        });
    }
}
