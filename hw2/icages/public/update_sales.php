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
        <input id="update-id" name="update-id" placeholder="specialsalesid" type="text" onkeyup="autoFill()" />
        </br>
        <label>ProductID :</label>
        <input id="update-productid" name="update-productid" placeholder="productid" type="number" />
        </br>
        <label>StartDate :</label>
        <input id="update-startdate" name="update-startdate" placeholder="startdate" type="date" />
        </br>
        <label>EndDate :</label>
        <input id="update-enddate" name="update-enddate" placeholder="enddate" type="date" />
        </br>
        <label>PercentOff :</label>
        <input id="update-percentoff" name="update-percentoff" placeholder="percentoff" type="number" />
        <input name="update-submit" type="submit" value=" Submit " />
    </form>
</ul>
</div>
<ul>
<li><a href="sales.php">Back to sales page</a></li>
<ul>
</div>

<?php
    $error=''; // Error Message
    if (isset($_POST['update-submit'])) {
            // $username and $password
            $id = $_POST['update-id'];
            $productid=$_POST['update-productid'];
            $startdate=$_POST['update-startdate'];
            $enddate=$_POST['update-enddate'];
            $percentoff=$_POST['update-percentoff'];
            $id = stripslashes($id);
            $productid = stripslashes($productid);
            $startdate = stripslashes($startdate);
            $enddate = stripslashes($enddate);
            $percentoff = stripslashes($percentoff);
        $id = mysql_real_escape_string($id);
        $productid = mysql_real_escape_string($productid);
        $startdate = mysql_real_escape_string($startdate);
        $enddate = mysql_real_escape_string($enddate);
        $percentoff = mysql_real_escape_string($percentoff);
            // Selecting Database
            $query  = "UPDATE SpecialSales ";
            $query .= "SET productid='" . $productid . "',startdate='". $startdate . "', enddate='" . $enddate . "', percentoff='" . $percentoff . "' ";
            $query .= "WHERE specialsalesid='" . $id . "' ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Update SpecialSales of Product with ID $productid Successfully!";
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
    id = document.getElementById("update-id").value;
    if (id.length == 0) {
        document.getElementById("update-productid").value = "";
        document.getElementById("update-startdate").value = "";
        document.getElementById("update-enddate").value = "";
        document.getElementById("update-percentoff").value = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("update-productid").value = res[0];
                document.getElementById("update-startdate").value = res[1];
                document.getElementById("update-enddate").value = res[2];
                document.getElementById("update-percentoff").value = res[3];
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

