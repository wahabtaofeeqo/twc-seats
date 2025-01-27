<?php

namespace App\Http\Controllers;

use DB;
use Str;
use Http;
use Hash;
use Auth;
use App\Models\Day;
use App\Models\User;
use App\Models\Booker;
use App\Models\Booked;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Mail;
use App\Mail\QrCode;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Invitee;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::first();
        $category = Category::first();
    }

    private function createPayment($amount, $email, $meta) {
        try {
            $randomUUID = Str::uuid();
            $baseUrl = config('app.url');
            $reference = "Polo_" . Str::random(10) . time();
            $url = "https://api.paystack.co/transaction/initialize";

            //
            $response = Http::withToken(config('paystack.sec'))->post($url, [
                'reference' => $reference,
                'amount' => $amount * 100,
                'currency' => 'NGN',
                'email' => $email,
                'metadata' => $meta,
                'callback_url' => $baseUrl . 'bookings/verification/' . $randomUUID
            ]);
            if ($response->successful()) return $response->object()->data;
        }
        catch (\Exception $e) {
            info($e->getMessage());
        }

        //
        return null;
    }

    /**
     * Store user and Init payment
     */
    public function init(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'day' => 'required',
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = User::firstOrCreate([
            'email' => $request->email
        ], ['name' => $request->name]);

        // Create Booker Model
        $booker = Booker::create([
            'name' => $user->name,
            'is_buyer' => true,
            'email' => $input['email'],
         ]);

        $customer = [
            'name' => $user->name,
            'email' => $input['email'],
        ];

        $meta =  [
            'day' => $input['day'],
            'seat' => $input['seat'],
            'booker_id' => $booker->id
        ];

        $response = $this->createPayment(25000, $input['email'], $meta);
        if ($response) {
            return Inertia::location($response->authorization_url);
        }
        else {
            return redirect()->back()->withErrors(['message' => 'Operation not successful. Please try again.']);
        }
    }

    /**
     * Verify Payment.
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function verify($ref)
    {
        try {
            $url = "https://api.paystack.co/transaction/verify/$ref";
            $response = Http::withToken(config('paystack.sec'))->get($url);

            if ($response->successful()) {

                $data = $response->object()->data;
                if ($data->status == 'success') {

                    $meta = $data->metadata;
                    $booker = Booker::findOrFail($meta->booker_id);

                    // Check payment
                    $payment = Payment::where([
                        'tx_id' => $data->id,
                        'tx_ref' => $data->reference,
                    ])->first();

                    if($payment)
                        return $this->errResponse('Payment has been previously verified');

                    //
                    DB::beginTransaction();

                    if($meta->day) {
                        $input = [
                            'day' => $meta->day,
                            'seat_id' => $meta->seat
                        ];
                        $user = User::where('email', $booker->email)->first();
                        $this->doBook($meta->day, $user, $input);
                    }
                    else {
                        $model = null;
                        $code = $this->genCode();

                        // Get Tickets
                        $tickets = Ticket::where('booker_id', $booker->id)->get();
                        $payload = [
                            'code' => $code,
                            'confirmed' => true,
                            'booker_id' => $booker->id,
                            'category_id' => $tickets[0]->category->id
                        ];

                        //
                        $model = Booking::create($payload);
                        $this->sendTickets($model, false);
                    }

                    // Save payment
                    Payment::create([
                        'tx_id' => $data->id,
                        'amount' => $data->amount,
                        'booker_id' => $booker->id,
                        'tx_ref' => $data->reference,
                    ]);

                    // Update the Booker Model
                    $booker->confirmed = true;
                    $booker->save();

                    DB::commit();

                    //
                    return $this->okResponse('Verified successfully', []);
                }
            }
            return $this->errResponse('Operation not succeeded');
        }
        catch (\Exception $e) {
            DB::rollback();
            info($e->getMessage());
            return $this->errResponse('Payment could not be verified', 500);
        }
    }


    private function doBook($day, $user, $data) {

        $data['user_id'] = $user->id;
        if($day != 'all') {
            $date = Day::where('day', $day)
                ->whereYear('event_date', date('Y'))->first()->event_date;
            $data['event_date'] = $date;
        }

        //
        $book = Booked::create($data);

        // Update Day
        if($day == 'all') {
            $models = Day::whereYear('event_date', date('Y'))->get();
            foreach ($models as $key => $model) {
                $model->total = $model->total + 1;
                $model->save();
            }
        }
        else {
            $model = Day::where('day', $day)
                ->whereYear('event_date', date('Y'))->first();
            $model->total = $model->total + 1;
            $model->save();
        }
    }

    private function sendMail($user, $category, $rand) {
        try {
            $path = public_path('qrcode/' . $user->email);
            if(!file_exists($path)) mkdir($path, 0755, true);

            $file = "qrcode.png";
            $filename = $path . "/" . $file;

            \QrCode::color(255, 0, 127)->format('png')
                ->size(500)->generate($rand, $filename);

            //
            Mail::to($user)->send(new QrCode($user, $file, $category));
        }
        catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    private function sendTickets($booking, $isBeachBooking) {

        // Send Mail to Ticket buyer
        $code = $booking->code;
        $booker = $booking->booker;
        $this->sendMail($booker, $booking->category, $code);

        // Get Tickets
        $tickets = Ticket::where('booker_id', $booker->id)->get();

        // Get Invitees
        $invitees = Invitee::where('inviter_id', $booker->id)->get();

        // Prep total Ticket Category
        $categories = [];
        foreach ($tickets as $key => $ticket) {
            if($ticket->total == 1) {
                $categories[] = $ticket->category;
            }
            else {
                for ($i=0; $i < $ticket->total; $i++) {
                    $categories[] = $ticket->category;
                }
            }
        }

        // Remove the first Ticket from the array
        // It belongs to the real booker
        array_splice($categories, 0, 1);

        // Send Mail to Invitees
        foreach ($invitees as $key => $value) {

            $user = $value->booker;
            $code = $this->genCode();
            $category = $categories[$key];

            $data['code'] = $code;
            $data['confirmed'] = true;
            // $data['cost'] = 0; // Invitee
            $data['booker_id'] = $user->id;
            $data['category_id'] = $category->id;

            Booking::create($data);

            //
            $this->sendMail($user, $category, $code);
        }
    }

    private function genCode() {
        $total = Booking::count();
        return str_pad(strval($total + 1), 4, "0", STR_PAD_LEFT);
    }

    public function sendQr($id)
    {
        $code = $this->genCode();
        $booker = Booker::find($id);
        $tickets = Ticket::where('booker_id', $booker->id)->get();

        $payload = [
            'code' => $code,
            'confirmed' => true,
            'booker_id' => $booker->id,
            'category_id' => $tickets[0]->category->id
        ];

        //
        $model = Booking::create($payload);
        $this->sendTickets($model, false);

        // Update the Booker Model
        $booker->confirmed = true;
        $booker->save();

        return to_route('dashboard.bookers');
    }

    function createUser(Request $request) {

        $input = $request->all();
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Create Booker Model
        $name = $input['firstname'] . ' ' . $input['lastname'];
        $booker = Booker::create([
            'name' => $name,
            'is_buyer' => true,
            'confirmed' => true,
            'email' => $input['email'],
            'phone' => $input['phone'],
        ]);

        // Generate code
        $code = $this->genCode();
        $category = Category::firstOrCreate(['name' => $input['category']]);

        $payload = [
            'code' => $code,
            'confirmed' => true,
            'booker_id' => $booker->id,
            'category_id' => $category->id,
            'quantity' => $input['quantity'],
        ];

        //
        $model = Booking::create($payload);
        $this->sendTickets($model, false);

        //
        return redirect()->back();
    }
}
