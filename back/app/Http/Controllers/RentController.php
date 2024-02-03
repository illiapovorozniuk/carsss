<?php

namespace App\Http\Controllers;

use App\Models\RcBooking;
use App\Models\RcCar;
use Cassandra\Date;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    //
    public function searchFreeCars(Request $request)
    {
        $start_date = $request->input(['start_date_time']);
        $end_date = $request->input(['end_date_time']);

        if (new DateTime() >= new DateTime($start_date) || $start_date >= $end_date) {
            return response([
                'error' => 'The provided time is incorrect'

            ], 400);
        }
        $companyCars = RcCar::select('car_id', 'car_model_id', 'attribute_year', 'attribute_transmission')->where([
            ['status', '=', 1],
            ['company_id', '=', 1],
            ['is_deleted', '!=', 1],
        ])
            ->with('carWithModelTranslation')
            ->with('carWithModel')->get();
        //Букінги, які припадають на даний період
        $periodBookings = RcBooking::select('car_id')
            ->where([
                ['end_date', '>', $start_date],
                ['start_date', '<', $end_date],
                ['company_id', '=', 1],
                ['status', '=', 1]
            ])->whereHas('car', function ($query) {
                $query->where('company_id', '=', 1)
                    ->where('status', '=', 1)
                    ->where('is_deleted', '!=', 1);
            })
            ->orderBy('car_id')
            ->get();
        //Зайняті автомобілі на даний період
        $busyCarIds = array_unique((array_column(json_decode($periodBookings), 'car_id')));

        //Вільні авто
        $responseBody = [];

        foreach ($companyCars as $car) {
            if (!in_array($car['car_id'], $busyCarIds)) {
                $car = json_decode($car);
                $responseBody[] = [
                    'car_id' => $car->car_id,
                    'name' => $car->car_with_model_translation[0]->name,
                    'year' => $car->attribute_year,
                    'color' => $car->car_with_model->attribute_interior_color,
                    'transmission' => $car->attribute_transmission,
                ];
            }
        }
        return $responseBody;
    }

    public function createBooking(Request $request)
    {
        $start_date_time = $request->input(['start_date_time']);
        $end_date_time = $request->input(['end_date_time']);
        $car_id = $request->input(['car_id']);
        //Перевірка, чи час не менший за теперішній
        if ($start_date_time >= $end_date_time || (new DateTime())->format('Y-m-d H:i') >= (new DateTime($start_date_time))->format('Y-m-d H:i')||$car_id===null) {
            return response([
                'error' => 'The provided credentials is incorrect'
            ], 400);
        }
        $periodBookings = RcBooking::select('car_id')
            ->where([
                ['car_id', '=', $car_id],
                ['end_date', '>', $start_date_time],
                ['start_date', '<', $end_date_time],
                ['company_id', '=', 1],
                ['status', '=', 1]
            ])->whereHas('car', function ($query) {
                $query->where('company_id', '=', 1)
                    ->where('status', '=', 1)
                    ->where('is_deleted', '!=', 1);
            })->get();
        //Перевірка на те, чи вільне авто у цей час
        if (!($periodBookings->isEmpty())) {
            return response([
                'error' => 'The provided car is busy in this time'
            ], 400);
        }
        $booking = new RcBooking;
        $booking->car_id = $car_id;
        $booking->user_id = Auth::user()['id'];
        $booking->company_id = 1;
        $booking->status = 1;
        $booking->is_reserved = 1;
        $booking->source = 'carsss';
        $booking->start_date = $start_date_time;
        $booking->end_date = $end_date_time;

        return $booking->save();
    }
}
