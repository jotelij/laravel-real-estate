<?php

use App\Enums\UserRole;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\PropertyController as AgentPropertyController;
use App\Http\Controllers\Agent\EnquiryController as AgentEnquiryController;
use App\Http\Controllers\Agent\ViewingController as AgentViewingController;
use App\Http\Controllers\Customer\EnquiryController as CustomerEnquiryController;
use App\Http\Controllers\Customer\FavouriteController as CustomerFavouriteController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ViewingController as CustomerViewingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\AgentProfileController as GuestAgentProfileController;
use App\Http\Controllers\Guest\PropertyController as GuestPropertyController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/listings', [GuestPropertyController::class, 'index'])->name('guest.properties.index');
Route::get('/listings/{property}', [GuestPropertyController::class, 'show'])->name('guest.properties.show');
Route::get('/agents/{agent_profile}', [GuestAgentProfileController::class, 'show'])->name('guest.agents.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    // accont info
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.info');
    Route::patch('/profile', [ProfileController::class, 'updateInfo'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.destroy');
}); 

// TODO: add the verified middleware back after email verification is implemented
// Route::middleware(['auth', 'verified', 'role:'.UserRole::CUSTOMER->value])->group(function () {
Route::middleware(['auth', 'role:'.UserRole::CUSTOMER->value])->group(function () {
    Route::get('customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('customer/favourites', [CustomerFavouriteController::class, 'index'])->name('customer.favourites');
    Route::get('customer/enquiries', [CustomerEnquiryController::class, 'index'])->name('customer.enquiries.index');
    Route::get('customer/enquiries/{enquiry}', [CustomerEnquiryController::class, 'show'])->name('customer.enquiries.show');
    Route::post('customer/enquiries/{enquiry}/messages', [CustomerEnquiryController::class, 'storeMessage'])->name('customer.enquiries.messages.store');

    Route::get('customer/viewings', [CustomerViewingController::class, 'index'])->name('customer.viewings.index');
    Route::get('customer/viewings/{viewing}', [CustomerViewingController::class, 'show'])->name('customer.viewings.show');
});

// TODO: add the verified middleware back after email verification is implemented
Route::middleware(['auth', 'role:'.UserRole::AGENT->value])->group(function () {
    Route::get('agent/dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard');
    Route::get('agent/properties', [AgentPropertyController::class, 'index'])->name('agent.properties.index');
    Route::get('agent/properties/create', [AgentPropertyController::class, 'create'])->name('agent.properties.create');
    Route::post('agent/properties', [AgentPropertyController::class, 'store'])->name('agent.properties.store');
    Route::get('agent/properties/{property}/edit', [AgentPropertyController::class, 'edit'])->name('agent.properties.edit');
    Route::put('agent/properties/{property}', [AgentPropertyController::class, 'update'])->name('agent.properties.update');
    Route::delete('agent/properties/{property}', [AgentPropertyController::class, 'destroy'])->name('agent.properties.destroy');

    Route::get('agent/enquiries', [AgentEnquiryController::class, 'index'])->name('agent.enquiries.index');
    Route::get('agent/enquiries/{enquiry}', [AgentEnquiryController::class, 'show'])->name('agent.enquiries.show');
    Route::post('agent/enquiries/{enquiry}/resolved', [AgentEnquiryController::class, 'markAsResolved'])->name('agent.enquiries.resolved');
    Route::post('agent/enquiries/{enquiry}/messages', [AgentEnquiryController::class, 'storeMessage'])->name('agent.enquiries.messages.store');

    Route::get('agent/viewings', [AgentViewingController::class, 'index'])->name('agent.viewings.index');
});

require __DIR__.'/auth.php';