<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
      'name' , 'email' , 'phone' , 'country_id' ,  'city_id' , 'total_price' , 'total_quantity',
        'user_id' , 'address1' , 'address2' , 'note' , 'postal_code' , 'national_id'
    ];


    public function order_items(){
        return $this->hasMany('App\OrderItem' ,'order_id' , 'id' );
    }

    public function country(){
        return $this->belongsTo('App\Country'  , 'country_id' , 'id');
    }

    public function city(){
        return $this->belongsTo('App\City'  , 'city_id' , 'id');
    }

}
