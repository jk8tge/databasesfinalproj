<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

?>

<nav>
    <link rel="stylesheet" href="css/nav.css">

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="players.php">Players</a></li>
        <li><a href="teamstat.php">Teams</a></li>
        <li><a href="favorites.php">Favorites</a></li>
        <li class="username-display">
            <?php 
            if (isset($_SESSION['username'])) {
                echo "Logged in as: " . htmlspecialchars($_SESSION['username']);
            } else {
                echo "<a href='login.html'>Login</a>";
            }
            ?>
        </li>
        <?php if (isset($_SESSION['username'])): ?>
        <li class="logout-button">
            <a href="logout.php">Logout</a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<style>
nav {
    background-color: #092c5c; /* Deep blue, reminiscent of MLB logo */
    padding: 10px 0;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
}

nav ul li {
    display: inline;
    margin: 0 30px;
}

nav ul li a {
    color: #ffffff;
    text-transform: uppercase;
    text-decoration: none;
    padding: 5px 10px;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #092c5c; /* Accent color on hover */
}

a {
    font-size: 30px; /* Increased font size for links */
}

</style>
