<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Booker;
use App\Models\Booked;
use App\Models\Seat;
use App\Models\Day;
use App\Exports\BookersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\SeatBooked;

class PagesController extends Controller
{
    public function index() {
        return Inertia::render('Index', [
            'status' => session('status'),
        ]);
    }

    public function reserve() {
        return Inertia::render('Reserve', [
            'status' => session('status'),
        ]);
    }

    public function tickets() {

        $bookingCount = [];
        $categories = Category::all();
        foreach ($categories as $key => $model) {
            $model->amount = 10000; // $this->getPrice();
            $total = Booking::where('category_id', $model->id)->count();
            $bookingCount[] = [
                'id' => $model->id,
                'total' => $total
            ];
        }

        $days = Day::whereYear('event_date', date('Y'))->get();

        return Inertia::render('Ticket', [
            'days' => $days,
            'status' => session('status'),
            'categories' => $categories,
            'bookings' => $bookingCount
        ]);
    }

    public function booked() {
        return Inertia::render('Booked', [
            'status' => session('status'),
        ]);
    }

    public function thanks() {
        return Inertia::render('Thanks', [
            'status' => session('status'),
        ]);
    }

    public function dashboard() {
        $stats = [];
        $categories = Category::all();
        foreach ($categories as $key => $value) {
            $stats[] = [
                'name' => $value->name,
                'total' => Booking::where('category_id', $value->id)->count()
            ];
        }

        //
        $models = Booking::with('booker', 'booker.tickets', 'category')
            ->latest()->paginate(10);

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'models' => $models,
        ]);
    }

    public function bookers() {
        $models = Booker::latest()->paginate(10);
        return Inertia::render('Bookers', [
            'status' => session('status'),
            'models' => $models
        ]);
    }

    public function days() {
        $days = Day::whereYear('event_date', date('Y'))->get();
        return Inertia::render('Days', [
            'days' => $days,
            'status' => session('status'),
        ]);
    }

    public function seats($day) {

        $seats = Seat::all();
        $booked = Booked::where('day', $day)
            ->orWhere('day', 'all')->whereYear('created_at', date('Y'))->pluck('seat_id');

        return Inertia::render('Seats', [
            'day' => $day,
            'seats' => $seats,
            'booked' => $booked,
            'status' => session('status'),
        ]);
    }

    public function acceptance($id, $action = 'accept')
    {
        $model = Booked::findOrFail($id);
        if($action == 'accept') {
            $model->confirmed = true;
            $model->save();

            try {
                $user = User::find($model->user_id);
                Mail::to($user)->send(new SeatBooked($user, $model));
            }
            catch (\Exception $e) {
                info($e->getMessage());
            }
        }
        else $model->delete();

        //
        return redirect()->back();
    }

    public function exportQR() {
        return Excel::download(new BookersExport, 'attendees.xlsx');
    }

    private function getPrice() {
        $day = date('w');
        $isWeekend = in_array($day, [6, 7, 0]);

        $amount = 5000;
        if($isWeekend) {
            $amount = 10000;
        }

        return $amount;
    }
}
