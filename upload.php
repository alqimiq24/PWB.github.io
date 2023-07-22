<?php
// Check if the user is logged in
if (empty($_SESSION['user_id'])) {
    // The user is not logged in, so redirect them to the login page
    header('Location: login.php?error=not_logged_in');
    exit;
}

// Check if the file was uploaded successfully
if (!empty($_FILES['file'])) {
    // Validate the file
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    // Check if the file is an image
    if ($file_type !== 'image/jpeg' && $file_type !== 'image/png' && $file_type !== 'image/gif') {
        echo 'The file is not an image.';
        exit;
    }

    // Check if the file is too large
    if ($file_size > 1000000) {
        echo 'The file is too large.';
        exit;
    }

    // Save the file to the server
    $file_path = 'uploads/' . $file_name;
    move_uploaded_file($_FILES['file']['tmp_name'], $file_path);

    // Publish the file to the homepage
    $sql = "INSERT INTO images (image_name, image_size, image_type) VALUES ('$file_name', '$file_size', '$file_type');";
    mysqli_query($conn, $sql);

    // Redirect the user to the homepage
    header('Location: lobby.html');
} else {
    // The file was not uploaded successfully, so display an error message
    echo 'There was an error uploading the file.';
}
?>
