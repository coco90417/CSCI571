<?php
session_start();
?>
<?php require_once("../includes/db_connection.php"); ?>
<?php
    $error=''; // Error Message
    if (isset($_POST['submit'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = "Username or Password is invalid";
        }
        else
        {
            // $username and $password
            $username=$_POST['username'];
            $password=$_POST['password'];
            $username = stripslashes($username);
            $password = stripslashes($password);
            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);
            // Selecting Database
            $query  = "SELECT * ";
            $query .= "FROM Users ";
            $query .= "WHERE username = '" . $username . "' and password = '" .$password . "' " ;
            $query .= "LIMIT 1 ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $subject = mysql_fetch_assoc($result);
                $_SESSION['username']=$userna; // Initializing Session
                $_SESSION['usertype']=$subject["usertype"];
                $_SESSION['start'] = time();
                if($_SESSION['usertype'] === "admin" ){
                    header("location: admin.php");
                }elseif($_SESSION['usertype'] == "manager"){
                    header("location: manager.php");
                }elseif($_SESSION['usertype'] == "sales"){
                    header("location: sales.php");
                }

            } else {
                $error = "Username or Password is invalid";
            }
        }
    }
    ?>

