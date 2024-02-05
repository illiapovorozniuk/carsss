<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcCarsBrand extends Model
{
    use HasFactory;

    protected $fillable = ['car_brand_id', 'slug'];
    public static function getBrands(){
        $objects = json_decode(RcCarsBrand::selectRaw('slug')->distinct()->get());
        $brands = array_column($objects, 'slug');
        return $brands;
    }

}
