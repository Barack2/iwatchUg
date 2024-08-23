<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<style>
    .scrollable-table {
        width: 100%;
        overflow: auto;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        min-width: 1000px; /* Adjust this value as needed */
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<?php
$user_id = $_GET['user_id'];
$filter = $_GET['filter'] ?? 'all';
$selected_date = $_GET['selected_date'] ?? '';

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$tomorrow = date('Y-m-d', strtotime('+1 day'));

if ($filter === 'today') {
    $sql = "SELECT * FROM CrimeReports WHERE UserID = '$user_id' AND DATE(Date) = '$today'";
} elseif ($filter === 'yesterday') {
    $sql = "SELECT * FROM CrimeReports WHERE UserID = '$user_id' AND DATE(Date) = '$yesterday'";
} elseif ($filter === 'tomorrow') {
    $sql = "SELECT * FROM CrimeReports WHERE UserID = '$user_id' AND DATE(Date) = '$tomorrow'";
} elseif ($selected_date) {
    $sql = "SELECT * FROM CrimeReports WHERE UserID = '$user_id' AND DATE(Date) = '$selected_date'";
} else {
    $sql = "SELECT * FROM CrimeReports WHERE UserID = '$user_id'";
}

$result = $conn->query($sql);
?>

<div class="container">
    <h1>My Reports</h1>
    <form method="GET" action="">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="filter">Filter by date:</label>
        <select name="filter" onchange="this.form.submit()">
            <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
            <option value="today" <?php if ($filter == 'today') echo 'selected'; ?>>Today</option>
            <option value="yesterday" <?php if ($filter == 'yesterday') echo 'selected'; ?>>Yesterday</option>
            <option value="tomorrow" <?php if ($filter == 'tomorrow') echo 'selected'; ?>>Tomorrow</option>
        </select>
        <label for="selected_date">Select date:</label>
        <input type="date" name="selected_date" value="<?php echo htmlspecialchars($selected_date); ?>" onchange="this.form.submit()">
    </form>
    <div class="scrollable-table">
        <table>
            <tr>
                <th>Date and Time</th>
                <th>Location</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "<td>" . $row['Location'] . "</td>";
                    echo "<td>" . $row['Latitude'] . "</td>";
                    echo "<td>" . $row['Longitude'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td>";
                    if ($row['ImagePath']) {
                        echo "<a href='" . $row['ImagePath'] . "' target='_blank'>";
                        echo "<img src='" . $row['ImagePath'] . "' alt='Crime Image' style='width:100px;height:auto;'>";
                        echo "</a>";
                    }
                    echo "</td>";
                    echo "<td>" . ($row['ReportSeen'] ? 'Seen' : 'Not Seen') . "</td>";
                    echo "<td>
                            <a href='edit_report.php?report_id=" . $row['ReportID'] . "&user_id=$user_id'>Edit</a> |
                            <a href='delete_report.php?report_id=" . $row['ReportID'] . "&user_id=$user_id'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No reports found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <a href="main.php?user_id=<?php echo $user_id; ?>">Back</a>
</div>

</body>
</html>
