<?php
session_start();

// Create directory to store images if it doesn't exist
if (!file_exists('images')) {
    mkdir('images', 0777, true);
}

// Check if file is uploaded
if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];

    // Check if file is an image and its size is less than 1M
    if (!in_array($file_type, ['image/jpeg', 'image/png', 'image/gif']) || $file_size > 1024 * 1024) {
        $_SESSION['error'] = 'Invalid file type or size. Please upload an image less than 1M.';
        header('Location: index.php');
        exit;
    }

    // Move uploaded file to images directory
    $new_file_name = uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
    move_uploaded_file($file_tmp, 'images/' . $new_file_name);

    // Store data in JSON file
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'image' => $new_file_name,
    ];

    $database = 'database.json';
    if (file_exists($database)) {
        $existing_data = json_decode(file_get_contents($database), true);
        $existing_data[] = $data;
        file_put_contents($database, json_encode($existing_data));
    } else {
        file_put_contents($database, json_encode([$data]));
    }

    // Redirect to display all registered users
    header('Location: display_users.php');
    exit;
}
?>
