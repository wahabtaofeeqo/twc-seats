<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Booker;
use App\Exports\BookersExport;
use Maatwebsite\Excel\Facades\Excel;

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
            $total = Booking::where('category_id', $model->id)->count();
            $bookingCount[] = [
                'id' => $model->id,
                'total' => $total
            ];
        }

        return Inertia::render('Ticket', [
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

    public function exportQR() {
        return Excel::download(new BookersExport, 'attendees.xlsx');
    }
}
