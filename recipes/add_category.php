<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category-name'];
    $sql = "INSERT INTO categories (CategoryName) VALUES ('".$category."')";
    mysqli_query($conn, $sql);
    header("Location: admin.php");
}