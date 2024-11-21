<?php
@include 'config.php';

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $usn = $_POST['USN'];
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = "student";

    // USN pattern for PHP validation for College (DSU)
    $usn_pattern = "/^[ENG]{3}\d{2}[A-Z]{2}\d{4}$/";

    // Check if email already exists
    $result = mysqli_query($conn, "SELECT count(*) as count FROM student_form WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    // Validate USN pattern
    if (!preg_match($usn_pattern, $usn)) {
        $error[] = 'Invalid USN format. Please use the format: ENG21AM0097';
    }

    // Check for existing user and other validation errors
    if ($row['count'] > 0) {
        $error[] = 'User already exists!';
    } elseif ($pass != $cpass) {
        $error[] = 'Passwords do not match.';
    } elseif (empty($error)) {
        // If no errors, insert new user
        $insert = mysqli_query($conn, "INSERT INTO student_form (name, email, pwd, Confirm_password,USN,user_type) VALUES ('$name', '$email', '$pass', '$cpass', '$usn','$user_type')");

        if ($insert) {
            header('Location: login_form.php');
        } else {
            $error[] = 'Registration failed. Please try again.';
        }
    }

    // Function to capture IP address
    function getUserIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if ($ip == '::1' || $ip == '127.0.0.1') {
            $ip = file_get_contents('http://ipinfo.io/ip');
        }

        return trim($ip);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3 class="registerh1">Register Now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $errorMsg) {
                    echo '<span class="error-msg">' . $errorMsg . '</span>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="text" name="USN" pattern="[A-Z]{3}\d{2}[A-Z]{2}\d{4}" required placeholder="Enter your USN">
            <span class="note">Format: Three uppercase letters, two digits, two uppercase letters, and four digits (e.g., ENG21AM0097)</span>

            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login now</a></p>
        </form>
    </div>

</body>

</html>