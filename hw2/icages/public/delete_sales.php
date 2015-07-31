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
<label>SpecialSalesID :</label>
<input id="delete-id" name="delete-id" placeholder="specialsalesid" type="text" onkeyup="autoFill()" />
</br>
<label>ProductID :</label>
<input id="delete-productid" name="delete-productid" placeholder="productid" type="number" disabled />
</br>
<label>StartDate :</label>
<input id="delete-startdate" name="delete-startdate" placeholder="startdate" type="date" disabled />
</br>
<label>EndDate :</label>
<input id="delete-enddate" name="delete-enddate" placeholder="enddate" type="date" disabled />
</br>
<label>PercentOff :</label>
<input id="delete-percentoff" name="delete-percentoff" placeholder="percentoff" type="number" disabled />
<input name="delete-submit" type="submit" value=" Submit " />
</form>
</ul>
</div>
<ul>
<li><a href="sales.php">Back to sales page</a></li>
<ul>
</div>

<?php
    $error=''; // Error Message
    if (isset($_POST['delete-submit'])) {
        // $username and $password
        $id = $_POST['delete-id'];
        $productid=$_POST['delete-productid'];

        $id = stripslashes($id);
        $productid = stripslashes($productid);

        $id = mysql_real_escape_string($id);
        $productid = mysql_real_escape_string($productid);

        // Selecting Database
        $query  = "DELETE FROM SpecialSales ";
        $query .= "WHERE specialsalesid='" . $id . "' ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "Delete SpecialSales of Product with ID $productid Successfully!";
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
        document.getElementById("delete-productid").value = "";
        document.getElementById("delete-startdate").value = "";
        document.getElementById("delete-enddate").value = "";
        document.getElementById("delete-percentoff").value = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("delete-productid").value = res[0];
                document.getElementById("delete-startdate").value = res[1];
                document.getElementById("delete-enddate").value = res[2];
                document.getElementById("delete-percentoff").value = res[3];
            }
        }
        xmlhttp.open("GET", "get_sales.php?id=" + id, true);
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

