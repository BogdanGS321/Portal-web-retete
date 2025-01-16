<?php
require "db.php";
session_start(); 
$recipes = getRecipes();

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: index.php"); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal rețete</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <header>
    <?php if (isset($_SESSION['logged_in'])): ?>
        <p> <?= $_SESSION['username'] ?> </p>
    <?php endif; ?>    
    <nav>
    <?php if (!isset($_SESSION['logged_in'])): ?>
        <a href="login.php" class="button">Logare</a>
        <a href="register.php" class="button">Înregistrare</a>
    <?php else: ?>
      <?php if($_SESSION['admin'] == 1): ?>
      <a href="admin.php"> <button class="button">Panou administrator</button> </a>
      <?php endif; ?>

      <a href="post.php"> <button class="button">Postează o rețetă</button> </a>

        <form method= "POST">
            <Button type = "submit" name= "logout" value= "Logout" class="button">Delogare</button>
        </form>
     
    <?php endif; ?>  
      
    </nav>
  </header>

  <main>
    <div class="recipe-container">
      <?php foreach($recipes as $recipe): ?>
      <div class="recipe">
        <a href = "recipe.php?id=<?= $recipe['RecipeID']?>">
          <?= $recipe['Title'] ?>
      </a>
      </div>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>
