<?php
    include 'connection.php';

    $select_sql = "SELECT * FROM user";
    $result = $conn -> query ($select_sql);
    // var_dump($result);

    $message = "";

    if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['uname'];
        $password = $_POST['pword'];
    
        $login = "SELECT * FROM user WHERE username = '$username'";
        $result = $conn -> query ($login);
    
        if ($result -> num_rows > 0) {
            $row = $result -> fetch_assoc();
    
            if ($row['password'] == $password) {
                header("Location: welcome.php");
                exit();
            } else {
                $message = "Username and Password do not match. Please try again!";
            }
        } else {
            $message = "Username and Password do not match. Please try again!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/login.css">
        <title>Login</title>
    </head>
    <body>
        <div class="login">
            <form METHOD='POST'>
                <h4>Welcome! Please log in to continue.</h4>
                
                <input type="text" name="uname" placeholder="Username" required><br>
                <input type="password" name="pword" placeholder="Password" required><br>

                <?php if ($message != ""): ?>
                    <p style="color: red;"><?= $message ?></p>
                <?php endif; ?>

                <button type="submit" name="login">Log in </button>
                
                <p class="last">Don't have an account? <a href="register.php">Sign up</a></p>
            
            </form> 
        </div>
    </body>
</html>