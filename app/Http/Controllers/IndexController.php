<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Seat;
use App\Models\User;
use App\Models\Booked;
use Http;
use Auth;
use Carbon\Carbon;

class IndexController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function seats(Request $request)
    {
        $day = $request->day ?? 1;
        $model = Day::whereDate('event_date', date('Y-m-d'))
            ->orWhere('day', $day)->first();

        //
        $available = 62 - $model->total;
        $bookeds = Booked::with('user')->where('day', $day)
            ->orWhere('day', 'all')->get();

        //
        return view('index', [
            'day' => $day,
            'bookeds' => $bookeds,
            'available' => $available
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $ref)
    {
        $input = $request->all();
        $url = "https://api.paystack.co/transaction/verify/$ref";
        $token = config('paystack.secret');
        $response = Http::withToken($token)->get($url);

        $data = $response->object();
        $responseError = $response->clientError()
            ?? $response->serverError() ?? $response->failed();

        if ($responseError) {
            return response([
                'message' => 'Unable to verify payment',
                'data' => $data
            ], 400);
        }

        // User
        $user = User::firstOrCreate([
            'email' => $request->email
        ], ['name' => $request->name]);

        $days = $request->days;
        $isAll = in_array('all', $days);
        if($isAll) {
            $this->doBook('all', $user);
        }
        else {
            foreach ($days as $key => $day) $this->doBook($day, $user);
        }

        //
        return response([
            'message' => 'Payment verified',
            'data' => $data
        ]);
    }

    public function book(Request $request)
    {
        // User
        $user = User::firstOrCreate([
            'email' => $request->email
        ], ['name' => $request->name]);

        // Check is seat is available
        $currentDay = 0;
        $notAvailable = false;
        $days = $request->days;

        $isAll = in_array('all', $days);
        foreach ($days as $key => $value) {
            $currentDay = $value;

            // Check day
            if($value != 'all') {
                $day = Day::where('day', $value)->first();
                if($day->total >= 62) {
                    $notAvailable = true;
                    $reason = 'No Seat for booking on Day: ' . $currentDay;
                    break;
                }
            }

            // Check User bookeds
            $hasBooked = Booked::where('user_id', $user->id)
                ->where(function($q) use ($value) {
                    $q->where('day', $value)
                        ->orWhere('day', 'all');
                })->exists();

            if($hasBooked) {
                $notAvailable = true;
                $reason = 'This user already booked for Day: ' . $currentDay;
                break;
            }
        }

        if($notAvailable) {
            return response([
                'status' => false,
                'message' => $reason
            ], 400);
        }

        if($isAll) {
            $this->doBook('all', $user);
        }
        else {
            foreach ($days as $key => $day) {
                $this->doBook($day, $user);
            }
        }

        //
        return response([
            'status' => true,
            'message' => 'Seat booked successfully',
        ]);
    }

    private function doBook($day, $user) {

        //
        Booked::create([
            'day' => $day,
            'user_id' => $user->id
        ]);

        // Update Day
        if($day == 'all') {
            $models = Day::all();
            foreach ($models as $key => $model) {
                $model->total = $model->total + 1;
                $model->save();
            }
        }
        else {
            $model = Day::where('day', $day)->first();
            $model->total = $model->total + 1;
            $model->save();
        }
    }

    public function dash()
    {
        $users = User::with('bookeds')->paginate(20);

        //
        return view('home', [
            'users' => $users,
        ]);
    }


    public function confirm(Request $request)
    {
        // User
        $user = User::firstOrCreate([
            'email' => $request->email
        ], ['name' => $request->name]);

        // Check is seat is available
        $currentDay = 0;
        $notAvailable = false;
        $days = $request->days;

        $isAll = in_array('all', $days);
        foreach ($days as $key => $value) {
            $currentDay = $value;

            // Check day
            if($value != 'all') {
                $day = Day::where('day', $value)->first();
                if($day->total >= 62) {
                    $notAvailable = true;
                    $reason = 'No Seat for booking on Day: ' . $currentDay;
                    break;
                }
            }

            // Check User bookeds
            $hasBooked = Booked::where('user_id', $user->id)
                ->where(function($q) use ($value) {
                    $q->where('day', $value)
                        ->orWhere('day', 'all');
                })->exists();

            if($hasBooked) {
                $notAvailable = true;
                $reason = 'This user already booked for Day: ' . $currentDay;
                break;
            }
        }

        if($notAvailable) {
            return response([
                'status' => false,
                'message' => $reason
            ], 400);
        }

        //
        return response([
            'status' => true,
            'message' => 'Confirmed'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        //
        return response([
            'status' => true,
            'message' => 'successful'
        ]);
    }
}
