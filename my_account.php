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

// Fetch user details
$select_user = "SELECT * FROM student_form WHERE email='$user_email'";
$result_user = mysqli_query($conn, $select_user);
$user_data = mysqli_fetch_assoc($result_user);

$select_student = "SELECT * FROM student_information WHERE email='$user_email'";
$result_student = mysqli_query($conn, $select_student);
$student_data = mysqli_fetch_assoc($result_student);

// Handle password update
if (isset($_POST['submit'])) {
    $new_pass = md5($_POST['new_pwd']);
    $re_pass = md5($_POST['re_pwd']);

    if ($new_pass != $re_pass) {
        $error[] = 'New passwords do not match.';
    } else {
        $update_pass = "UPDATE student_form SET pwd='$new_pass' WHERE email='$user_email'";
        $update_result = mysqli_query($conn, $update_pass);

        if ($update_result) {
            $success_msg = 'Password updated successfully.';
        } else {
            $error[] = 'Failed to update password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="my-account-container">
        <h3>My <span>Profile</span></h3>

        <!-- Profile Section -->
        <div class="profile-section">
            <?php if (isset($student_data['Photo']) && !empty($student_data['Photo'])): ?>
                <img src="<?php echo $student_data['Photo']; ?>" alt="Profile Image" class="profile-img">
            <?php else: ?>
                <p>No photo available.</p>
            <?php endif; ?>

            <div class="user-info">
                <h2>Name: <?php echo htmlspecialchars($user_data['name']); ?></h2>
                <h2>Email: <?php echo htmlspecialchars($user_data['email']); ?></h2>
            </div>
        </div>

        <!-- Password Update Section -->
        <h3>Change Password</h3>
        <?php
        if (isset($error)) {
            foreach ($error as $error_message) {
                echo '<span class="error-msg">' . $error_message . '</span><br>';
            }
        }
        if (isset($success_msg)) {
            echo '<span class="success-msg">' . $success_msg . '</span><br>';
        }
        ?>

        <form action="my_account.php" method="POST" class="update-form">
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="new_pwd" required placeholder="Enter new password">
            </div>
            <div class="form-group">
                <label>Re-Enter New Password:</label>
                <input type="password" name="re_pwd" required placeholder="Re-enter new password">
            </div>
            <input type="submit" name="submit" value="Update Password" class="form-btn">
        </form>

        <a href="user_page.php" class="btn">Back</a>
    </div>
</body>

</html>