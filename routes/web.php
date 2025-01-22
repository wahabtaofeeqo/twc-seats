<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', 'IndexController@index');
Route::get('/login', 'LoginController@login');
Route::get('/seats', 'IndexController@seats')->name('seats');
Route::get('/tables', 'IndexController@tables')->name('seats');
Route::get('/tickets', 'PagesController@tickets')->name('ticket');
Route::post('/bookings', 'PaymentController@init');
Route::get('/bookings/verification/{id}', 'PagesController@booked');

// Route::post('/login', 'LoginController@authenticate')->name('login');
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'IndexController@dash')->name('dashboard');
    Route::get('/tickets', 'IndexController@tickets')->name('tickets');
    Route::get('/export-qr', 'PagesController@exportQr')->name('export');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
