<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\User;
use Http;

class IndexController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function seats()
    {
        $seats = Seat::with('user')->get();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
