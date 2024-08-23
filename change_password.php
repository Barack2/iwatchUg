<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];

    if ($new_password === 'admin123') {
        echo "Password changed successfully.";
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error_message = 'Failed to change the password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #e6f2ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .container h1 {
            color: #007bff;
        }
        .container label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }
        .container input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #0056b3;
        }
        .back-button {
            margin-top: 10px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }
        .back-button:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Change Password</h1>
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
        <form method="POST" action="">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit">Change Password</button>
        </form>
        <a href="admin_dashboard.php" class="back-button">Back to Admin Dashboard</a>
    </div>
</body>
</html>
