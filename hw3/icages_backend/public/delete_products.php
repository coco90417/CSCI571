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
<label>ProductID :</label>
<input id="delete-id" name="delete-id" placeholder="productid" type="text" onkeyup="autoFill()" />
</br>
<label>ProductCategoryID :</label>
<input id="delete-category" name="delete-category" placeholder="productcategoryid" type="number" disabled />
</br>
<label>ProductName :</label>
<input id="delete-productname" name="delete-productname" placeholder="productname" type="text" disabled />
</br>
<label>ProductDescription :</label>
<input id="delete-description" name="delete-description"  type="text" disabled />
</br>
<label>ProductPrice :</label>
<input id="delete-price" name="delete-price" placeholder="price" type="number" disabled />
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
        $productid = $_POST['delete-id'];
        $productname=$_POST['delete-productname'];
        $productid = stripslashes($productid);
        $productname = stripslashes($productname);
        $productid = mysql_real_escape_string($productid);
        $productname = mysql_real_escape_string($productname);
        // Selecting Database
        $query  = "DELETE FROM Product ";
        $query .= "WHERE productid='" . $productid . "' ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "delete Product $productname Successfully!";
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
        document.getElementById("delete-category").value = "";
        document.getElementById("delete-productname").value = "";
        document.getElementById("delete-description").value = "";
        document.getElementById("delete-price").value = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("delete-category").value = res[0];
                document.getElementById("delete-productname").value = res[1];
                document.getElementById("delete-description").value = res[2];
                document.getElementById("delete-price").value = res[3];
            }
        }
        xmlhttp.open("GET", "get_products.php?id=" + id, true);
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

