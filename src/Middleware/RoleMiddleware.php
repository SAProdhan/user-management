<?php

namespace App\Middleware;

use App\Session;

class RoleMiddleware
{
    public function handle($path)
    {
        // Check if user is authenticated
        if (!Session::get('user')) {
            // User is not authenticated, redirect to login page
            header('Location: \login');
            exit;
        }

        if(Session::get('user')['roleid'] != 1 && $path != 'users'){
            include __DIR__.'/../pages/error/401.php';
            exit;
        }
    }
}
