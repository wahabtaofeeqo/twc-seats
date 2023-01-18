<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\User;
use Http;
use Auth;
use Carbon\Carbon;

class IndexController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function seats()
    {
        // Available seats for Today
        $seats = Seat::with('user')
            ->whereDate('created_at', Carbon::today())->get();

        // Create if empty
        if($seats->isEmpty()) {
            for ($i = 0; $i < 62; $i++) {
                Seat::create([]);
            }

            //
            $seats = Seat::with('user')
                ->whereDate('created_at', Carbon::today())->get();
        }

        //
        return view('index', [
            'seats' => $seats
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
        $seat = Seat::findOrFail($input['id']);

        $url = "https://api.paystack.co/transaction/verify/$ref";
        $token = config('paystack.secret');
        $response = Http::withToken($token)->get($url);

        $data = $response->object();
        $responseError = $response->clientError() ?? $response->serverError();
        if ($responseError) {
            return response([
                'message' => 'Unable to verify payment',
                'data' => $data
            ], 400);
        }

        //
        unset($input['id']);
        $user = User::create($input);

        //
        $seat->user_id = $user->id;
        $seat->save();

        //
        return response([
            'message' => 'Payment verified',
            'data' => $data
        ]);
    }

    public function book(Request $request)
    {
        // Find a free seat for today
        $seat = Seat::where('user_id', null)
            ->whereDate('created_at', Carbon::today())->first();

        if(!$seat) {
            return response([
                'status' => false,
                'message' => 'No free Seat for booking Today',
            ], 400);
        }

        $user = User::firstOrCreate([
            'email' => $request->email
        ], $request->all());

        // Check if user has book seat Today
        $hasBooked = Seat::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())->exists();

        if($hasBooked) {
            return response([
                'status' => false,
                'message' => 'This person has a Seat already for Today',
            ], 400);
        }

        // Book the Seat
        $seat->user_id = $user->id;
        $seat->save();

        //
        return response([
            'status' => true,
            'message' => 'Seat booked successfully',
            'data' => $seat
        ]);
    }

    public function dash()
    {
        $seats = Seat::count();
        $users = User::paginate(20);

        $todayFreeSeats = Seat::whereDate('created_at', Carbon::today())
            ->where('user_id', null)->count();

        $todayBookedSeats = Seat::whereDate('created_at', Carbon::today())
            ->where('user_id', '!=', null)->count();

        //
        return view('home', [
            'users' => $users,
            'seats' => $seats,
            'today' => $todayBookedSeats . " / " . $todayFreeSeats
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
