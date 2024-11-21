<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['_email'])) {
    header('location:login_form.php');  // Redirect to login if not logged in
    exit();
}

$user_email = $_SESSION['_email'];
$user_email = mysqli_real_escape_string($conn, $user_email);

// Query to retrieve the USN of the logged-in user
$usn = '';  // Initialize $usn as an empty string
$select_usn = "SELECT USN FROM student_form WHERE email='$user_email'";
$result_usn = mysqli_query($conn, $select_usn);

if ($result_usn && mysqli_num_rows($result_usn) > 0) {
    $row = mysqli_fetch_assoc($result_usn);
    $usn = $row['USN'];
}

if (isset($_POST['submit'])) {
    // Capture form data
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
    $insert_query = "INSERT INTO `student_information` (Photo, Name, USN, Email, Phone_number, DOB, Age, Blood_Group, Branch, Current_Semester, Address)
                     VALUES ('$photo_path', '$name', '$usn', '$email', '$phone', '$dob', '$age', '$bld_grp', '$branch', '$cu_semester', '$address')";
    mysqli_query($conn, $insert_query);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="update_details">
        <form action="student_form.php" method="POST" enctype="multipart/form-data">
            <h3>Student Details Form</h3>
            <label for="photo">Photo:</label>
            <input type="file" name="photo" required placeholder="Upload Photo">
            <label for="name">Name:</label>
            <input type="text" name="name" required placeholder="Enter Name">

            <!-- USN Field with the retrieved USN as its value -->
            <label for="USN">USN:</label>
            <input type="text" name="USN" required placeholder="Enter USN" value="<?php echo htmlspecialchars($usn); ?>" readonly>
            <label for="E-mail">Email:</label>
            <input type="email" name="E-mail" required placeholder="Enter Email" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" required placeholder="Enter Phone Number">
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required placeholder="Enter Date of Birth">
            <label for="age">Age:</label>
            <input type="number" name="age" required placeholder="Enter Age">

            <!-- Blood Group Dropdown -->
            <label for="blood_group">BLOOD GROUP:</label>
            <select name="blood_group" required>
                <option value="" disabled selected>Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select><br><br>

            <!-- Branch Dropdown -->
            <label for="branch">Branch:</label>
            <select name="branch" required>
                <option value="" disabled selected>Select Branch</option>
                <option value="Aeronautical Engineering">Aeronautical Engineering</option>
                <option value="Aerospace Engineering">Aerospace Engineering</option>
                <option value="Biomedical Engineering">Biomedical Engineering</option>
                <option value="Chemical Engineering">Chemical Engineering</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value="Computer Science Engineering">Computer Science Engineering</option>
                <option value="Electrical and Electronics Engineering">Electrical and Electronics Engineering</option>
                <option value="Electronics and Communication Engineering">Electronics and Communication Engineering</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
            </select><br><br>

            <!-- Semester Dropdown -->
            <label for="cu_semester">Current Semester:</label>
            <select name="cu_semester" required>
                <option value="" disabled selected>Select Current Semester</option>
                <option value="1st Year 1st Sem">1st Year 1st Sem</option>
                <option value="1st Year 2nd Sem">1st Year 2nd Sem</option>
                <option value="2nd Year 1st Sem">2nd Year 1st Sem</option>
                <option value="2nd Year 2nd Sem">2nd Year 2nd Sem</option>
                <option value="3rd Year 1st Sem">3rd Year 1st Sem</option>
                <option value="3rd Year 2nd Sem">3rd Year 2nd Sem</option>
                <option value="4th Year 1st Sem">4th Year 1st Sem</option>
                <option value="4th Year 2nd Sem">4th Year 2nd Sem</option>
            </select>
            <label for="address">Address:</label>
            <input type="text" name="address" required placeholder="Enter Address"><br><br>
            <input type="submit" name="submit" value="Submit" class="form-btn">
        </form>
    </div>
</body>

</html>