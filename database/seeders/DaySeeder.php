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
        $data = [
            [
                'day' => 7,
                'event_date' =>  Carbon::parse('2023-02-04')
            ],
            [
                'day' => 8,
                'event_date' =>  Carbon::parse('2023-02-05')
            ],
            [
                'day' => 13,
                'event_date' =>  Carbon::parse('2023-02-11')
            ],
            [
                'day' => 14,
                'event_date' =>  Carbon::parse('2023-02-12')
            ],
            [
                'day' => 19,
                'event_date' =>  Carbon::parse('2023-02-18')
            ],
            [
                'day' => 20,
                'event_date' =>  Carbon::parse('2023-02-19')
            ]
        ];

        foreach ($data as $key => $value) {
            Day::create($value);
        }

        // $counter = 0;
        // for ($i = 0; $i < 23 ; $i++) {

        //     $isMonday = false;
        //     $date = Carbon::parse('2023-01-28')->addDays($i);

        //     //
        //     $day = date('w', strtotime($date));
        //     if($day == 1) $isMonday = true;

        //     Day::create([
        //         'day' => $counter + 1,
        //         'event_date' => $date,
        //     ]);

        //     if(!$isMonday) $counter++;
        // }
    }
}
