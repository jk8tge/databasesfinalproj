<?php
session_start();

// Include database connection file
include 'connect-db.php';

// Function to validate credentials
function validate_login($username, $password) {
    global $db;
    $stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    return $user && password_verify($password, $user['password']);
}

$login_message = "";
$is_login_successful = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (validate_login($username, $password)) {
        $_SESSION['username'] = $username;
        $login_message = "Login successful. Welcome, " . htmlspecialchars($username) . "!";
        $is_login_successful = true;
    } else {
        $login_message = "Login failed. Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Status</title>
    <link rel="stylesheet" href="css/loginphp.css">
</head>
<body>
    <div class="login-status-container">
        <h2><?php echo $login_message; ?></h2>
        <?php if ($is_login_successful): ?>
            <p><a href="index.php">Proceed to Main Page</a></p>
        <?php else: ?>
            <p><a href="login.html">Return to login Page</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
