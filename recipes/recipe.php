<?php
require "db.php";
session_start(); 
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); }
    $recipeDetails = getRecipeByID($id);
    $comments = getComments($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $recipeDetails['Title']?></title>
  <link rel="stylesheet" href="recipe.css">
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


 <?php if (isset($recipeDetails['UserID']) || isset($recipeDetails['CategoryID']) || isset($recipeDetails['Title']) || isset($recipeDetails['Description'])): ?>

    <div class="recipe">
    <h1><?= htmlspecialchars($recipeDetails['Title']) ?></h1>
    <p><small>Postată pe: <?= $recipeDetails['CreationDate'] ?> de către <?= getUserbyID($recipeDetails['UserID'])?></small></p>
    <h3>Categorie: <?= htmlspecialchars(getCategoryByID(($recipeDetails['CategoryID']))) ?></h3>
        <p><?= nl2br(htmlspecialchars($recipeDetails['Description'])) ?></p>
        
        <?php if ($_SESSION['admin'] == 1): ?>
            <form method= "POST">
            <Button type = "submit" name= "delete" value= "delete" class="button">Șterge această postare</button>
            </form>
        <?php endif; ?>

        <?php if ($_SESSION['username'] == getUserbyID($recipeDetails['UserID'])): ?>
            <a href="edit_recipe.php?id=<?= $id?>">
            <Button class="button">Editează această postare</button>
            </a> <br>
        <?php endif; ?>
        <form action = "comment.php?id=<?=$id?>" method = "POST">
            <textarea id = "comment" name = "comment" placeholder = "Comentati!"></textarea>
            <button class = "button">Posteaza comentariu</button>
        </form>
        <?php foreach ($comments as $comment): ?>
            <p><small><?= getUserbyID($comment['UserID']) ?></small></p>
            <p><?= $comment['Comment'] ?> (<?= $comment['Upvotes'] ?> Upvotes)<p>
            <form action = "vote.php?commentID=<?=$comment['CommentID']?>" method = "POST">
                <input type="hidden" name="id" value = <?=$id?>>
                <button class="button" type="submit" name="vote" value="upvote">Upvote</button>
                <button class="button" type="submit" name="vote" value="downvote">Downvote</button>
            </form>    
        <?php endforeach; ?>
        <a href="index.php">Înapoi la lista postărilor</a>

    <?php else: ?>
        <p>Postarea nu a fost găsită.</p>
        <a href="index.php">Înapoi la lista postărilor</a>
        </div>    
    <?php endif;
    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM recipes WHERE RecipeID =".$id;
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
