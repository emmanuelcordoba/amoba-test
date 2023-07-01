<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Calendar;
use App\Models\Currency;
use App\Models\Route;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Currency::create(['name' => 'USD - United States Dollar', 'symbol' => '$', 'code' => 'USD']);
        Currency::create(['name' => 'EUR - Euro', 'symbol' => '€', 'code' => 'EUR']);
        Currency::create(['name' => 'ARS - Argentine Peso', 'symbol' => '$', 'code' => 'ARS']);

        $user = User::find(1);
        $userPlan = $user->plans()->create([
            'currency_id' => Currency::all()->random()->id,
            'start_timestamp' => now(),
            'renewal_price' => 30.0,
            'language' => array_rand(UserPlan::LENGUAGES),
        ]);

        $calendarCBA = Calendar::create(['name' => 'Ciudad de Buenos Aires']);
        $calendarCBA->disabledDays()->create(['day' => now()->addDay()]);
        $calendarCBA->disabledDays()->create(['day' => now()->addDays(random_int(2,5))]);

        $code = Str::upper(Str::random(6));
        $route = Route::create([
            'invitation_code' => $code,
            'title' => 'Route - '. $code .' - '.$calendarCBA->name,
            'start_timestamp' => now(),
            'end_timestamp' => now()->addWeek()
        ]);

        $route->data()->create([
            'calendar_id' => $calendarCBA->id,
            'date_init' => now(),
            'date_finish' => now()->addMonth(),
            'mon' => 1,
            'tue' => 1,
            'wed' => 1,
            'thu' => 1,
            'fri' => 1,
            'sat' => 0,
            'sun' => 0,
        ]);

        $userPlan->reservations()->create([
            'route_id' => $route->id,
            'reservation_start' => now()->addWeek(),
            'reservation_end' => now()->addWeek()
        ]);

        $calendarBarcelona = Calendar::create(['name' => 'Barcelona']);
        $calendarBarcelona->disabledDays()->create(['day' => now()->addDays(2)]);
        $calendarBarcelona->disabledDays()->create(['day' => now()->addDays(random_int(3,7))]);

        $code = Str::upper(Str::random(6));
        $route = Route::create([
            'invitation_code' => $code,
            'title' => 'Route - '. $code .' - '.$calendarBarcelona->name,
            'start_timestamp' => now(),
            'end_timestamp' => now()->addWeek()
        ]);

        $route->data()->create([
            'calendar_id' => $calendarBarcelona->id,
            'date_init' => now(),
            'date_finish' => now()->addMonth(),
            'mon' => 1,
            'tue' => 1,
            'wed' => 1,
            'thu' => 1,
            'fri' => 1,
            'sat' => 0,
            'sun' => 0,
        ]);





    }
}
