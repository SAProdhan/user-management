<?php
namespace App\Action;

use App\Database;
use App\Session;
use App\UserManagement;

class LoginActions {

    public function index()
    {
        // Check if already login
        if(Session::get('user')){
            header('Location: /users'); // Redirect to the home page
            exit;
        }
        // Render login page
        $csrfToken = Session::generateCsrfToken();
        include __DIR__.'/../pages/login.php';
    }

    public function login()
    {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || !Session::verifyCsrfToken($_POST['csrf_token'])) {
            exit('CSRF token verification failed');
        }

        if(!isset($_POST['username']) && !isset($_POST['password'])){
            Session::set('error', "Username and password can not be empty!");
            header('Location: login.php');
            exit;
        }
        // Retrieve user input from the form submission
        $username = isset($_POST['username']);
        $password = isset($_POST['password']);

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get username and password from the form
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = (new UserManagement(Database::getConnection()))->read(conditions:['username'=>$username],perPage:1)['users'];
            if(empty($user)){
                Session::set('error', "User not found!");
                header('Location: /login');
                exit;
            }
            $user = $user[0];
            // Validate the credentials
            if ($username === $user['username'] && password_verify($password, $user['password'])) {
                // Authentication successful
                unset($user['password']);
                Session::set('user',$user);
                header('Location: /users'); // Redirect to the home page
                exit;
            } else {
                // Authentication failed
                $_SESSION['error'] = 'Invalid username or password';
                header('Location: /login'); // Redirect back to the login page with error message
                exit;
            }
        } else {
            // If form is not submitted, redirect to login page
            header('Location: /login');
            exit;
        }
    }

    public function logout()
    {
        // Clear all session data
        Session::destroy();

        // Redirect the user to the login page
        header('Location: /login');
        exit;
    }
}