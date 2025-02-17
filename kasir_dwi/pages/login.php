<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kasir jkt 48</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../asset/favicon-16x16.png" type="image/x-icon">
    
</head>
<body>
<div class="login-form">
    <img src="../asset/jkt48.png" alt="Logo">
    <h2 class="title">Login</h2>
    <form action="../config/login_proses.php" method="POST">
        <div class="input-container">
            <input type="text" id="username" name="username" required>
            <label for="username">Username</label>
            <div class="underline"></div>
        </div>
        <div class="input-container">
            <input type="password" id="password" name="password" required>
            <label for="password">Password</label>
            <div class="underline"></div>
        </div>
        <button type="submit" class="login-button">Login</button>
        <button type="button" class="cancel-button" onclick="window.location.href='/';">Cancel</button>
    </form>
</div>
</body>
</html>
