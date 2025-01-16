<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['vote'] == "upvote") {
        mysqli_query($conn, "UPDATE comments SET Upvotes = Upvotes + 1 WHERE CommentID = ".intval($_GET['commentID']));
        }
    else 
        mysqli_query($conn, "UPDATE comments SET Upvotes = Upvotes - 1 WHERE CommentID = ".intval($_GET['commentID']));
}
header("Location: recipe.php?id=".$_POST['id']);