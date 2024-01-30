<?php

namespace App\Http\Controllers;

use App\Models\RcBooking;
use Carbon\Carbon;
use DateTime;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Expr\Array_;

class StatisticsController extends Controller
{
    //

    function statisticsForTheMonth(Request $request)
    {
//        return ((new DateTime())->format('H:i:s'));
        $year = $request->input()['year'];
        $month = $request->input()['month'];

        $years = $this->getYears();

//        return $years;
        if (!in_array($year, $years) || $month < 1 || $month > 12)
            return response(['message' => 'Incorrect period'], 400);

        $startMonthDate = $year . '-' . $month . '-01 00:00:00';
        $endMonthDate = $year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year) . ' 23:59:59';
//        cal_days_in_month(CAL_GREGORIAN, $month, $year)
        $necessaryCondition = [['status', '!=', 0]];
        $bookings = RcBooking::select('booking_id', 'car_id', 'created_at', 'start_date', 'end_date', 'source')
            ->where([
                ['end_date', '>=', $startMonthDate],
                ['start_date', '<', (new DateTime($endMonthDate))->modify('+1 day')->format('Y-m-d') . ' 00:00:00'],
                ['status', '=', 1]
            ])
            ->with('bookingWithCar')
            ->get();

        $responseBody = [];
        foreach ($bookings as $booking) {
            //Check if car exist in current array
            if (in_array($booking['car_id'], array_column($responseBody, 'car_id')) && $booking['bookingWithCar']) {
                //Index of existing car in our array in order to add booking period
                $index = array_search($booking['car_id'], array_column($responseBody, 'car_id'));
                $responseBody[$index]['schedule'][] = [Carbon::parse($booking['start_date'])->format("Y-m-d H:i:s"),
                    Carbon::parse($booking['end_date'])->format("Y-m-d H:i:s"), $booking['source']];
            } else if ($booking['bookingWithCar']) {
                $responseBody[] =
                    [
                        'car_id' => $booking['car_id'],
                        'schedule' => [[Carbon::parse($booking['start_date'])->format("Y-m-d H:i:s"),
                            Carbon::parse($booking['end_date'])->format("Y-m-d H:i:s"), $booking['source']]],
                        'registration_number' => $booking['bookingWithCar']['registration_number'],
                        'car_slug' => $booking['bookingWithCar']['carWithModel']['slug'],
                        'car_created_at' => date_format($booking['bookingWithCar']['created_at'], 'Y-m-d'),
                        'color' => $booking['bookingWithCar']['carWithModel']['attribute_interior_color'],
                        'brand_slug' => $booking['bookingWithCar']['carWithModel']['modelWithBrand']['slug'],
                    ];
            }
        }
        usort($responseBody, function ($a, $b) {
            return $a['car_id'] - $b['car_id'];
        });
        foreach ($responseBody as $key => $elem) {
            $responseBody[$key]['schedule'] = $this->calculateAvailability($elem['schedule'], $startMonthDate, $endMonthDate);
            $responseBody[$key]['schedule']['days'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }

        return $responseBody;
    }

