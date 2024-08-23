<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Include the rest of your admin dashboard code here
include 'includes/header.php';
include 'includes/db.php';

// Unset the session after the page loads so admin has to login again next time
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- Rest of your dashboard content -->
    <a href="admin_logout.php">Logout</a>
</body>
</html>


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
    .status-select {
        width: 120px;
    }
    #userManagementSection {
        display: none; /* Hide by default */
    }
</style>

<script>
    function toggleUserManagement() {
        var section = document.getElementById('userManagementSection');
        if (section.style.display === 'none' || section.style.display === '') {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    }
</script>

<?php
$filter = $_GET['filter'] ?? 'all';
$selected_date = $_GET['selected_date'] ?? '';

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$tomorrow = date('Y-m-d', strtotime('+1 day'));

if ($filter === 'today') {
    $sql = "SELECT * FROM CrimeReports WHERE DATE(Date) = '$today'";
} elseif ($filter === 'yesterday') {
    $sql = "SELECT * FROM CrimeReports WHERE DATE(Date) = '$yesterday'";
} elseif ($filter === 'tomorrow') {
    $sql = "SELECT * FROM CrimeReports WHERE DATE(Date) = '$tomorrow'";
} elseif ($selected_date) {
    $sql = "SELECT * FROM CrimeReports WHERE DATE(Date) = '$selected_date'";
} else {
    $sql = "SELECT * FROM CrimeReports";
}

$result = $conn->query($sql);

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $report_id = $_POST['report_id'];
    $new_status = $_POST['status'];

    $update_sql = "UPDATE CrimeReports SET Status='$new_status' WHERE ReportID='$report_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Status updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle user status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['status'];

    $update_sql = "UPDATE Users SET Status='$new_status' WHERE UserID='$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "User status updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $delete_sql = "DELETE FROM Users WHERE UserID='$user_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch users
$sql_users = "SELECT * FROM Users";
$result_users = $conn->query($sql_users);
?>

<div class="container">
    <h1>Admin Dashboard</h1>
    <form method="GET" action="">
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
                <th>UserID</th>
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
                    $report_id = $row['ReportID'];
                    $conn->query("UPDATE CrimeReports SET ReportSeen=TRUE WHERE ReportID='$report_id'");

                    echo "<tr>";
                    echo "<td>" . $row['UserID'] . "</td>";
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
                    echo "<td>";
                    
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='report_id' value='" . $report_id . "'>";
                    echo "<select name='status' class='status-select'>";
                    echo "<option value='Pending'" . ($row['Status'] == 'Pending' ? ' selected' : '') . ">Pending</option>";
                    echo "<option value='Resolved'" . ($row['Status'] == 'Resolved' ? ' selected' : '') . ">Resolved</option>";
                   // echo "<option value='Requiring Court'" . ($row['Status'] == 'Requiring Court' ? ' selected' : '') . ">Requiring Court</option>";
                    echo "</select>";
                    //echo "<button type='submit' name='update_status'>Update</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td>
                            <a href='edit_report.php?report_id=" . $row['ReportID'] . "'>Edit</a> |
                            <a href='delete_report.php?report_id=" . $row['ReportID'] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No reports found.</td></tr>";
            }
            
            ?>
        </table>
    </div>
    <button onclick="toggleUserManagement()">Manage Users</button>
    <div id="userManagementSection">
        <h1>User Management</h1>
        <div class="scrollable-table">
            <table>
                <tr>
                    <th>UserID</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($result_users->num_rows > 0) {
                    while($row = $result_users->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        echo "<td>" . $row['PhoneNumber'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='' style='display:inline;'>";
                        echo "<input type='hidden' name='user_id' value='" . $row['UserID'] . "'>";
                        echo "<select name='status' class='status-select'>";
                        echo "<option value='Active'" . ($row['Status'] == 'Active' ? ' selected' : '') . ">Active</option>";
                       // echo "<option value='Disabled'" . ($row['Status'] == 'Disabled' ? ' selected' : '') . ">Disabled</option>";
                        echo "</select>";
                       // echo "<button type='submit' name='update_user_status'>Update</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='' style='display:inline;'>";
                        echo "<input type='hidden' name='user_id' value='" . $row['UserID'] . "'>";
                        echo "<button type='submit' name='delete_user' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>
