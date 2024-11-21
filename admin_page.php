<?php
session_start();
$admin_name = $_SESSION['admin_name'];
$admin_email = $_SESSION['_email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin_page.css">



</head>

<body>
    <div class="container">
        <div class="content">
            <h3>hi, <span><?php echo htmlspecialchars($admin_name); ?></span></h3>
            <h1>welcome <span></span></h1>
            <p> This is an admin page </p>
            <div class="admin_buttons">
                <a href="admin_account.php" class="ad_btn">My account</a>
                <a href="users_online.php" class="ad_btn">User Status</a>
                <a href="StudentDetails.php" class="ad_btn">Student Details</a>
            </div>
            <a href="logout.php" class="ad_btn">logout</a>
        </div>
    </div>


</body>

</html>