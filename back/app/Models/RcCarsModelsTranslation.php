<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcCarsModelsTranslation extends Model
{
    use HasFactory;
    protected $fillable  = ['car_model_id', 'en', 'name'];
}
