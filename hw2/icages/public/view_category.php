<?php require_once("../includes/db_connection.php"); ?>
<?php session_start();
    require_once("../includes/functions.php");
    if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
        require("logout.php");
    }
    ?>
<?php
	// Perform database query
	$query  = "SELECT * ";
	$query .= "FROM ProductCategory ;";
	$result = mysql_query( $query, $connection);
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
<table style="width:100%"  border=1>
<td>product category id</td>
<td>product categor yname</td>
<td>product category description</td>
</tr>
		<?php
			// Use returned data
            if($result){
			while($subject = mysql_fetch_assoc($result)) {
				// output data from each row
        ?>

<td><?php echo $subject["productcategoryid"]; ?></td>
<td> <?php echo $subject["productcategoryname"]; ?> </td>
<td><?php echo $subject["productdescription"]; ?></td>
</tr>
	  <?php
			}
          }
		?>
		</table>
  </div>
<ul>
<?php
    if($_SESSION['usertype'] === "manager" ){
       ?> <li><a href="manager.php">Back to manager page</a></li>
<?php    }elseif($_SESSION['usertype'] == "sales"){
        ?><li><a href="sales.php">Back to sales page</a></li>
<?php    }
    ?>
<ul>
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
