<?php
require "db.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $id = intval($_GET['id']);
    $comment = $_POST['comment'];
    $sql = "SELECT UserID FROM users WHERE Username = '".$username."'";
    $result = mysqli_query($conn, $sql);
    $UserID = mysqli_fetch_column($result);
    sendComment($id, $UserID, $comment);
    header("Location: recipe.php?id=".$id);
}