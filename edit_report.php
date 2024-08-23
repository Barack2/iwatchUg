<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
$report_id = $_GET['report_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $description = $_POST['description'];
    $image_path = $_POST['existing_image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $sql = "UPDATE CrimeReports SET Location='$location', Latitude='$latitude', Longitude='$longitude', Description='$description', ImagePath='$image_path' WHERE ReportID='$report_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Report updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM CrimeReports WHERE ReportID='$report_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="container">
    <h1>Edit Report</h1>
    <form id="editReportForm" action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="location" value="<?php echo $row['Location']; ?>" required>
        <input type="hidden" name="latitude" id="latitude" value="<?php echo $row['Latitude']; ?>" required>
        <input type="hidden" name="longitude" id="longitude" value="<?php echo $row['Longitude']; ?>" required>
        <textarea name="description" required><?php echo $row['Description']; ?></textarea>
        <input type="hidden" name="existing_image" value="<?php echo $row['ImagePath']; ?>">
        <input type="file" name="image" accept="image/*">
        <button type="submit">Update</button>
    </form>
    <?php
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        echo "<a href='my_reports.php?user_id=$user_id'>Back</a>";
    } else {
        echo "<a href='admin_dashboard.php'>Back</a>";
    }
    ?>
</div>

<script>
document.getElementById('editReportForm').onsubmit = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('editReportForm').submit();
        }, function(error) {
            alert('Error getting location: ' + error.message);
        });
        return false;
    } else {
        alert('Geolocation is not supported by this browser.');
        return false;
    }
};
</script>

</body>
</html>
