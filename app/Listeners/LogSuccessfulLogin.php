<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use App\Models\LoginLog;

class LogSuccessfulLogin
{
    /**
     * @var Request
     */
    public $request;

    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        // Inject request untuk mendapatkan IP dan User Agent
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // $event->user akan berisi instance model User yang baru saja login
        LoginLog::create([
            'user_id' => $event->user->id,
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'logged_in_at' => now(),
        ]);
    }
}
