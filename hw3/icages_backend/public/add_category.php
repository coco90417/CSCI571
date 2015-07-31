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
            <label>CateogryName :</label>
            <input id="add-categoryname" name="add-categoryname" placeholder="categoryname" type="text" />
            </br>
            <label>CategoryDescription :</label>
            <input id="add-description" name="add-description"  type="text" />
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
        if (empty($_POST['add-categoryname']) || empty($_POST['add-description'])) {
            $error = "ProductName or ProductDescriptionID is invalid";
        }
        else
        {
            // $username and $password
            $categoryname=$_POST['add-categoryname'];
            $description=$_POST['add-description'];
            $categoryname = stripslashes($categoryname);
            $description = stripslashes($description);
            $categoryname = mysql_real_escape_string($categoryname);
            $description = mysql_real_escape_string($description);
            // Selecting Database
            $query  = "INSERT INTO ProductCategory (productcategoryname, productdescription) ";
            $query .= "VALUES ('". $categoryname . "', '" . $description  ."' ) ;";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Update Product $categoryname Successfully!";
            } else {
                $error = "Please Try Again!";
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
