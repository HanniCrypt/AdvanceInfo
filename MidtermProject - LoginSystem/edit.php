<?php
    include 'connection.php';
    session_start();

    $user_id;

    if (isset($_SESSION['edit_id'])) {
    
        $user_id = $_SESSION['edit_id'];
    
    } else {
    
        $user_id = "No ID received!";
    
    }

    $data = "SELECT * FROM user WHERE id = $user_id";
    $result = $conn -> query ($data);
    $row = "";

    if ($result->num_rows > 0) {

        $row = $result -> fetch_assoc();

    } else {
        
        echo "No data found";
    
    }

    $message = "";

    if (isset($_POST['newData']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $id = $_POST['id'];
        $newf = $_POST['fname'];
        $newl = $_POST['lname'];
        $newNum = $_POST['cnum'];
        $newUN = $_POST['uname'];
        $newPW = $_POST['pword'];

        if (strlen($newNum) != 11) {
            $message = "Invalid Contact Number! Contact number must be 11 digits long.";
        } else {
            
            $checkUsername = "SELECT * FROM user WHERE username = '$newUN' AND id != $id";
            $usernameResult = $conn -> query ($checkUsername);

            if ($usernameResult -> num_rows > 0) {
                $message = "Username already exists. Please choose a different username.";
            } else if ($newPW == $row['password']) {
                $message = "Please enter a new Password.";
            } else {
                $newUps = "UPDATE user 
                            SET first_name = '$newf', 
                                last_name = '$newl', 
                                contact_number = '$newNum', 
                                username = '$newUN', 
                                password = '$newPW' 
                            WHERE id = $id";

                if ($conn -> query ($newUps) == TRUE) {
            
                    header("location: welcome.php");
                    exit();
                }
            }
        }
    }
      
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/edit.css">
        <title>Edit User</title>
    </head>
    <body>

        <form method="POST">

            <div class="cancel">
                <a href='welcome.php'><img src="./img/cancel.png" alt="" title="Cancel"></a>
            </div>
            
            <h4>Keep your details up to date!</h4>

            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="fname" placeholder="First Name" value="<?= $row['first_name'] ?>"> <br>
            <input type="text" name="lname" placeholder="Last Name" value="<?= $row['last_name'] ?>"><br>
            <input type="number" name="cnum" placeholder="Contact Number" value="<?= $row['contact_number'] ?>"> <br>
            <input type="text" name="uname" placeholder="Username" value="<?= $row['username'] ?>"> <br>
            <input type="text" name="pword" placeholder="Password" value="<?= $row['password'] ?>"> <br>
            
            <?php if ($message != ""): ?>
                <p style="color: red;"><?= $message ?></p>
            <?php endif; ?>

            <button type="submit" name="newData">Submit</button>
        
        </form>
    </body>
</html>