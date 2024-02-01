<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcBooking extends Model
{
    use HasFactory;
    protected $fillable  = ['booking_id', 'car_id', 'start_date', 'end_date','source'];
    public function car()
    {
        return $this->belongsTo(RcCar::class,'car_id','car_id');
    }
    public function bookingWithCar(){
        return $this->hasOne(RcCar::class,'car_id','car_id')
            ->select('car_id','car_model_id', 'registration_number', 'attribute_year','is_deleted','status')
            ->where([['company_id', '=', 1],['status', '=', 1],['is_deleted', '!=', 1]])
            ->with('carWithModel');
    }
    public static function getYears(){
        $objects = json_decode(RcBooking::selectRaw('YEAR(created_at) as year')->where([
            ['company_id', '=', 1],
            ['status', '=', 1]
        ])->whereHas('car', function ($query) {
            $query->where('company_id', '=', 1)
                ->where('status', '=', 1)
                ->where('is_deleted', '!=', 1);
        })->distinct()->get());
        $years = array_column($objects, 'year');
        return $years;
    }
}
