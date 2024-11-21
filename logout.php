<?php
session_start();
@include 'config.php';

// Update session status to 0 on logout
if (isset($_SESSION['admin_name'])) {
    mysqli_query($conn, "UPDATE student_form SET session_active = 0 WHERE name = '{$_SESSION['admin_name']}'");
    unset($_SESSION['admin_name']);
}

if (isset($_SESSION['user_name'])) {
    mysqli_query($conn, "UPDATE user_form SET session_active = 0 WHERE name = '{$_SESSION['user_name']}'");
    unset($_SESSION['user_name']);
}

header('location:login_form.php');
