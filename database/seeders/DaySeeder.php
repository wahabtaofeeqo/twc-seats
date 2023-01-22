<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Day;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counter = 0;
        for ($i = 0; $i < 23 ; $i++) {

            $isMonday = false;
            $date = Carbon::parse('2023-01-28')->addDays($i);

            //
            $day = date('w', strtotime($date));
            if($day == 1) $isMonday = true;

            Day::create([
                'day' => $counter + 1,
                'event_date' => $date,
            ]);

            if(!$isMonday) $counter++;
        }
    }
}
