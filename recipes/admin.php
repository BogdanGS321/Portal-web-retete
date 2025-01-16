<?php 
require "db.php";
session_start();
if ($_SESSION['admin'] != 1) {
    header ("Location: index.php");
    exit;
}; 
$categories = getCategories();
$users = getUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panou administrator</title>
    <link rel="stylesheet" href = "admin.css">
</head>
<body>
<header>
    <?php if (isset($_SESSION['logged_in'])): ?>
        <p> <?= $_SESSION['username'] ?> </p>
    <?php endif; ?>    
    <nav>
    <?php if (!isset($_SESSION['logged_in'])): ?>
        <a href="login.php" class="button">Log in</a>
        <a href="register.php" class="button">Sign up</a>
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



    <div class="container">
        <h1>Panou administrator</h1>
        <div class="section">
            <h2>Șterge utilizatori</h2>
            <form action="delete_user.php" method="POST">
                <label for="username">Numele utilizatorului</label>
                <input type="text" id="username" name="username" placeholder="Introdu numele utilizatorului" required>
                <button type="submit" class = "adminbutton">Șterge utilizator</button>
            </form>
        </div>

        <div class="section">
            <h2>Adaugă Categorii Noi</h2>
            <form action="add_category.php" method="POST">
                <label for="category-name">Numele Categoriei</label>
                <input type="text" id="category-name" name="category-name" placeholder="Introdu numele categoriei" required>
                <button type="submit" class = "adminbutton">Adaugă Categorie</button>
            </form>
        </div>

        <div class="section">
            <h2>Șterge categorii</h2>
            <form action="delete_category.php" method="POST">
                <select name="category" id="category">
                <?php foreach ($categories as $category): ?> 
                <option value="<?=$category?>"><?=$category?></option>
                <?php endforeach; ?>
                </select>
                <button type="submit" class = "adminbutton">Șterge Categoria</button>
            </form>
        </div>

    </div>
</body>
</html>
