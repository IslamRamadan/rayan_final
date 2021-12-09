<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $table = 'sliders';
    public $timestamps = true;
    protected $fillable = array('name_ar', 'name_en', 'description_ar',"description_en",'img');
    protected $appends = [   "img_full_path"] ;


    public function  getImgFullPathAttribute()
    {
        return asset($this->img) ;
    }

}