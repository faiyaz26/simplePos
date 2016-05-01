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
class SaleCharge extends Model {
    use SoftDeletes;
    protected $table = 'sales_charges';


    public function sale(){
        return $this->belongsTo('App\Sale');
    }

    public function item(){
        return $this->belongsTo('App\ChargeRule');
    }

}