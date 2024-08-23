<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<div class="container">
<h3><marquee text bgcolor="red">FOR EMERGENCY, CALL 999 / 112 </marquee></h3>
    <h1>iWatch</h1>
    <a href="report_crime.php?user_id=<?php echo $user_id; ?>">Report a Crime</a>
    <a href="my_reports.php?user_id=<?php echo $user_id; ?>">My Reports</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
