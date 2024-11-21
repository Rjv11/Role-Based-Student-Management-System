<?php
@include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['_email'])) {
    header('location:login_form.php');  // Redirect to login if not logged in
    exit();
}

$user_email = $_SESSION['_email'];
$user_email = mysqli_real_escape_string($conn, $user_email);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $usn = mysqli_real_escape_string($conn, $_POST['USN']);
    $email = mysqli_real_escape_string($conn, $_POST['E-mail']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $bld_grp = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $cu_semester = mysqli_real_escape_string($conn, $_POST['cu_semester']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Handle file upload for Photo
    $photo = $_FILES['photo']['name'];
    if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != "") {
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_folder = 'Image/';
        if (!is_dir($photo_folder)) {
            mkdir($photo_folder, 0777, true);
        }
        $photo_path = $photo_folder . $photo;
        move_uploaded_file($photo_tmp, $photo_path);
    } else {
        $photo_path = null;
    }

    // Insert data into the "student_details" table
    $update_query = "UPDATE student_details SET Photo = '$photo_path', Name = '$name', USN = '$usn', Email = '$email', Phone_number = '$phone', DOB = '$dob', Age = '$age', Blood_Group = '$bld_grp', Branch = '$branch', Current_Semester = '$cu_semester', Address = '$address' WHERE id = '$id'";
    // mysqli_query($conn, $update_query);

    if ($conn->query($update_query) === TRUE) {
        echo "Record updated successfully.";
        header("Location: StudentDetails.php"); // Redirect after update
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$stmt->close();
