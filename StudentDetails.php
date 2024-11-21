<?php
@include 'config.php';

print_r(session_start());


// Query to select users with active sessions
$query = "SELECT * FROM student_information";
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
    <title>Student Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container rj">
        <h1>Student Details:</h1><br>
        <div class="table1">
            <?php

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>id</th><th>Photo</th><th>Name</th><th>USN</th><th>Email</th><th>Phone_number</th><th>DOB</th><th>Age</th><th>Blood_Group</th><th>Branch</th><th>Current_Semester</th><th>Address</th><th>Actions</th></tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td><img class="img" src=' . htmlspecialchars($row['Photo']) . ' ></img></td>';
                    echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['USN']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Phone_number']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DOB']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Age']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Blood_Group']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Branch']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Current_Semester']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Address']) . '</td>';
                    echo '<td>';
                    echo '<a href="studentEdit.php?id=' . $row['id'] . '" class="link"><i class="fas fa-edit" style="color: #1029ec;"></i></a> | ';
                    echo '<a href="delete.php?id=' . $row['id'] . '" class="link" onclick="return confirm(\'Are you sure you want to delete this student\'s profile?\')"><i class="fas fa-trash" style="color: #ff1e05;"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                }


                echo '</table>';
            }
            ?>
        </div>
        <br>
        <a href="admin_page.php" class="btn">Back to Home Page</a>
    </div>
</body>

</html>