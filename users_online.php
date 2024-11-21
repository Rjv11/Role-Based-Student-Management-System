<?php
@include 'config.php';
print_r(session_start());


// Query to select users with active sessions
$query = "SELECT name, email, ip_address, browser_name, session_active FROM student_form WHERE session_active = 1";
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container rj">
        <h1>Users Currently Online...</h1>

        <?php

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>Name</th><th>Email</th><th>IP Address</th><th>Browser Info</th><th>Status</th></tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['ip_address']) . '</td>';
                echo '<td>' . htmlspecialchars($row['browser_name']) . '</td>';


                if ($row['session_active'] == 1) {
                    echo '<td>Online</td>';
                } else {
                    echo '<td>Offline</td>';
                }

                echo '</tr>';
            }


            echo '</table>';
        } else {
            echo '<p>No users are online at the moment.</p>';
        }
        ?>
        <br>
        <a href="admin_page.php" class="btn">Back to Home Page</a>
    </div>
</body>

</html>