    function isCarFree($currentDateStart, $periods)
    {
        $currentDateStart = new DateTime($currentDateStart);
        $currentDateEnd = new DateTime(($currentDateStart)->format('Y-m-d') . " 23:59:59");

        $nineAM = new DateTime($currentDateStart->format('Y-m-d') . " 09:00:00");
        $ninePM = new DateTime($currentDateStart->format('Y-m-d') . " 21:00:00");
        $freeTimeStart = $nineAM;
        $freeTimeEnd = $ninePM;
        $isService = false;
        foreach ($periods as $period) {

            $startPeriod = new DateTime($period[0]);
            $endPeriod = new DateTime($period[1]);

            //Перевірка на дні які знаходяться в середині періода у 3+ днів
            if (((new DateTime($startPeriod->format('Y-m-d')))->diff(new DateTime($endPeriod->format('Y-m-d'))))->days >= 2 &&
                ($startPeriod->format('Y-m-d') <= $currentDateStart->format('Y-m-d') && $currentDateStart->format('Y-m-d') <= $endPeriod->format('Y-m-d'))) {
                $isService = $period[2] == 'car-service';
                if ($startPeriod < $currentDateStart && $currentDateEnd < $endPeriod) return $period[2] == 'car-service' ? 'service' : 'busy';
                else if ($currentDateStart->format('Y-m-d') === $startPeriod->format('Y-m-d')) goto firstDayLogic;
                else if ($currentDateStart->format('Y-m-d') === $endPeriod->format('Y-m-d')) goto lastDayLogic;
            } //День який в періоді 2 днів
            else if ($startPeriod->format('Y-m-d') === (new DateTime($endPeriod->format('Y-m-d H:i:s')))->modify('-1 day')->format('Y-m-d')
                && ($currentDateStart->format('Y-m-d') === $startPeriod->format('Y-m-d') || $currentDateStart->format('Y-m-d') === $endPeriod->format('Y-m-d'))
            ) {
                $isService = $period[2] == 'car-service';
                //Поточний день 1 день періоду

                if ($currentDateStart->format('Y-m-d') === $startPeriod->format('Y-m-d')) {
                    firstDayLogic:
                    //18<= day <=24
                    if ($ninePM <= $startPeriod) {
                        //Тут нічого 🙃
                    } //9<= day <=18
                    else if ($nineAM <= $startPeriod && $startPeriod <= $ninePM) {
                        if ($freeTimeEnd >= $startPeriod)
                            $freeTimeEnd = $startPeriod;
                    } //0<= day <=9
                    else if ($startPeriod <= $nineAM)
                        return $period[2] == 'car-service' ? 'service' : 'busy';

                } //Поточний день 2 день періоду
                else if ($currentDateStart->format('Y-m-d') === $endPeriod->format('Y-m-d')) {
                    lastDayLogic:
                    //0<= day <=9
                    if ($endPeriod <= $nineAM) {
                        //Тут нічого 🙃
                    }//0<= day <=21
                    else if ($endPeriod <= $ninePM) {
                        $freeTimeStart = $endPeriod;
                    } //0<= day <=24
                    else if ($endPeriod <= $currentDateEnd)
                        return $period[2] == 'car-service' ? 'service' : 'busy';

                }

            } //День який знаходиться в періоді 1 дня
            else if ($startPeriod->format('Y-m-d') === $endPeriod->format('Y-m-d')
                && $startPeriod->format('Y-m-d') === $currentDateStart->format('Y-m-d')
            ) {
                $isService = $period[2] == 'car-service';
                //9<= period <= 21
                if ($nineAM <= $startPeriod && $endPeriod <= $ninePM) {
                    //Перевірка на вільний час
                    if ($startPeriod->getTimestamp() - $freeTimeStart->getTimestamp() < $freeTimeEnd->getTimestamp() - $endPeriod->getTimestamp())
                        $freeTimeStart = $endPeriod;
                    else $freeTimeEnd = $startPeriod;
                } //0<= period <= 21
                else if ($startPeriod <= $nineAM && $endPeriod <= $ninePM) $freeTimeStart = $endPeriod;
                //9<= period <= 24
                else if ($nineAM <= $startPeriod && $ninePM <= $endPeriod) $freeTimeEnd = $startPeriod;
                else return $period[2] == 'car-service' ? 'service' : 'busy';

            }

        }
        return $freeTimeEnd->getTimestamp() - $freeTimeStart->getTimestamp() < 9 * 3600 ?
            $isService ? 'service' : 'busy'
            : 'free';
//        return 'free';
    }

    function calculateAvailability($schedule, $startDate, $endDate)
    {
        //Сортуємо періоди
        usort($schedule, function ($a, $b) {
            return strtotime($a[0]) - strtotime($b[0]);
        });

        $daysArr = array_fill(1, (new DateTime($endDate))->format('d'), 'free');

        foreach ($daysArr as $day => $dayValue) {
            $currentDate = (new DateTime($startDate))->modify("+" . $day - 1 . "day")->format('Y-m-d H:i:s');
            if (isset($schedule[0])) {
                //Для скорочення обрахунків видаляємо непотрібні періоди
                if ($schedule[0][1] < $currentDate)
                    array_shift($schedule);
                $daysArr[$day] = $this->isCarFree($currentDate, $schedule);
            }
        }

        $resultData = ['free' => 0, 'service' => 0, 'busy' => 0, 'days' => 0];

        foreach ($daysArr as $day) {
            if ($day === 'free') $resultData['free'] += 1;
            else if ($day === 'busy') $resultData['busy'] += 1;
            else if ($day === 'service') $resultData['service'] += 1;
        }
        return $resultData;
    }

    function getYears()
    {
        $data = RcBooking::getYears();
        return $data;
    }

}
