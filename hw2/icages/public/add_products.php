<?php session_start(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php");
    if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
    require("logout.php");
}?>
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
            <label>ProductCategoryID :</label>
            <input id="add-category" name="add-category" placeholder="productcategoryid" type="number" />
            </br>
            <label>ProductName :</label>
            <input id="add-productname" name="add-productname" placeholder="productname" type="text" />
            </br>
            <label>ProductDescription :</label>
            <input id="add-description" name="add-description"  type="text" />
            </br>
            <label>ProductPrice :</label>
            <input id="add-price" name="add-price" placeholder="price" type="number" />
            <input name="add-submit" type="submit" value=" Submit " />
            </form>
        </ul>
  </div>
<ul>
<li><a href="sales.php">Back to sales page</a></li>
<ul>
</div>

<?php
    $error=''; // Error Message
    if (isset($_POST['add-submit'])) {
        if (empty($_POST['add-productname']) || empty($_POST['add-category'])) {
            $error = "ProductName or ProductCategoryID is invalid";
        }
        else
        {
            // $username and $password
            $category=$_POST['add-category'];
            $productname=$_POST['add-productname'];
            $description=$_POST['add-description'];
            $price=$_POST['add-price'];
            $category = stripslashes($category);
            $productname = stripslashes($productname);
            $description = stripslashes($description);
            $price = stripslashes($price);
            $category = mysql_real_escape_string($category);
            $productname = mysql_real_escape_string($productname);
            $description = mysql_real_escape_string($description);
            $price = mysql_real_escape_string($price);
            // Selecting Database
            $query  = "INSERT INTO Product (productcategoryid, productname, productdescription, productprice) ";
            $query .= "VALUES ('". $category . "', '" . $productname . "','" . $description . "','" . $price  . "') ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Insert Product $productname Successfully!";
            } else {
                $error = "ProductName or ProductCategoryID is invalid";
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
