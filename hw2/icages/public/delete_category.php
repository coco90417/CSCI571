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
<label>CategoryID :</label>
<input id="delete-id" name="delete-id" placeholder="categoryid" type="text" onkeyup="autoFill()" />
</br>
<label>CateogryName :</label>
<input id="delete-categoryname" name="delete-categoryname" placeholder="categoryname" type="text" disabled />
</br>
<label>CategoryDescription :</label>
<input id="delete-description" name="delete-description"  type="text" disabled />
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
        $categoryid = $_POST['delete-id'];
        $categoryname=$_POST['delete-categoryname'];
        $categoryid = stripslashes($categoryid);
        $categoryname = stripslashes($categoryname);
        $categoryid = mysql_real_escape_string($categoryid);
        $categoryname = mysql_real_escape_string($categoryname);
     
        // Selecting Database
        $query  = "DELETE FROM ProductCategory ";
        $query .= "WHERE productcategoryid='" . $categoryid . "' ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "delete Product $categoryname Successfully!";
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
        document.getElementById("delete-categoryname").value = "";
        document.getElementById("delete-description").value = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                var res = response.split(" ");
                document.getElementById("delete-categoryname").value = res[0];
                document.getElementById("delete-description").value = res[1];
            }
        }
        xmlhttp.open("GET", "get_category.php?id=" + id, true);
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


