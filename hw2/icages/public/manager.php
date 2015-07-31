<?php session_start();
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
        <h2>Manager Menu</h2>
        <p>Welcome to the manager area.</p>
        <ul>
            <h3>Management</h3>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="view_products.php">View Products</a></li>
            <li><a href="view_category.php">View Category</a></li>
            <li><a href="view_sales.php">View SpecialSales</a></li>
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
