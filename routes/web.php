<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile (custom - bypass Jetstream Livewire)
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('user.profile');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('user.password.update');

    // User Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');

    // User Notifications
    Route::get('/notifications', [\App\Http\Controllers\UserController::class, 'notifications'])->name('user.notifications');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\UserController::class, 'markNotificationRead'])->name('user.notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\UserController::class, 'markAllNotificationsRead'])->name('user.notifications.readAll');

    // User Rooms (katalog ruangan)
    Route::get('/rooms', [\App\Http\Controllers\UserController::class, 'rooms'])->name('user.rooms');
    Route::get('/rooms/{room}', [\App\Http\Controllers\UserController::class, 'show'])->name('user.rooms.show');

    // User Bookings
    Route::get('/bookings/create', [\App\Http\Controllers\UserBookingController::class, 'create'])->name('user.bookings.create');
    Route::post('/bookings', [\App\Http\Controllers\UserBookingController::class, 'store'])->name('user.bookings.store');
    Route::get('/bookings/my', [\App\Http\Controllers\UserBookingController::class, 'myBookings'])->name('user.bookings.my');
    Route::delete('/bookings/{booking}/cancel', [\App\Http\Controllers\UserBookingController::class, 'cancel'])->name('user.bookings.cancel');

    // AJAX: Cek konflik jadwal kelas
    Route::post('/bookings/check-schedule', [\App\Http\Controllers\UserBookingController::class, 'checkScheduleConflict'])->name('user.bookings.check-schedule');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Profile Admin
    Route::get('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'show'])->name('profile');
    Route::patch('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('password.update');

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // User Aktif (monitoring login)
    Route::get('/active-users', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'activeUsers'])->name('active-users');

    // Rooms (CRUD)
    Route::get('/rooms', [\App\Http\Controllers\Admin\RoomController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [\App\Http\Controllers\Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [\App\Http\Controllers\Admin\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [\App\Http\Controllers\Admin\RoomController::class, 'destroy'])->name('rooms.destroy');

    // Classes (CRUD)
    Route::get('/classes', [\App\Http\Controllers\Admin\ClassRoomController::class, 'index'])->name('classes.index');
    Route::post('/classes', [\App\Http\Controllers\Admin\ClassRoomController::class, 'store'])->name('classes.store');
    Route::put('/classes/{classRoom}', [\App\Http\Controllers\Admin\ClassRoomController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{classRoom}', [\App\Http\Controllers\Admin\ClassRoomController::class, 'destroy'])->name('classes.destroy');

    // Bookings
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [\App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('bookings.reject');

    // Schedules (Jadwal)
    Route::get('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/bulk', [\App\Http\Controllers\Admin\ScheduleController::class, 'createBulk'])->name('schedules.bulk');
    Route::post('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
    Route::post('/schedules/bulk', [\App\Http\Controllers\Admin\ScheduleController::class, 'storeBulk'])->name('schedules.bulk-store');
    Route::put('/schedules/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedules.update');
    Route::post('/schedules/{schedule}/toggle-status', [\App\Http\Controllers\Admin\ScheduleController::class, 'toggleStatus'])->name('schedules.toggle-status');
    Route::delete('/schedules/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Invite Codes
    Route::get('/invite-codes', [\App\Http\Controllers\Admin\InviteCodeController::class, 'index'])->name('invite-codes.index');
    Route::post('/invite-codes', [\App\Http\Controllers\Admin\InviteCodeController::class, 'store'])->name('invite-codes.store');
    Route::delete('/invite-codes/{inviteCode}', [\App\Http\Controllers\Admin\InviteCodeController::class, 'destroy'])->name('invite-codes.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
