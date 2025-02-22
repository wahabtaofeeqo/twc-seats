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
// Route::get('/login', 'LoginController@login');
Route::get('/days', 'PagesController@days');
Route::get('/seats/{id}', 'PagesController@seats');
Route::get('/tables', 'IndexController@tables');
Route::get('/tickets', 'PagesController@tickets');
Route::get('/thanks', 'PagesController@thanks')->name('thanks');
Route::post('/bookings', 'PaymentController@init')->name('init');
Route::get('/bookings/verification/{id}', 'PagesController@booked');
Route::put('/bookings', 'BookController@update')->name('bookeds.update');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'IndexController@dash')->name('dashboard');
    Route::get('/tickets', 'IndexController@tickets')->name('tickets');
    Route::get('/export-qr', 'PagesController@exportQr')->name('export');
    Route::get('/acceptance/{id}/{action}', 'PagesController@acceptance');
    Route::get('/download-qr/{id}', 'PaymentController@downloadQr');
    Route::get('/send-qr/{id}', 'PaymentController@sendQr')->name('dashboard.sendqr');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
