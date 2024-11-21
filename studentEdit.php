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


$urlid = $_GET['id'];


// Query to select users with active sessions
$query = "SELECT * FROM student_details where id= $urlid";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Check if query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
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
        <?php if (isset($row)) { ?>
            <form action="studentUpdate.php" method="POST" enctype="multipart/form-data">
                <h3>Student Details Form</h3>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <!-- Photo Display -->
                <?php if (!empty($row['Photo'])): ?>
                    <img id="previewImage" src="<?php echo $row['Photo']; ?>" alt="Photo" style="width: 150px; height: auto; margin-bottom: 10px;">
                <?php endif; ?>

                <input id="imageInput" type="file" name="photo" placeholder="Upload Photo">

                <label for="name">Name:</label>
                <input type="text" name="name" required placeholder="<?php echo $row['Name']; ?>" value="<?php echo $row['Name']; ?>">

                <!-- USN Field with the retrieved USN as its value -->
                <label for="USN">USN:</label>
                <input type="text" name="USN" required placeholder="<?php echo $row['USN']; ?>" value="<?php echo $row['USN']; ?>">
                <label for="E-mail">Email:</label>
                <input type="email" name="E-mail" required placeholder="<?php echo $row['Email']; ?>" value="<?php echo $row['Email']; ?>">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" required placeholder="<?php echo $row['Phone_number']; ?>" value="<?php echo $row['Phone_number']; ?>">
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" required placeholder="<?php echo $row['DOB']; ?>" value="<?php echo $row['DOB']; ?>">
                <label for="age">Age:</label>
                <input type="number" name="age" required placeholder="<?php echo $row['Age']; ?>" value="<?php echo $row['Age']; ?>">

                <!-- Blood Group Dropdown -->
                <label for="blood_group">BLOOD GROUP:</label>
                <select name="blood_group" required>
                    <option value="" disabled selected>Select Blood Group</option>
                    <option value="A+" <?php if ($row['Blood_Group'] == 'A+') echo 'selected'; ?>>A+</option>
                    <option value="A-" <?php if ($row['Blood_Group'] == 'A-') echo 'selected'; ?>>A-</option>
                    <option value="B+" <?php if ($row['Blood_Group'] == 'B+') echo 'selected'; ?>>B+</option>
                    <option value="B-" <?php if ($row['Blood_Group'] == 'B-') echo 'selected'; ?>>B-</option>
                    <option value="AB+" <?php if ($row['Blood_Group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                    <option value="AB-" <?php if ($row['Blood_Group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                    <option value="O+" <?php if ($row['Blood_Group'] == 'O+') echo 'selected'; ?>>O+</option>
                    <option value="O-" <?php if ($row['Blood_Group'] == 'O-') echo 'selected'; ?>>O-</option>
                </select><br><br>

                <!-- Branch Dropdown -->
                <label for="branch">Branch:</label>
                <select name="branch" required>
                    <option value="" disabled selected>Select Branch</option>
                    <option value="Aeronautical Engineering" <?php if ($row['Branch'] == 'Aeronautical Engineering') echo 'selected'; ?>>Aeronautical Engineering</option>
                    <option value="Aerospace Engineering" <?php if ($row['Branch'] == 'Aerospace Engineering') echo 'selected'; ?>>Aerospace Engineering</option>
                    <option value="Biomedical Engineering" <?php if ($row['Branch'] == 'Biomedical Engineering') echo 'selected'; ?>>Biomedical Engineering</option>
                    <option value="Chemical Engineering" <?php if ($row['Branch'] == 'Chemical Engineering') echo 'selected'; ?>>Chemical Engineering</option>
                    <option value="Civil Engineering" <?php if ($row['Branch'] == 'Civil Engineering') echo 'selected'; ?>>Civil Engineering</option>
                    <option value="Computer Science Engineering" <?php if ($row['Branch'] == 'Computer Science Engineering') echo 'selected'; ?>>Computer Science Engineering</option>
                    <option value="Electrical and Electronics Engineering" <?php if ($row['Branch'] == 'Electrical and Electronics Engineering') echo 'selected'; ?>>Electrical and Electronics Engineering</option>
                    <option value="Electronics and Communication Engineering" <?php if ($row['Branch'] == 'Electronics and Communication Engineering') echo 'selected'; ?>>Electronics and Communication Engineering</option>
                    <option value="Information Technology" <?php if ($row['Branch'] == 'Information Technology') echo 'selected'; ?>>Information Technology</option>
                    <option value="Mechanical Engineering" <?php if ($row['Branch'] == 'Mechanical Engineering') echo 'selected'; ?>>Mechanical Engineering</option>
                </select><br><br>

                <!-- Semester Dropdown -->
                <label for="cu_semester">Current Semester:</label>
                <select name="cu_semester" required>
                    <option value="" disabled selected>Select Current Semester</option>
                    <option value="1st Year 1st Sem" <?php if ($row['Current_Semester'] == '1st Year 1st Sem') echo 'selected'; ?>>1st Year 1st Sem</option>
                    <option value="1st Year 2nd Sem" <?php if ($row['Current_Semester'] == '1st Year 2nd Sem') echo 'selected'; ?>>1st Year 2nd Sem</option>
                    <option value="2nd Year 1st Sem" <?php if ($row['Current_Semester'] == '2nd Year 1st Sem') echo 'selected'; ?>>2nd Year 1st Sem</option>
                    <option value="2nd Year 2nd Sem" <?php if ($row['Current_Semester'] == '2nd Year 2nd Sem') echo 'selected'; ?>>2nd Year 2nd Sem</option>
                    <option value="3rd Year 1st Sem" <?php if ($row['Current_Semester'] == '3rd Year 1st Sem') echo 'selected'; ?>>3rd Year 1st Sem</option>
                    <option value="3rd Year 2nd Sem" <?php if ($row['Current_Semester'] == '3rd Year 2nd Sem') echo 'selected'; ?>>3rd Year 2nd Sem</option>
                    <option value="4th Year 1st Sem" <?php if ($row['Current_Semester'] == '4th Year 1st Sem') echo 'selected'; ?>>4th Year 1st Sem</option>
                    <option value="4th Year 2nd Sem" <?php if ($row['Current_Semester'] == '4th Year 2nd Sem') echo 'selected'; ?>>4th Year 2nd Sem</option>
                </select>
                <label for="address">Address:</label>
                <input type="text" name="address" required placeholder="<?php echo $row['Address']; ?>" value="<?php echo $row['Address']; ?>"><br><br>
                <input type="submit" name="submit" value="Update" class="form-btn">
            </form>
        <?php } ?>
    </div>
    <script>
        // JavaScript to handle dynamic image update
        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            // Check if a file is selected and it's an image
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                // When the file is read, update the image source
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                };

                // Read the file as a data URL
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>