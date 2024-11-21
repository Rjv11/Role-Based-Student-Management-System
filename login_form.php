<?php
@include 'config.php';

session_start();

// Function to get the user's real IP address
function getUserIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return explode(',', $ip)[0];
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $usn = $_POST['usn'];
    $pass = md5($_POST['password']);

    // Select user with matching email and password
    $select = "SELECT * FROM student_form WHERE USN = '$usn' AND pwd = '$pass'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Fetching user data
        $user_id = $row['id'];  // Assuming 'id' is the primary key in the table

        // Get the user's full IP address
        $ip_address = getUserIP();

        // Get the user's browser information
        $browser_name = $_SERVER['HTTP_USER_AGENT'];

        // Update IP address, browser name, and session active status in the database
        $update_user = "UPDATE student_form SET ip_address = '$ip_address', browser_name = '$browser_name', session_active = 1 WHERE id = '$user_id'";
        mysqli_query($conn, $update_user);

        // Set session variables
        $_SESSION['_name'] = $row['name'];
        $_SESSION['_email'] = $row['email'];

        // Redirect user based on their role
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location: admin_page.php');
            exit();
        } else {
            header('location: user_page.php');
            exit();
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Login now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <input type="TEXT" name="usn" required placeholder="Enter your USN">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="">
            <input type="submit" name="submit" value="Login now" class="form-btn">
            <p>Don't have an account? <a href="register_form.php">Register now</a></p>
        </form>
    </div>
</body>

</html>