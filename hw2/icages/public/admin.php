<?php
    session_start();
    require_once("../includes/functions.php");
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
    <div id="navigation-bar">

    </div>
    <div id="page">
        <h2>Admin Menu</h2>
        <p>Welcome to the admin area.</p>
        <ul>
            <h3>Management</h3>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="add_users.php">Add Users</a></li>
            <li><a href="update_users.php">Update Users</a></li>
            <li><a href="delete_users.php">Delete Users</a></li>
            <h3>Log Out</h3>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<div id="footer">Copyright &copy; 2015 iCAGES Corp</div>

</body>
</html>
<?php
    // Close database connection
    if (isset($connection)) {
        mysql_close($connection);
    }
    ?>

