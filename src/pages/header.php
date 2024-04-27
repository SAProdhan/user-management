<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        /* Header styles */
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

        .header{
            text-align: center;
            padding-top: 10px;
        }
        .container-full {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .brand {
            font-size: 1.5rem;
        }

        .brand:hover {
            cursor: pointer;
        }

        .user-dropdown {
            position: relative;
        }

        .dropbtn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            z-index: 1;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }

        .top-bar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .success-message {
            color: green;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .pagination-button {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination-button:hover {
            background-color: #0056b3;
        }

        a[disabled="disabled"] {
            opacity: .4;
            cursor: default !important;
            pointer-events: none;
        }

        /* primary button styles */

        .primary-button {
            padding: 8px 16px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .primary-button:hover {
            background-color: #218838;
        }

        /* Form input styles */
        .form-input {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Form button styles */
        .form-button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-button:hover {
            background-color: #0056b3;
        }

        /* Profile page styles */
        .title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .button {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .delete-button {
            background-color: #dc3545;
            float: right;
        }
        .delete-button:hover {
            background-color: #c82333;
        }

        .search-container {
            display: flex;
            align-items: center; /* Align items vertically */
            justify-content: space-between;
        }

        .search-input {
            height: 30px; /* Set the height of the input field */
            margin-right: 5px; /* Add some spacing between input and button */
        }

        .search-button {
            height: 36px; /* Set the height of the button to match input */
        }
    </style>
</head>

<body>
    <!-- Header section for success and error messages -->
    <header>
        <div class="container-full">
            <div class="brand" onclick="window.location.href='/users'">User Management</div>
            <div class="user-dropdown">
                <button class="dropbtn">Welcome, <?php echo isset($_SESSION['user']) ? $_SESSION['user']['username'] : ''; ?></button>
                <div class="dropdown-content">
                    <a href="/profile">Profile</a>
                    <a href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <div class="header">
        <?php
        // Check for success or error messages and display them
        if (isset($_SESSION['success'])) {
            echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']); // Clear success message after displaying
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Clear error message after displaying
        }
        ?>
    </div>