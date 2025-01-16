<?php
require "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $sql = "DELETE FROM users WHERE Username = '".$username."'";
    mysqli_query($conn, $sql);
    header("Location: admin.php");
}