<?php
namespace App\Action;

use App\Session;
use App\Database;
use App\UserManagement;

class ProfileActions
{
    private $pdo;
    private $userManager;

    public function __construct()
    {
        $this->pdo = Database::getConnection();   
        $this->userManager = new UserManagement($this->pdo); 
    }
    public function index()
    {
        $user = Session::get('user');
        $csrfToken = Session::generateCsrfToken();
        include __DIR__.'/../pages/profile/index.php';
    }

    public function update()
    {
        $user = Session::get('user');
        // Retrieve user input from the form submission
        $username = isset($_POST['username']) ? $_POST['username'] : $user['username'];
        $email = isset($_POST['email']) ? $_POST['email'] : $user['email'];
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        // Sanitize user input
        $username = htmlspecialchars($username); // Sanitize username
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitize email

        $data = [];
        if(!empty($username)) $data["username"] = $username;
        if(!empty($email)) $data["email"] = $email;
        if(!empty($password)) $data["password"] = $password;

        // Create a new user using the UserManagement class
        $success = $this->userManager->update($user['id'],data:$data);

        if ($success) {
            Session::set('success', 'Profile updated successfully');
            Session::set('user', array_merge($user, $data));
        }
        $currentPageUrl = $_SERVER['REQUEST_URI'];
        header('Location: ' . $currentPageUrl);
        exit;
    }

    public function destroy()
    {   
        $id = Session::get('user')['id'];
        $success = $this->userManager->delete($id);
        if ($success) {
            Session::set('success', 'Your account deleted successfully!');
            Session::destroy();
            header('Location: /users');
            exit;
        } else {
            $currentPageUrl = $_SERVER['REQUEST_URI'];
            // Redirect back to the current page with an error message
            header('Location: ' . $currentPageUrl);
            exit;
        }
    }
}
