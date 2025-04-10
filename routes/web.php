<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;

use App\Livewire\Chat;



Route::get('/get-countries', function () {
    return response()->json(Country::select('id', 'name')->get());
});

Route::get('/get-states/{country_id}', function ($country_id) {
    return response()->json(State::where('country_id', $country_id)->select('id', 'name')->get());
});

Route::get('/get-cities/{state_id}', function ($state_id) {
    return response()->json(City::where('state_id', $state_id)->select('id', 'name')->get());
});


Route::get('/', function () {
    return view('home');
});
Route::middleware([
    'auth:sanctum',
//    'otp',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/verification', [AuthController::class, 'verification'])->name('verification');
    Route::post('/verification', [AuthController::class, 'verificationUpdate'])->name('verification.update');
    Route::get('/settings', [UserProfileController::class, 'show'])->name('profile.settings');
    Route::resource('trip', TripController::class);
    Route::get('/search', [TripController::class, 'search'])->name('trip.search');
    Route::get('/trip/{trip}/details', [TripController::class, 'details'])->name('trip.details');

    Route::resource('booking', BookingController::class);
    Route::get('/booking/{booking}/pickup', [BookingController::class, 'pickup'])->name('booking.pickup');
    Route::post('/booking/{booking}/pickup-otp', [BookingController::class, 'pickupVerify'])->name('booking.pickup-otp');
    Route::get('/booking/{booking}/delivery', [BookingController::class, 'delivery'])->name('booking.delivery');
    Route::post('/booking/{booking}/delivery-otp', [BookingController::class, 'deliveryVerify'])->name('booking.delivery-otp');
    Route::post('/booking/{booking}/resend-otp', [BookingController::class, 'otpResend'])->name('booking.resend-otp');

    Route::resource('/order', OrderController::class);

    Route::get('/rating/{booking}', [RatingController::class, 'create'])->name('rating.create');
    Route::post('/rating/store', [RatingController::class, 'store'])->name('rating.store');

    Route::get('trip/{trip}/booking', [BookingController::class, 'create'])->name('booking');

//    Route::get('/chat/', [ChatController::class, 'index'])->name('chat');
    Route::get('/message/{receiverId?}', Chat::class)->name('message');

    Route::get('tracking/{booking_id}', [TrackingController::class, 'index'])->name('tracking');

    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

//    Route::get('/payment/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payment.callback');
//    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

    Route::get('/earnings', [\App\Http\Controllers\EarningController::class, 'index'])->name('earnings');


});

Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified']], function () {
    Route::group(['middleware' => 'role:admin'], function () {
        Route::resource('user', UserController::class);
        Route::put('/users/{user}/update-verification', [UserController::class, 'updateVerification'])->name('user.update.verification');
    });
});
Route::resource('/newsletter', NewsletterSubscriberController::class);
Route::get('/otp', [AuthController::class, 'otp'])->name('otp');
Route::get('/otp-resend', [AuthController::class, 'otpResend'])->name('otp.resend');
Route::post('/otp-verify', [AuthController::class, 'otpVerify'])->name('otp.verify');
