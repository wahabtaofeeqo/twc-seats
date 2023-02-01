<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Seat;
use App\Models\User;
use App\Models\Booked;
use App\Models\Ticket;
use Http;
use Auth;
use Mail;
use App\Mail\SeatBooked;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function tables(Request $request)
    {
        $bookedCouchs = [];
        $model = Day::whereDate('event_date', '>=', date('Y-m-d'))->first();

        if($model) {
            $bookedCouchs = Booked::where('type', 'couch')
                ->where(function($q) use ($model) {
                    $q->where('day', 'all')
                        ->orWhere('day', $model->day);
                })->pluck('seat_number')->toArray();
        }

        //
        return view('table', [
            'couch' => $bookedCouchs,
        ]);
    }

    public function seats(Request $request)
    {
        $seats = Seat::all();
        $model = Day::whereDate('event_date', '>=', date('Y-m-d'))->first();

        //
        $bookedSeats = [];
        $bookedCouchs = [];

        if($model) {
            $bookedSeats = Booked::where('day', $model->day)
                ->orWhere('day', 'all')->pluck('seat_id')->toArray();

            $bookedCouchs = Booked::where('type', 'couch')
                ->where(function($q) use ($model) {
                    $q->where('day', 'all')
                        ->orWhere('day', $model->day);
                })->pluck('seat_number')->toArray();
        }

        //
        return view('index', [
            'seats' => $seats,
            'couch' => $bookedCouchs,
            'bookeds' => $bookedSeats,
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

        $body = $response->object();
        $responseError = $response->clientError()
            ?? $response->serverError() ?? $response->failed();

        if ($responseError) {
            return response([
                'message' => 'Unable to verify payment',
                'data' => $body
            ], 400);
        }

        if($body->data->status != 'success') {
            return response([
                'message' => 'Unable to verify payment',
                'data' => $body
            ], 400);
        }

        // User
        $user = User::firstOrCreate([
            'email' => $request->email
        ], ['name' => $request->name]);

        $days = $request->days;
        $isAll = in_array('all', $days);
        if($isAll) {
            $this->doBook('all', $user, $request->id);
        }
        else {
            foreach ($days as $key => $day)
                $this->doBook($day, $user, $request->id);
        }

        // Send Main
        try {
            Mail::to('precious@wristbands.ng')
                ->send(new SeatBooked($user, $body->data));
        }
        catch (\Exception $e) {}

        //
        return response([
            'status' => true,
            'message' => 'Payment verified',
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

        $type = $request->type ?? 'chair';
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
                })->where('type', $type)->exists();

            if($hasBooked) {
                $notAvailable = true;
                $reason = 'This user already booked for Day: ' . $currentDay;
                break;
            }

            // Check if seat has been booked for that day
            $hasBooked = Booked::where('seat_id', $request->seat_id)
                ->where(function($q) use ($value) {
                    $q->where('day', $value)
                        ->orWhere('day', 'all');
                })->where('type', $type)->exists();

            if($hasBooked) {
                $notAvailable = true;
                $reason = 'This seat has already been booked for Day: ' . $currentDay;
                break;
            }
        }

        if($notAvailable) {
            return response([
                'status' => false,
                'message' => $reason
            ], 400);
        }

        $input = $request->all();

        if($isAll) {
            $input['day'] = 'all';
            $this->doBook('all', $user);
        }
        else {
            foreach ($days as $key => $day) {
                $input['day'] = $day;
                $this->doBook($day, $user, $input);
            }
        }

        //
        return response([
            'status' => true,
            'message' => 'Seat booked successfully',
        ]);
    }

    private function doBook($day, $user, $data) {

        $data['user_id'] = $user->id;
        if($day != 'all') {
            $date = Day::where('day', $day)->first()->event_date;
            $data['event_date'] = $date;
        }

        //
        Booked::create($data);

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
        $bookings = Booked::with('user')->paginate(20);
        $days = Day::all();

        //
        return view('home', [
            'days' => $days,
            'bookings' => $bookings,
            'users' => User::count(),
            'totalTickets' => Ticket::count(),
            'totalBookings' => Booked::count()
        ]);
    }

    public function tickets()
    {
        $tickets = Ticket::with('user')->paginate(20);

        //
        return view('ticket', [
            'tickets' => $tickets,
            'users' => User::count(),
            'totalTickets' => Ticket::count(),
            'totalBookings' => Booked::count()
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
        $type = $request->type ?? 'chair';
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
                })->where('type', $type)->exists();

            if($hasBooked) {
                $notAvailable = true;
                $reason = 'This user already booked for Day: ' . $currentDay;
                break;
            }

            // Check if seat has been booked for that day
            $hasBooked = Booked::where('seat_id', $request->seat_id)
                ->where(function($q) use ($value) {
                    $q->where('day', $value)
                        ->orWhere('day', 'all');
                })->where('type', $type)->exists();

            if($hasBooked) {
                $notAvailable = true;
                $reason = 'This seat has already been booked for Day: ' . $currentDay;
                break;
            }
        }

        if($notAvailable) {
            return response([
                'status' => false,
                'message' => $reason
            ], 400);
        }

        // Log Booking
        $days = $request->days;
        $isAll = in_array('all', $days);

        $input = $request->all();
        if($isAll) {
            $input['day'] = 'all';
            $this->doBook('all', $user, $input);
        }
        else {
            foreach ($days as $key => $day) {
                $input['day'] = $day;
                $this->doBook($day, $user, $input);
            }
        }

        //
        return response([
            'status' => true,
            'message' => 'Booking has been sent successfully'
        ]);
    }

    public function cancel(Request $request)
    {
        if($request->type == 'booking')
            $model = Booked::findOrFail($request->id);
        else
            $model = Ticket::findOrFail($request->id);

        $model->delete();

        //
        return response([
            'status' => true,
            'message' => 'Booking canceled successfully'
        ]);
    }

    public function approve(Request $request)
    {
        if($request->type == 'booking')
            $model = Booked::findOrFail($request->id);
        else
            $model = Ticket::findOrFail($request->id);

        $model->confirmed = true;
        $model->save();

        if($request->type == 'booking') {
            $user = User::find($model->user_id);
            try {
                Mail::to($user)->send(new SeatBooked($user, $model));
            }
            catch (\Exception $e) {
                //throw $th;
            }
        }

        //
        return response([
            'status' => true,
            'message' => 'Booking confirmed successfully'
        ]);
    }

    public function ticket(Request $request)
    {
        // User
        $user = User::firstOrCreate([
            'email' => $request->email
        ], ['name' => $request->name]);

        $exists = Ticket::where('user_id', $user->id)
            ->where('day', $request->day)->exists();

        if($exists) {
            return response([
                'status' => false,
                'message' => 'You have already sent a request'
            ], 400);
        }

        $data = [
            'day' => $request->day,
            'user_id' => $user->id,
            'total' => $request->total
        ];

        if($request->day != 'all') {
            $date = Day::where('day', $day)->first()->event_date;
            $data['event_date'] = $date;
        }

        Ticket::create($data);

        //
        return response([
            'status' => true,
            'message' => 'Booking has been sent successfully'
        ]);
    }
}
