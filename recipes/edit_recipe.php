<?php
require "db.php";
session_start();
$categories = getCategories();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $recipeDetails = getRecipeByID($id);
}
    if ($_SESSION['username'] != getUserbyID($recipeDetails['UserID'])) {
        header("Location: index.php");
        exit;
    } ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editare rețetă</title>
  <link rel="stylesheet" href="post.css">
</head>

 <?php if (isset($recipeDetails['UserID']) && isset($recipeDetails['CategoryID']) && isset ($recipeDetails['Title']) && isset($recipeDetails['Description'])): ?>
    
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
    <form method="POST">
      <label for="title">Titlu</label>
      <input type="text" id="title" name="title" placeholder="Introduceți titlul rețetei" required value = "<?= htmlspecialchars($recipeDetails['Title'])?>">
      
      <label for="content">Conținut</label>
      <textarea id="content" name="content" placeholder="Introduceți conținutul rețetei" rows="20" required><?= htmlspecialchars($recipeDetails['Description'])?> </textarea>

      <label for="category">Alege categoria</label>
      <select name= "category" id= "category">
        <?php foreach ($categories as $category): ?> 
        <option value="<?=$category?>"><?=$category?></option>
        <?php endforeach; ?>
        </select>
      <button type="submit" class="submitbutton">Editează</button>
    </form>
  </div>
</main>
</body>

<?php else: ?>
    <p>Postarea nu a fost găsită.</p>
    <a href="index.php">Înapoi la lista postărilor</a>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE recipes SET Title = '".$_POST['title']."', Description = '".$_POST['content']."', CategoryID = (SELECT CategoryID FROM categories WHERE CategoryName = '".$_POST['category']."') WHERE RecipeID =".$id;
    mysqli_query($conn, $sql);
    header("Location: recipe.php?id=".$id);
} ?>