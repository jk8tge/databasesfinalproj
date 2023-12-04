<?php
// Include database connection file
include 'connect-db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $is_register_successful = false;

    // Check if username already exists
    if (!username_exists($username)) {
        // Insert new user into the database
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);
        $register_message = "Registration successful. You can now <a href='login.html'>login</a>.";
        $is_register_successful = true;
    } else {
        $register_message = "Username already exists. Please choose another username.";
    }
}

// Function to check if username exists
function username_exists($username) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch() ? true : false;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Status</title>
    <link rel="stylesheet" href="css/loginphp.css">
</head>
<body>
    <div class="register-status-container">
        <h2><?php echo $register_message; ?></h2>
        <?php if($is_register_successful): ?>
            <p><a href="login.html">Register Success, Log in here</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
