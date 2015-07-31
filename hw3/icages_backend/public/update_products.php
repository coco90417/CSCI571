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
<input id="update-id" name="update-id" placeholder="productid" type="text" onkeyup="autoFill()" />
</br>
<label>ProductCategoryID :</label>
<input id="update-category" name="update-category" placeholder="productcategoryid" type="number" />
</br>
<label>ProductName :</label>
<input id="update-productname" name="update-productname" placeholder="productname" type="text" />
</br>
<label>ProductDescription :</label>
<input id="update-description" name="update-description"  type="text" />
</br>
<label>ProductPrice :</label>
<input id="update-price" name="update-price" placeholder="price" type="number" />
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
            $productid = $_POST['update-id'];
            $category=$_POST['update-category'];
            $productname=$_POST['update-productname'];
            $description=$_POST['update-description'];
            $price=$_POST['update-price'];
            $productid = stripslashes($productid);
            $category = stripslashes($category);
            $productname = stripslashes($productname);
            $description = stripslashes($description);
            $price = stripslashes($price);
        $productid = mysql_real_escape_string($productid);
        $category = mysql_real_escape_string($category);
        $productname = mysql_real_escape_string($productname);
        $description = mysql_real_escape_string($description);
        $price = mysql_real_escape_string($price);
            // Selecting Database
            $query  = "UPDATE Product ";
            $query .= "SET productcategoryid='" . $category . "',productname='". $productname . "', productdescription='" . $description . "', productprice='". $price ."' ";
             $query .= "WHERE productid='" . $productid . "' ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Update Product $productname Successfully!";
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
        document.getElementById("update-category").value = "";
        document.getElementById("update-productname").value = "";
        document.getElementById("update-description").value = "";
        document.getElementById("update-price").value = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("update-category").value = res[0];
                document.getElementById("update-productname").value = res[1];
                document.getElementById("update-description").value = res[2];
                document.getElementById("update-price").value = res[3];
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

