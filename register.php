<?php include 'includes/db.php'; ?>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone_number'];

    if (preg_match("/^(\+256|07)\d{8,9}$/", $phone_number)) {
        $sql = "INSERT INTO Users (PhoneNumber) VALUES ('$phone_number')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id;
            header("Location: main.php");
            exit();
        } else {
            die("Error: " . $sql . "<br>" . $conn->error);
        }
    } else {
        echo "Invalid phone number format.";
    }
}
?>
