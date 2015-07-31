<?php session_start(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
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
            <label>ProductID :</label>
            <input id="add-productid" name="add-productid" placeholder="productid" type="number" />
            </br>
            <label>StartDate :</label>
            <input id="add-startdate" name="add-startdate" placeholder="startdate" type="date" />
            </br>
            <label>EndDate :</label>
            <input id="add-enddate" name="add-enddate" placeholder="enddate" type="date" />
            </br>
            <label>PercentOff :</label>
            <input id="add-percentoff" name="add-percentoff" placeholder="percentoff" type="number" />
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
        if (empty($_POST['add-productid']) || empty($_POST['add-startdate'])) {
            $error = "ProductID or Start Date is invalid";
        }
        else
        {
            // $username and $password
            $productid=$_POST['add-productid'];
            $startdate=$_POST['add-startdate'];
            $enddate=$_POST['add-enddate'];
            $percentoff=$_POST['add-percentoff'];
            $productid = stripslashes($productid);
            $startdate = stripslashes($startdate);
            $enddate = stripslashes($enddate);
            $percentoff = stripslashes($percentoff);

            $productid = mysql_real_escape_string($productid);
            $startdate = mysql_real_escape_string($startdate);
            $enddate = mysql_real_escape_string($enddate);
            $percentoff = mysql_real_escape_string($percentoff);
            // Selecting Database
            $query  = "INSERT INTO SpecialSales (productid, startdate, enddate, percentoff) ";
            $query .= "VALUES ('". $productid . "', '" . $startdate . "','" . $enddate . "','" . $percentoff  . "') ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Insert SpecialSales for Product $productid Successfully!";
            } else {
                $error = "ProductID or Start Date is invalid";
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
