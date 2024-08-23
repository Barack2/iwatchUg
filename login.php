<?php include 'includes/db.php'; ?>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];
    
    if (preg_match("/^(\+256|07)\d{8,9}$/", $phone_number)) {
        $sql = "SELECT UserID FROM Users WHERE PhoneNumber = '$phone_number'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['UserID'];
            header("Location: main.php");
            exit();
        } else {
            echo "Phone number not registered.";
        }
    } else {
        echo "Invalid phone number format.";
    }
}
?>
