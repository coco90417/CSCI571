<?php session_start(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php");
    if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
        require("logout.php");
    }
    ?>
<!DOCTYPE html>
<html>
<head>
<title>iCAGES Corp</title>
<link href="stylesheets/custom.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>



<div id="main">
<div id="navigation">
<ul class="users">
<form action="" method="post">
<label>UserID :</label>
<input id="update-id" name="update-id" placeholder="userid" type="text" onkeyup="autoFill()" />
<label>UserName :</label>
<input id="update-username" name="update-username" placeholder="username" type="text" />
<label>Password :</label>
<input id="update-password" name="update-password"  type="text" />
<label>Usertype :</label>
<select id="update-usertype" name="update-usertype" >
<option value="admin" >Admin</option>
<option value="manager">Manager</option>
<option value="sales">Sales</option>
</select>
<label>Firstname :</label>
<input id="update-firstname" name="update-firstname" placeholder="firstname" type="text" />
<label>Lastname :</label>
<input id="update-lastname" name="update-lastname" placeholder="lastname" type="text" />
<label>Age :</label>
<input id="update-age" name="update-age" placeholder="age" type="number" />
<input name="update-submit" type="submit" value=" Submit " />
<label>Salary :</label>
<input id="update-salary" name="update-salary" placeholder="salary" type="number" />
<input name="update-submit" type="submit" value=" Submit " />
</form>
</ul>
</div>
<ul>
<li><a href="admin.php">Back to admin page</a></li>
<ul>
</div>

<?php
    $error=''; // Error Message
    if (isset($_POST['update-submit'])) {
            // $username and $password
            $userid = $_POST['update-id'];
            $username=$_POST['update-username'];
            $password=$_POST['update-password'];
            $usertype=$_POST['update-usertype'];
            $firstname=$_POST['update-firstname'];
            $lastname=$_POST['update-lastname'];
            $age = $_POST['update-age'];
        $salary = $_POST['update-salary'];
            $userid = stripslashes($userid);
            $username = stripslashes($username);
            $password = stripslashes($password);
            $usertype = stripslashes($usertype);
            $firstname = stripslashes($firstname);
            $lastname = stripslashes($lastname);
            $age = stripslashes($age);
         $salary = stripslashes($salary);
            $userid = stripslashes($userid);
            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);
            $usertype = mysql_real_escape_string($usertype);
            $firstname = mysql_real_escape_string($firstname);
            $lastname = mysql_real_escape_string($lastname);
            $age = mysql_real_escape_string($age);
         $salary = stripslashes($salary);
            // Selecting Database
            $query  = "UPDATE Users ";
            $query .= "SET username='" . $username . "',password='". $password . "', usertype='" . $usertype . "', firstname='". $firstname ."', lastname='" . $lastname . "', age='" . $age . "', salary='" . $salary . "' ";
             $query .= "WHERE userid='" . $userid . "' ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Update User $username Successfully!";
            } else {
                $error = "Please Try Again!";
            }
    }
    ?>
<span><?php echo $error; ?></span>
<div id="footer">Copyright &copy; 2015 iCAGES Corp</div>

</body>
<script>
function autoFill() {
    id = document.getElementById("update-id").value;
    if (id.length == 0) {
        document.getElementById("update-username").value = "";
        document.getElementById("update-password").value = "";
        document.getElementById("update-usertype").value = "Admin";
        document.getElementById("update-firstname").value = "";
        document.getElementById("update-lastname").value = "";
        document.getElementById("update-age").value = "";
        document.getElementById("update-salary").value = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("update-username").value = res[0];
                document.getElementById("update-password").value = res[1];
                document.getElementById("update-usertype").value = res[2];
                document.getElementById("update-firstname").value = res[3];
                document.getElementById("update-lastname").value = res[4];
                document.getElementById("update-age").value = res[5];
                document.getElementById("update-salary").value = res[6];
            }
        }
        xmlhttp.open("GET", "get_users.php?id=" + id, true);
        xmlhttp.send();
    }
}
</script>
</html>
<?php
    // Close database connection
    if (isset($connection)) {
        mysql_close($connection);
    }
    ?>

