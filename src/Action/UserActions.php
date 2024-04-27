<?php
namespace App\Action;

use App\Session;
use App\Database;
use App\UserManagement;

class UserActions
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
        // Fetch user data with pagination
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10;
        $term = isset($_GET['term']) ? $_GET['term'] : "";
        $userData = $this->userManager->read(page:$page, perPage:$perPage,searchKey:$term);

        // Extract user data
        $users = $userData['users'];
        $totalCount = $userData['totalCount'];

        $prevPage = $page > 1 ? $page - 1 : false; 
        $nextPage = $totalCount > $perPage*$page ? $page + 1 : false;

        $prevLink = "/users?page=$prevPage";
        $nextLink = "/users?page=$nextPage";

        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $queryParams);
        unset($queryParams['page']); // Remove 'page' parameter if it exists
        $queryString = http_build_query($queryParams);
        
        if (!empty($queryString)) {
            $prevLink .= "&$queryString";
            $nextLink .= "&$queryString";
        }

        // Render user table with pagination
        include __DIR__.'/../pages/user/index.php';
    }

    public function create()
    {
        $csrfToken = Session::generateCsrfToken();
        include __DIR__.'/../pages/user/create.php';
    }

    public function store()
    {
        // Retrieve user input from the form submission
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $roleid = isset($_POST['roleid']) ? $_POST['roleid'] : null;

        // Sanitize user input
        $username = htmlspecialchars($username); // Sanitize username
        $roleid = htmlspecialchars($roleid); // Sanitize roleid
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitize email

        // Create a new user using the UserManagement class
        $success = $this->userManager->create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'roleid' => $roleid
        ]);

        if ($success) {
            Session::set('success',"User created successfully!");
            header('Location: /users');
            exit;
        } else {
            header('Location: /users/create');
            exit;
        }
    }

    public function edit()
    {
        if (!isset($_GET['id'])) {
            http_response_code(404);
            exit('Route not found');
        }
        $id = $_GET['id'];
        $user = $this->userManager->read(
            conditions:['id'=>$id],
            perPage:1
        );
        if (!empty($user['users'])) {
            $user = $user['users'][0];
            $csrfToken = Session::generateCsrfToken();
            include __DIR__.'/../pages/user/edit.php';
        } else {
            // If user does not exist, redirect back to user list with error message
            header('Location: /users?error=User not found');
            exit;
        }
    }

    public function update()
    {
        if (!isset($_POST['id'])) {
            http_response_code(404);
            include __DIR__.'/../pages/error/404.php';
            exit;
        }
        $id = $_POST['id'];

        // Retrieve user input from the form submission
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $roleid = isset($_POST['roleid']) ? $_POST['roleid'] : '';

        // Sanitize user input
        $username = htmlspecialchars($username); // Sanitize username
        $roleid = htmlspecialchars($roleid); // Sanitize roleid
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitize email

        $data = [];
        if(!empty($username)) $data["username"] = $username;
        if(!empty($email)) $data["email"] = $email;
        if(!empty($password)) $data["password"] = $password;
        if(!empty($roleid)) $data["roleid"] = $roleid;

        // Create a new user using the UserManagement class
        $success = $this->userManager->update($id,data:$data);

        if ($success) {
            Session::set('success', 'User updated successfully');
            header('Location: /users');
            exit;
        } else {
            header('Location: /users');
            exit;
        }
    }

    public function delete()
    {   
        if (!isset($_POST['id'])) {
            http_response_code(404);
            include __DIR__.'/../pages/error/404.php';
            exit;
        }
        $id = $_POST['id'];
        $success = $this->userManager->delete($id);
        if ($success) {
            Session::set('success', 'User deleted successfully');
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
