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

        $data = [
            [
                'day' => 1,
                'event_date' =>  Carbon::parse('2024-01-26')
            ],
            [
                'day' => 2,
                'event_date' =>  Carbon::parse('2024-01-27')
            ],
            [
                'day' => 3,
                'event_date' =>  Carbon::parse('2024-01-28')
            ],

            [
                'day' => 4,
                'event_date' =>  Carbon::parse('2024-02-02')
            ],
            [
                'day' => 5,
                'event_date' =>  Carbon::parse('2024-02-03')
            ],
            [
                'day' => 6,
                'event_date' =>  Carbon::parse('2024-02-04')
            ],

            [
                'day' => 7,
                'event_date' =>  Carbon::parse('2024-02-09')
            ],
            [
                'day' => 8,
                'event_date' =>  Carbon::parse('2024-02-10')
            ],
            [
                'day' => 9,
                'event_date' =>  Carbon::parse('2024-02-11')
            ],

            [
                'day' => 10,
                'event_date' =>  Carbon::parse('2024-02-16')
            ],
            [
                'day' => 11,
                'event_date' =>  Carbon::parse('2024-02-17')
            ],
            [
                'day' => 12,
                'event_date' =>  Carbon::parse('2024-02-18')
            ]
        ];

        foreach ($data as $key => $value) {
            $model = Day::where('day', $value['day'])
                ->whereYear('event_date', date('Y'))->first();

            if($model) {
                $model->fill($value);
                $model->save();
            }
            else Day::create($value);
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
