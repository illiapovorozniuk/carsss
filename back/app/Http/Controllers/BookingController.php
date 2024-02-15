<?php

namespace App\Http\Controllers;

use App\Models\RcBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    function getBookings()
    {

        $bookings = RcBooking::select("booking_id", "car_id","start_date","end_date")->where([['user_id', '=', Auth::user()['id']]])->with('bookingWithCarTranslation')->get();
        $responseBody = [];
        foreach ($bookings as $booking) {
            $booking = json_decode($booking);
            $responseBody[] =
                [
                    'booking_id' => $booking->booking_id,
                    'car_id' => $booking->car_id,
                    'start_date' => $booking->start_date,
                    'end_date' => $booking->end_date,
                    'registration_number' => $booking->booking_with_car_translation->registration_number,
                    'name' => $booking->booking_with_car_translation->car_with_model_translation[0]->name,
                    'year' => $booking->booking_with_car_translation->attribute_year,

                ];
        }
        return $responseBody;

    }
}
