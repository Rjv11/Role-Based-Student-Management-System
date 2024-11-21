<?php
$ipaddress = getenv("REMOTE_ADDR");
//echo "Your IP Address is " . $ipaddress;
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['user_name'])) {
//     header('location:login_form.php');  // Redirect to login page if not logged in
//     exit();
// }

$user_name = $_SESSION['_name'];
$user_email = $_SESSION['_email'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user page</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container">
        <div class="content">
            <h3>hi, <span><?php echo htmlspecialchars($user_name); ?></span></h3>
            <h1>welcome <span></span></h1>
            <p> this is a student page </p><br><br>
            <div class="button">
                <a href="student_form.php" class="btn">Student Form </a>
                <a href="my_account.php" class="btn">My account</a><br><br>
            </div>
            <a href="logout.php" class="btn">logout</a>
        </div>
    </div>
</body>

</html>