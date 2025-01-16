<?php
require "db.php";
session_start();

if($_SERVER['REQUEST_METHOD'] === "POST"){
  registration($_POST['username'], $_POST['email'], $_POST['password']);
  header("Location: index.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="login-container">
    <h1>Înregistrare</h1>
    <form action="register.php" method="POST">
      <label for="username">Nume utilizator</label>
      <input type="text" id="username" name="username" placeholder="Introduceți numele de utilizator" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Introduceți email-ul" required>
      
      <label for="password">Parolă</label>
      <input type="password" id="password" name="password" placeholder="Introduceți parola" required>
      
      <button type="submit">Înregistrare</button>
    </form>
  </div>
</body>
</html>
