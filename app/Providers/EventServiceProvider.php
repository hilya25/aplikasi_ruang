<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Saat user login: catat waktu login + tandai sedang login
        Event::listen(\Illuminate\Auth\Events\Login::class, function (\Illuminate\Auth\Events\Login $event) {
            $event->user->forceFill([
                'last_login_at'  => now(),
                'last_active_at' => now(),
                'is_logged_in'   => true,
            ])->saveQuietly();
        });

        // Saat user logout: hapus status → langsung hilang dari daftar "Sedang Login"
        Event::listen(\Illuminate\Auth\Events\Logout::class, function (\Illuminate\Auth\Events\Logout $event) {
            $event->user->forceFill([
                'last_active_at' => null,
                'is_logged_in'   => false,
            ])->saveQuietly();
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
