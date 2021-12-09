<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'password_view', 'job_id','phone' , 'country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country(){
        return $this->belongsTo('App\Country'  , 'country_id' , 'id');
    }
    public function wishlist(){
        return $this->belongsToMany(Product::class,'wish_list')->withTimestamps();
    }
    public function wishlistsHas($productId){
        return self::wishlist()->where('product_id',$productId)->exists();
    }
    public  function getPrice($price){

        $country =$this->country;
        $new_price= $price/$country->currency->rate;
        return $new_price;
    }
}
