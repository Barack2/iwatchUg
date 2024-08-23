<?php include 'includes/db.php'; ?>

<?php
$report_id = $_GET['report_id'];

$sql = "DELETE FROM CrimeReports WHERE ReportID='$report_id'";
if ($conn->query($sql) === TRUE) {
    echo "Report deleted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    header("Location: my_reports.php?user_id=$user_id");
} else {
    header("Location: admin_dashboard.php");
}
exit();
?>
