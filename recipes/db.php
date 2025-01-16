<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'recipes';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function registration($username, $email, $password) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $sql = 'INSERT INTO users (Username, Email, Password) VALUES ("'.$username.'", "'.$email.'", "'.$password.'");';
    mysqli_query($conn, $sql);
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['admin'] = false;
}

function login($username, $password) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $sql = "SELECT Username, Password, Admin FROM users WHERE Username='".$username."'";
    $result = mysqli_query($conn, $sql);
    $credentials = mysqli_fetch_assoc($result);
    if ($password === $credentials['Password']) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['admin'] = $credentials['Admin'];
        return null;
    }
    else {
        $error = "Logare eșuată";
        return $error;
    }
}

function getCategories() {
    global $conn;
    $sql = "SELECT CategoryName FROM categories";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['CategoryName'];
    }
    return $categories;
}

function postRecipe($username, $category, $title, $content) {
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $content = mysqli_real_escape_string($conn, $content);
    $sql = "SELECT UserID FROM users WHERE Username ='".$username."'";
    $result = mysqli_query($conn, $sql);
    $UserID = mysqli_fetch_column($result, 0);

    $sql = "SELECT CategoryID FROM categories WHERE CategoryName = '".$category."'";
    $result = mysqli_query($conn, $sql);
    $CategoryID = mysqli_fetch_column($result, 0);

    $sql = "INSERT INTO recipes (UserID, CategoryID, Title, Description) VALUES (".$UserID.", ".$CategoryID.", '".$title."', '".$content."')";
    mysqli_query($conn, $sql);
}

function getRecipes() {
    global $conn;
    $sql = "SELECT RecipeID, Title FROM recipes";
    $result = mysqli_query($conn, $sql);
    $recipes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $recipe = [
            "RecipeID" => $row['RecipeID'],
            "Title" => $row['Title']
        ];
        $recipes[] = $recipe;
    }
    return $recipes;
}

function getUsers() {
    global $conn;
    $sql = "SELECT Username, Email FROM users";
    $result = mysqli_query($conn, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $user = [
            "Email" => $row['Email'],
            "Username" => $row['Username']
        ];
        $users[] = $user;
    }
    return $users;
}

function getRecipeByID($recipeID) {
    global $conn;
    $sql = "SELECT UserID, CategoryID, Title, Description, CreationDate FROM recipes WHERE RecipeID = ".$recipeID;
    $result = mysqli_query($conn, $sql);
    $recipeDetails = mysqli_fetch_assoc($result);
    return $recipeDetails;
}

function getUserbyID($userID) {
    global $conn;
    $sql = "SELECT Username FROM users WHERE UserID = ".$userID;
    $result = mysqli_query($conn, $sql);
    $User = mysqli_fetch_column($result, 0);
    return $User;
}

function getCategoryByID($categoryID) {
    global $conn;
    $sql = "SELECT Categoryname FROM categories WHERE CategoryID = ".$categoryID;
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_column($result, 0);
    return $category;
}

function sendComment($recipeID, $userID, $comment) {
    global $conn;
    $sql = "INSERT INTO comments (RecipeID, UserID, Comment) VALUES ('".$recipeID."', '".$userID."', '".$comment."')";
    $result = mysqli_query($conn, $sql);
}

function getComments($id) {
    global $conn;
    $sql = "SELECT CommentID, UserID, RecipeID, Comment, Upvotes FROM comments WHERE RecipeID = ".$id;
    $result = mysqli_query($conn, $sql);
    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comment = [
            'CommentID' => $row['CommentID'],
            'UserID' => $row['UserID'],
            'RecipeID' => $row['RecipeID'],
            'Comment' => $row['Comment'],
            'Upvotes' => $row['Upvotes']
        ];
        $comments[] = $comment;
    }
    return $comments;
}


?>
