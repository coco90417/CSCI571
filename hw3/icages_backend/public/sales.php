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
        <h2>Sales Menu</h2>
        <p>Welcome to the sales area.</p>
        <ul>
        <h3>Product Management</h3>
        <li><a href="view_products.php">View Products</a></li>
        <li><a href="add_products.php">Add Products</a></li>
        <li><a href="update_products.php">Update Products</a></li>
        <li><a href="delete_products.php">Delete Products</a></li>
        <h3>Product Category Management</h3>
        <li><a href="view_category.php">View Category</a></li>
        <li><a href="add_category.php">Add Category</a></li>
        <li><a href="update_category.php">Update Category</a></li>
        <li><a href="delete_category.php">Delete Category</a></li>
        <h3>Special Sales Management</h3>
        <li><a href="view_sales.php">View SpecialSales</a></li>
        <li><a href="add_sales.php">Add SpecialSales</a></li>
        <li><a href="update_sales.php">Update SpecialSales</a></li>
        <li><a href="delete_sales.php">Delete SpecialSales</a></li>
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

