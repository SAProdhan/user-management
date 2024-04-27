<?php

namespace App\Middleware;

use App\Session;

class AuthMiddleware
{
    public function handle()
    {
        // Check if user is authenticated
        if (!Session::get('user')) {
            // User is not authenticated, redirect to login page
            header('Location: \login');
            exit;
        }
    }
}
