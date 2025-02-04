<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booked;

class BookController extends Controller
{
    public function update(Request $request) {
        $input = $request->all();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'seat_id' => 'required|integer',
            'id' => 'required|exists:bookeds',
            'seat_number' => 'required|integer',
        ]);

        // Some checking


        // Find Model
        $model = Booked::findOrFail($input['id']);
        $model->seat_number = $input['seat_number'];
        $model->save();

        //
        return redirect()->back()->withInput();
    }

}
