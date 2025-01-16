<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $sql = "DELETE FROM categories WHERE CategoryName = '".$category."'";
    mysqli_query($conn, $sql);
    header("Location: admin.php");
}

