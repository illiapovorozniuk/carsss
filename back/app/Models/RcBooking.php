<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RcBooking extends Model
{
    use HasFactory;
    protected $fillable  = ['booking_id', 'car_id', 'start_date', 'end_date','source'];

    public function bookingWithCar(){
        return $this->hasOne(RcCar::class,'car_id','car_id')
            ->select('car_id','car_model_id', 'registration_number', 'created_at','is_deleted','status')
            ->where([['company_id', '=', 1],['status', '=', 1],['is_deleted', '!=', 1]])
            ->with('carWithModel');
    }
    public static function getYears(){
        return RcBooking::selectRaw('YEAR(created_at) as year')->distinct()->get();
    }
}