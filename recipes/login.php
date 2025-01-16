<?php
require "db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $error = login($username, $password);
    if (!isset($error)) {
        header("Location: index.php"); // Redirect to the homepage
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logare</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="login-container">
    <h1>Logare</h1>
    <form action="login.php" method="POST">
      <label for="username">Nume utilizator</label>
      <input type="text" id="username" name="username" placeholder="Introduceți numele de utilizator" required>
      
      <label for="password">Introduceți parola</label>
      <input type="password" id="password" name="password" placeholder="Introduceți parola" required>
      
      <button type="submit">Logare</button>
    </form>
    <?php if (isset($error)): ?>
      <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>  
    <p>Fără cont? <a href="register.php">Înregistrați-vă!</a></p>
  </div>
</body>
</html>
