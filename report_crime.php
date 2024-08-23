<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<?php
$user_id = $_GET['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'] ? $_POST['location'] : $_POST['district'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $description = $_POST['description'];
    $image_path = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $sql = "INSERT INTO CrimeReports (UserID, Location, Latitude, Longitude, Description, ImagePath) VALUES ('$user_id', '$location', '$latitude', '$longitude', '$description', '$image_path')";
    if ($conn->query($sql) === TRUE) {
        echo "Crime report submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container">
    <h3><marquee bgcolor="red">FOR EMERGENCY, CALL 999 / 112 </marquee></h3>
    <h1>Report Crime to the nearest police station</h1>
    <form id="reportForm" action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="location" placeholder="Location">
        <select name="district" id="district">
            <option value="">-- Select District --</option>
            <?php
            $districts = ["Kampala", "Wakiso", "Mukono", "Jinja", "Mbarara", "Gulu", "Lira", "Mbale", "Fort Portal", "Masaka","Arua","Koboko","Yumbe","Adjumani","Moyo" /* Add all other districts */];
            foreach ($districts as $district) {
                echo "<option value=\"$district\">$district</option>";
            }
            ?>
        </select>
        <input type="hidden" name="latitude" id="latitude" required>
        <input type="hidden" name="longitude" id="longitude" required>
        <br>
        <textarea name="description" placeholder="Crime Description" required></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Submit</button>
    </form>
    <a href="main.php?user_id=<?php echo $user_id; ?>">Back</a>
</div>

<script>
document.getElementById('reportForm').onsubmit = function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('reportForm').submit();
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
