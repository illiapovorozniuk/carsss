<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcCarsModel extends Model
{
    use HasFactory;
    public function brand()
    {
        return $this->belongsTo(RcCarsBrand::class,'car_brand_id','car_brand_id');
    }
    protected $fillable  = ['car_model_id', 'car_brand_id', 'slug','attribute_interior_color',
        'attribute_interior_color'];
    public function modelWithBrand(){
        return $this->
        hasOne(RcCarsBrand::class, 'car_brand_id','car_brand_id')->
        select('car_brand_id','slug');
    }
    public function carWithModelTranslation()
    {
        return $this->hasMany(RcCarsModelsTranslation::class, 'car_model_id', 'car_model_id',)
            ->select('car_model_id', 'name')
            ->where('lang','=','en');
    }
}
