<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Image Update</title>
</head>

<body>

    <h2>Update Image Dynamically</h2>

    <!-- Image element -->
    <img id="previewImage" src="default.jpg" alt="Preview" width="300">

    <!-- File input for uploading image -->
    <input type="file" id="imageInput" accept="image/*">

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