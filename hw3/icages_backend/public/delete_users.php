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
<input id="delete-id" name="delete-id" placeholder="userid" type="text" onkeyup="autoFill()" />
<label>UserName :</label>
<input id="delete-username" name="delete-username" placeholder="username" type="text" disabled />
<label>Password :</label>
<input id="delete-password" name="delete-password"  type="text" disabled />
<label>Usertype :</label>
<select id="delete-usertype" name="delete-usertype" disabled >
<option value="admin" >Admin</option>
<option value="manager">Manager</option>
<option value="sales">Sales</option>
</select>
<label>Firstname :</label>
<input id="delete-firstname" name="delete-firstname" placeholder="firstname" type="text" disabled />
<label>Lastname :</label>
<input id="delete-lastname" name="delete-lastname" placeholder="lastname" type="text" disabled />
<label>Age :</label>
<input id="delete-age" name="delete-age" placeholder="age" type="number" disabled />
<label>Salary :</label>
<input id="delete-salary" name="delete-salary" placeholder="salary" type="number" disabled />
<input name="delete-submit" type="submit" value=" Delete " />
</form>
</ul>
</div>
<ul>
<li><a href="admin.php">Back to admin page</a></li>
<ul>
</div>

<?php
    $error=''; // Error Message
    if (isset($_POST['delete-submit'])) {
        // $username and $password
        $userid = $_POST['delete-id'];
        $username = $_POST['delete-username'];
        $userid = stripslashes($userid);
        $username = stripslashes($username);
        $userid = mysql_real_escape_string($userid);
        $username = mysql_real_escape_string($username);
        // Selecting Database
        $query  = "DELETE FROM Users ";
        $query .= "WHERE userid='" . $userid . "' ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "Delete User $username Successfully!";
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
    id = document.getElementById("delete-id").value;
    if (id.length == 0) {
        document.getElementById("delete-username").value = "";
        document.getElementById("delete-password").value = "";
        document.getElementById("delete-usertype").value = "Admin";
        document.getElementById("delete-firstname").value = "";
        document.getElementById("delete-lastname").value = "";
        document.getElementById("delete-age").value = "";
        document.getElementById("delete-salary").value = "";
        return;
    } else {
        document.getElementById("delete-age").innerHTML = 50;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("delete-username").value = res[0];
                document.getElementById("delete-password").value = res[1];
                document.getElementById("delete-usertype").value = res[2];
                document.getElementById("delete-firstname").value = res[3];
                document.getElementById("delete-lastname").value = res[4];
                document.getElementById("delete-age").value = res[5];
                document.getElementById("delete-salary").value = res[6];
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


