<?php
require "db.php";
session_start();
$categories = getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: index.php"); }
  postRecipe($_SESSION['username'], $_POST['category'], $_POST['title'], $_POST['content']) ;
  header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postează rețetă</title>
  <link rel="stylesheet" href="post.css">
</head>
<body>

<header>
    <?php if (isset($_SESSION['logged_in'])): ?>
        <p> <?= $_SESSION['username'] ?> </p>
    <?php endif; ?>    
    <nav>
    <?php if (!isset($_SESSION['logged_in'])): ?>
    <?php header("location: login.php"); ?>
    <?php else: ?>
        <form method= "POST">
            <Button type = "submit" name= "logout" value= "Logout" class="button">Delogare</button>
        </form>
    <?php endif; ?>  
    </nav>
</header>

<main>
  <div class="form-container">
    <form action="post.php" method="POST">
      <label for="title">Titlu</label>
      <input type="text" id="title" name="title" placeholder="Introduceți titlul rețetei" required>
      
      <label for="content">Conținut</label>
      <textarea id="content" name="content" placeholder="Introduceți conținutul rețetei" rows="20" required></textarea>

      <label for="category">Alege categoria</label>
      <select name= "category" id= "category">
        <?php foreach ($categories as $category): ?> 
        <option value="<?=$category?>"><?=$category?></option>
        <?php endforeach; ?>
        </select>
      <button type="submit" class = "submitbutton">Posteaza</button>
    </form>
  </div>
</main>
  
</body>
</html>
