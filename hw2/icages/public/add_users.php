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
                <label>UserName :</label>
                <input id="add-username" name="add-username" placeholder="username" type="text" />
                <label>Password :</label>
                <input id="add-password" name="add-password" placeholder="****" type="password" />
                <label>Usertype :</label>
                <select id="add-usertype" name="add-usertype" >
                <option value="admin" >Admin</option>
                <option value="manager">Manager</option>
                <option value="sales">Sales</option>
                </select>
                <label>Firstname :</label>
                <input id="add-firstname" name="add-firstname" placeholder="firstname" type="text" />
                <label>Lastname :</label>
                <input id="add-lastname" name="add-lastname" placeholder="lastname" type="text" />
                <label>Age :</label>
                <input id="add-age" name="add-age" placeholder="age" type="number" />
                <label>Salary :</label>
                <input id="add-salary" name="add-salary" placeholder="salary" type="number" />
                <input name="add-submit" type="submit" value=" Submit " />
            </form>
        </ul>
  </div>
<ul>
<li><a href="admin.php">Back to admin page</a></li>
<ul>
</div>

<?php
    $error=''; // Error Message
    if (isset($_POST['add-submit'])) {
        if (empty($_POST['add-username']) || empty($_POST['add-password'])) {
            $error = "Username or Password is invalid";
        }
        else
        {
            // $username and $password
            $username=$_POST['add-username'];
            $password=$_POST['add-password'];
            $usertype=$_POST['add-usertype'];
            $firstname=$_POST['add-firstname'];
            $lastname=$_POST['add-lastname'];
            $age = $_POST['add-age'];
            $salary = $_POST['add-salary'];
            $username = stripslashes($username);
            $password = stripslashes($password);
            $usertype = stripslashes($usertype);
            $firstname = stripslashes($firstname);
            $lastname = stripslashes($lastname);
            $age = stripslashes($age);
            $salary = stripslashes($salary);
            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);
            $usertype = mysql_real_escape_string($usertype);
            $firstname = mysql_real_escape_string($firstname);
            $lastname = mysql_real_escape_string($lastname);
            $age = mysql_real_escape_string($age);
            // Selecting Database
            $query  = "INSERT INTO Users (username, password, usertype, firstname, lastname, age, salary) ";
            $query .= "VALUES ('". $username . "', '" . $password . "','" . $usertype . "','" . $firstname . "','" . $lastname . "','" . $age . "','" . $salary . "') ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Insert User $username Successfully!";
            } else {
                $error = "Username or Password is invalid";
            }
        }
    }
    ?>
<span><?php echo $error; ?></span>
<div id="footer">Copyright &copy; 2015 iCAGES Corp</div>

</body>
</html>
<?php
    // Close database connection
    if (isset($connection)) {
        mysql_close($connection);
    }
    ?>
