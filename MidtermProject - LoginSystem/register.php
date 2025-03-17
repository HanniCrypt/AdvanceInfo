<?php
    include 'connection.php';

    $select_sql = "SELECT * FROM user";
    $result = $conn->query($select_sql);
    // var_dump($result);

    $message = "";

    if (isset($_POST['insert']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $contact = $_POST['cnum'];
        $username = $_POST['uname'];
        $password = $_POST['pword'];

        
        if (strlen($contact) != 11) {
            $message = "Invalid Contact Number! Contact number must be 11 digits long.";
        } else {
            $checkUsername = "SELECT * FROM user WHERE username = '$username'";
            $checkNum = "SELECT * FROM user WHERE contact_number = '$contact'";
            $usernameResult = $conn -> query ($checkUsername);
            $checkNum = $conn -> query ($checkNum);
    
            if ($usernameResult -> num_rows > 0) {
                $message = "Employee already exists! Please choose a different username.";
            } else if ($checkNum -> num_rows > 0) {
                $message = "Contact Number has been already used! Please choose a different contact number.";
            } else {
                $insert_sql = "INSERT INTO user (first_name, last_name, contact_number, username, password) 
                VALUES ('$firstname', '$lastname', '$contact', '$username', '$password')";
    
                if ($conn -> query ($insert_sql) == TRUE) {
                    $message = "New Record has been added!";
                    header("location: login.php");
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
        <link rel="stylesheet" href="./css/register.css">
        <title>Register</title>
    </head>
    <body>
    
        <form method="POST">
            
            <h4>REGISTER EMPLOYEE</h4>
            <p>Please ensure all fields are completed correctly before submitting the form.</p>

            <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname'] ?>" placeholder="First Name" required> <br>
            <input type="text" name="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname'] ?>" placeholder="Last Name" required> <br>
            <input type="number" name="cnum" value="<?php if(isset($_POST['cnum'])) echo $_POST['cnum'] ?>" placeholder="Contact Number" required> <br>
            <input type="text" name="uname" value="<?php if(isset($_POST['uname'])) echo $_POST['uname'] ?>" placeholder="Username" required> <br>
            <input type="password" name="pword" value="<?php if(isset($_POST['pword'])) echo $_POST['pword'] ?>" placeholder="Password" required> <br>
            
            <?php if ($message != ""): ?>
                <p style="color: red;"><?= $message ?></p>
            <?php endif; ?>

            <button type="submit" name="insert">Submit</button>
            <p class="last">Already have an account? <a href="login.php">Log in</a></p>
        </form>

    </body>
</html>