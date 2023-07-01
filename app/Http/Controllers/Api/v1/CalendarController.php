<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\DisabledDay;
use App\Models\Reservation;
use App\Models\Route;
use App\Models\RouteData;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CalendarController extends Controller
{
    public function index()
    {
        $data['calendars'] = Calendar::all();
        return response()->json($data);
    }

    public function show(Request $request, Calendar $calendar)
    {
        Validator::make($request->all(), [
            'type' => ['nullable', Rule::in(['date', 'dates', 'route'])],
            'date' => 'required_if:type,date|date',
            'date_start' => 'required_if:type,dates|date',
            'date_end' => 'required_if:type,dates|date',
            'route_id' => 'required_if:type,route|exists:routes,id',
        ])->validate();

        $route = null;
        $days = [];

        switch ($request->type)
        {
            case 'date':
                $date = Carbon::createFromDate($request->date);
                $fistDay = $date->copy()->startOfWeek();
                $lastDay = $date->copy()->endOfMonth()->endOfWeek();
                break;

            case 'dates':
                $date = Carbon::createFromDate($request->date_start);
                $dateEnd = Carbon::createFromDate($request->date_end);
                $fistDay = $date->copy()->startOfWeek();
                $lastDay = $dateEnd->copy()->endOfMonth()->endOfWeek();
                break;

            case 'route':
                $route =  Route::find($request->route_id);
                $date = Carbon::createFromDate($route->latestData->date_init);
                $dateEnd = Carbon::createFromDate($route->latestData->date_finish);
                $fistDay = $date->copy()->startOfWeek();
                $lastDay = $dateEnd->copy()->endOfMonth()->endOfWeek();
                break;

            default:
                $date = now();
                $fistDay = $date->copy()->startOfWeek();
                $lastDay = $date->copy()->endOfMonth()->endOfWeek();

        }

        $period = CarbonPeriod::since($fistDay)->until($lastDay);

        foreach ($period as $day) {

            $disabledDay = DisabledDay::where('calendar_id',$calendar->id)->where('day',$day->toDateString())->first();
            $reservation = Reservation::where('reservation_start','<=',$day->toDateString())->where('reservation_end','>=',$day->toDateString())->first();
            // TODO: Agregar control por usuario a la reserva

            $dayOfWeek = strtolower($day->format('D'));
            $in_frequency = $route ? $route->latestData->$dayOfWeek : false;

            $days[$day->toDateString()] = [
                'day' => $day->format('j'),
                'in_month' => $day->format('m') === $date->format('m'),
                'disabled_day' => $disabledDay !== null,
                'reservation' => $reservation !== null,
                'in_frequency' => $in_frequency
            ];
        }

        $data['calendar'] = $calendar;
        $data['days'] = $days;
        $routes = Route::whereHas('latestData', function (Builder $query) use ($calendar) {
            $query->where('calendar_id', '=', $calendar->id);
        })->get();
        $data['routes'] = $routes;

        return response()->json($data);
    }
}
