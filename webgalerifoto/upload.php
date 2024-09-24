<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define the upload directory
    $uploadDir = '../uploads/';

    // Create the upload directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Process each uploaded file
    foreach ($_FILES['file']['name'] as $key => $filename) {
        $targetFile = $uploadDir . basename($filename);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['file']['tmp_name'][$key]);
        if ($check === false) {
            echo "
            <script>
                alert('File is not an image!');
                window.location.href = 'http://localhost/multiple-image-upload/';
            </script>
            ";
            exit;
        }

        // Check if the file already exists
        if (file_exists($targetFile)) {
            echo "
            <script>
                alert('File already exist!');
                window.location.href = 'http://localhost/multiple-image-upload/';
            </script>
            ";
            exit;
        }

        // Check file size
        if ($_FILES['file']['size'][$key] > 5000000) {
            echo "
            <script>
                alert('The file is too large. The maximum size is 5mb');
                window.location.href = 'http://localhost/multiple-image-upload/';
            </script>
            ";
            exit;
        }

        // Allow only certain file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "
            <script>
                alert('Only img, jpeg, png and gif is allowed.');
                window.location.href = 'http://localhost/multiple-image-upload/';
            </script>
            ";
            exit;
        }

        // Move the file to the upload directory
        if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $targetFile)) {
            echo "
            <script>
                alert('Images uploaded successfully.');
                window.location.href = 'http://localhost/multiple-image-upload/';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Error Uploading Images.');
                window.location.href = 'http://localhost/multiple-image-upload/';
            </script>
            ";
        }
    }
} else {
    // If the form is not submitted, return an error
    echo 'Invalid request.';
}
?>
