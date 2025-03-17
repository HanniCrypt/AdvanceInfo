<?php

    include 'connection.php';
    $select_sql = "SELECT * FROM user";
    $result = $conn -> query ($select_sql);
    // var_dump($result);

    session_start();

    if (isset($_POST['newData']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $_SESSION['edit_id'] = $_POST['edit_id'];

        header("location: edit.php");
        exit();
    }

    if (isset($_POST['delete']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $id = $_POST['id'];
        $delete_sql = "DELETE FROM user WHERE id = $id";
        $conn -> query($delete_sql);

        header("location: welcome.php");
        exit();
    }
    
    
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/welcome.css">
        <title>List of Employees</title>
    </head>

    <body>
        <div class='head'>
            <h3>LIST OF EMPLOYEES:</h3>
            <div class="logout">
                <a href='login.php'><img src="./img/logout.png" alt="" title="Log out"></a>
            </div>
        </div>

        <table>
            <tr>

                <th class="o">ID</th>
                <th>FIRST NAME</th>
                <th>LAST NAME</th>
                <th>CONTACT NUMBER</th>
                <th>USERNAME</th>
                <th>PASSWORD</th>
                <th class="w">ACTION</th>

                <?php
                    if ($result -> num_rows > 0) {
                        while ($row = $result -> fetch_assoc()) {
                            echo "
                                <tr>
                                    <td>{$row['id']}</>
                                    <td>{$row['first_name']}</>
                                    <td>{$row['last_name']}</>
                                    <td>{$row['contact_number']}</>
                                    <td>{$row['username']}</>
                                    <td>{$row['password']}</>

                                    <td class='act'>
                                        <form method='POST'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button class='btn1' type='submit' name='delete'><img src='./img/delete.png' alt='' title='Delete'></button>
                                        </form>

                                        <form method='POST'>
                                            <input type='hidden' name='edit_id' value='{$row['id']}'>
                                            <button class='btn2' type='submit' name='newData'><img src='./img/edit.png' alt='' title='Edit'></button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    }
                ?>
            </tr>
        </table>
    </body>
</html>