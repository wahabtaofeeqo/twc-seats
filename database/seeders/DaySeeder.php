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
        // $data = [
        //     [
        //         'day' => 7,
        //         'event_date' =>  Carbon::parse('2023-02-04')
        //     ],
        //     [
        //         'day' => 8,
        //         'event_date' =>  Carbon::parse('2023-02-05')
        //     ],
        //     [
        //         'day' => 13,
        //         'event_date' =>  Carbon::parse('2023-02-11')
        //     ],
        //     [
        //         'day' => 14,
        //         'event_date' =>  Carbon::parse('2023-02-12')
        //     ],
        //     [
        //         'day' => 19,
        //         'event_date' =>  Carbon::parse('2023-02-18')
        //     ],
        //     [
        //         'day' => 20,
        //         'event_date' =>  Carbon::parse('2023-02-19')
        //     ]
        // ];

        // $data = [
        //     [
        //         'day' => 1,
        //         'event_date' =>  Carbon::parse('2025-01-26')
        //     ],
        //     [
        //         'day' => 2,
        //         'event_date' =>  Carbon::parse('2025-01-27')
        //     ],
        //     [
        //         'day' => 3,
        //         'event_date' =>  Carbon::parse('2025-01-28')
        //     ],

        //     [
        //         'day' => 4,
        //         'event_date' =>  Carbon::parse('2025-02-02')
        //     ],
        //     [
        //         'day' => 5,
        //         'event_date' =>  Carbon::parse('2025-02-03')
        //     ],
        //     [
        //         'day' => 6,
        //         'event_date' =>  Carbon::parse('2025-02-04')
        //     ],

        //     [
        //         'day' => 7,
        //         'event_date' =>  Carbon::parse('2025-02-09')
        //     ],
        //     [
        //         'day' => 8,
        //         'event_date' =>  Carbon::parse('2025-02-10')
        //     ],
        //     [
        //         'day' => 9,
        //         'event_date' =>  Carbon::parse('2025-02-11')
        //     ],

        //     [
        //         'day' => 10,
        //         'event_date' =>  Carbon::parse('2025-02-16')
        //     ],
        //     [
        //         'day' => 11,
        //         'event_date' =>  Carbon::parse('2025-02-17')
        //     ],
        //     [
        //         'day' => 12,
        //         'event_date' =>  Carbon::parse('2025-02-18')
        //     ]
        // ];

        // foreach ($data as $key => $value) {
        //     $model = Day::where('day', $value['day'])
        //         ->whereYear('event_date', date('Y'))->first();

        //     if($model) {
        //         $model->fill($value);
        //         $model->save();
        //     }
        //     else Day::create($value);
        // }

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

        $dates = [
            '1' => 'Feb 4th ' . date('Y'),
            '2' => 'Feb 5th ' . date('Y'),
            '3' => 'Feb 6th ' . date('Y'),

            '4' => 'Feb 7th ' . date('Y'),
            '5' => 'Feb 8th ' . date('Y'),
            '6' => 'Feb 9th ' . date('Y'),

            '7' => 'Feb 11th ' . date('Y'),
            '8' => 'Feb 12th ' . date('Y'),
            '9' => 'Feb 13th ' . date('Y'),

            '10' => 'Feb 14th ' . date('Y'),
            '11' => 'Feb 15th ' . date('Y'),
            '12' => 'Feb 16th ' . date('Y'),

            '13' => 'Feb 18th ' . date('Y'),
            '14' => 'Feb 19th ' . date('Y'),
            '15' => 'Feb 20th ' . date('Y'),

            '16' => 'Feb 21st ' . date('Y'),
            '17' => 'Feb 22nd ' . date('Y'),
            '18' => 'Feb 23rd ' . date('Y'),

        ];

        Day::whereYear('event_date', date('Y'))->delete();

        $isCreated = Day::whereYear('event_date', date('Y'))->exists();
        if(!$isCreated) {
            foreach ($dates as $key => $value) {
                Day::create([
                    'day' => $key,
                    'event_date' => new Carbon($value)
                ]);
            }
        }
    }
}
