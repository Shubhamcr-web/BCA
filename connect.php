// upload.php

<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Upload file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES["file"];
    $filename = $file["name"];
    $uploadOk = 1;

    // Check if file is a document or note
    if ($file["type"] != "application/pdf" && $file["type"] != "application/docx" && $file["type"] != "application/doc") {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists("uploads/" . $filename)) {
        $uploadOk = 0;
    }

    // Upload file
    if ($uploadOk == 1) {
        move_uploaded_file($file["tmp_name"], "uploads/" . $filename);
        // Insert file into database
        $sql = "INSERT INTO files (filename, filetype) VALUES ('$filename', '$file[type]')";
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully";
        } else {
            echo "Error uploading file: " . $conn->error;
        }
    } else {
        echo "Error uploading file";
    }
}

// Close connection
$conn->close();
?>
```