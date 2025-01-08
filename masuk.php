<?php
session_start();
require_once('koneksi.php');

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT id_akun, password FROM akun WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($id_akun, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id_akun'] = $id_akun; // Menggunakan $id_akun yang sudah di-bind

            // Check if the username is 'admin'
            if ($_POST['username'] === 'admin') {
                // Check if the password matches the hardcoded 'admin123'
                // Hash the plain text 'admin123' and compare it with the stored hash
                if (password_verify('admin123', $password)) {
                    header('Location: admin/menu-panel.php');
                    exit();
                }
            }
            // If not admin credentials, redirect to home.php
            header('Location: home.php');
            exit();
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }

    $stmt->close();
}
