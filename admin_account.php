<?php
@include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['_email'])) {
    header('location:login_form.php');  // Redirect to login if not logged in
    exit();
}

$admin_email = $_SESSION['_email'];
$admin_email = mysqli_real_escape_string($conn, $admin_email);

// Query to fetch the user's current data
$select = "SELECT * FROM student_form WHERE email='$admin_email'";
$result = mysqli_query($conn, $select);

if (isset($_POST['submit'])) {
    // Retrieve and sanitize the form inputs
    $new_pass = md5($_POST['new_pwd']); // New password
    $re_pass = md5($_POST['re_pwd']); // Re-entered password

    // Check if new passwords match
    if ($new_pass != $re_pass) {
        $error[] = 'New passwords do not match.';
    } else {
        // Update the password in the database
        $update = "UPDATE student_form SET pwd='$new_pass' WHERE email='$admin_email'";
        $update_result = mysqli_query($conn, $update);

        if ($update_result) {
            $success_msg = 'Password updated successfully.';
        } else {
            $error[] = 'Failed to update password.';
        }
    }
}

// Check if result is valid before accessing user data
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    // Handle case where no user is found
    $error[] = 'No user found.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="update_details">
        <h3>My <span> Profile </span></h3><br>

        <?php
        // Check if $row is not null before displaying user details
        if (isset($row)) {
            echo '<h2 class="tab">' . 'Name: ' . htmlspecialchars($row['name']) . '</h2> <br>';
            echo '<h2 class="tab">' . 'Email: ' . htmlspecialchars($row['email']) . '</h2><br>';
        } else {
            echo '<h2>User data could not be fetched.</h2>';
        }
        ?>



        <h1>Change Password</h1><br>

        <?php
        // Display error or success messages
        if (isset($error)) {
            foreach ($error as $error_message) {
                echo '<span class="error-msg">' . $error_message . '</span><br>';
            }
        }
        if (isset($success_msg)) {
            echo '<span class="success-msg">' . $success_msg . '</span><br>';
        }
        ?>

        <!-- Form for changing the password -->
        <form action="admin_account.php" method="POST" style="width:100%" class="update-form">
            <div class="form-fields">
                <h1>New Password:</h1>
                <input type="password" name="new_pwd" required placeholder="Enter the new password">
            </div>
            <div class="form-fields">
                <h1> Re-Enter: </h1>
                <input type="password" name="re_pwd" required placeholder="Re-enter the new password">
            </div>
            <input type="submit" name="submit" value="Update Password" class="form-btn">
        </form>

        <a href="admin_page.php" class="btn">Back</a>
    </div>
</body>

</html>


</body>

</html>