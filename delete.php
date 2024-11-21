<?php
@include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['_email'])) {
    header('location:login_form.php');
    exit();
}

// Retrieve the student ID from the URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

if ($id) {
    // Delete the student record from the database
    $delete_query = "DELETE FROM student_details WHERE id = '$id'";
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        echo "<script>
            alert('Student profile deleted successfully.');
            window.location.href = 'StudentDetails.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete student profile. Please try again.');
            window.location.href = 'StudentDetails.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid request. No student selected.');
        window.location.href = 'StudentDetails.php';
    </script>";
}
