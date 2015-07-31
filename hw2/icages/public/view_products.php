<?php session_start();
    require_once("../includes/db_connection.php"); ?>
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
    <form action="" method="post">
        <label>Original Price Range (USD):</label>
        <select id="search-price" name="search-price" >
        <option value="0" >----</option>
        <option value="1" >Below 1,000</option>
        <option value="2">1,000-2,000</option>
        <option value="3">2,000-3,000</option>
        <option value="4">3,000-4,000</option>
        <option value="5">Above 4,000</option>
        </select>
        <label>Product Name :</label>
        <input id="search-productname" name="search-productname" placeholder="productname" type="text" />
        <label>Product Category :</label>
        <input id="search-productcategory" name="search-productcategory" placeholder="productcategory" type="number" />
        <input name="search-submit" type="submit" value=" Search " />
    </form>


<table style="width:100%"  border=1>
<td>product id</td>
<td>product category id</td>
<td>product name</td>
<td>product description </td>
<td>product price </td>
</tr>
        <?php
            $error=''; // Error Message
            if (isset($_POST['search-submit'])) {
                // $username and $password
                $price=$_POST['search-price'];
                $productname=$_POST['search-productname'];
                $productcategory=$_POST['search-productcategory'];
                
                $price = stripslashes($price);
                $productname = stripslashes($productname);
                $productcategory = stripslashes($productcategory);
                
                $price = mysql_real_escape_string($price);
                $productname = mysql_real_escape_string($productname);
                $productcategory = mysql_real_escape_string($productcategory);
                
                // select *  from Product where productprice <= 1000 ;
                
                if($price == "1"){
                    $price_query = " productprice <= 1000 ";
                }elseif($price == "2"){
                    $price_query = " productprice > 1000 and productprice <= 2000 ";
                }elseif($price == "3"){
                    $price_query = " productprice > 2000 and productprice <= 3000 ";
                }elseif($price == "4"){
                    $price_query = " productprice > 3000 and productprice <= 4000 ";
                }elseif($price == "5"){
                    $price_query = " productprice > 4000  ";
                }else{
                    $price_query = " ";
                    $price = "";
                }
                
                // Selecting Database
                if($price_query == " " && $productname == "" && $productcategory == ""  ){
                    $query = " SELECT *  from Product ; ";
                }else{
                    $query = " SELECT *  from Product WHERE ";
                    $non_empty = array();
                    $productname_query = " productname = '" . $productname . "' ";
                    $productcategory_query = " productcategoryid = '" . $productcategory . "' " ;
                    
                    $entities = array($price, $productname, $productcategory);
                    $queries = array($price_query, $productname_query, $productcategory_query);
                    for($x = 0; $x < 4; $x++){
                        if(!$entities[$x] == ""){
                            array_push($non_empty, $x);
                        }
                    }
                    
                    for($y = 0; $y < count($non_empty); $y++){
                        $query .= " AND " . $queries[$non_empty[$y]];
                        
                    }
                    $query .= " ; ";
                }
              
                $result = mysql_query($query, $connection);
                if ($result) {
                    $index = 0;
                    while($subject = mysql_fetch_assoc($result)) {
                        $index ++;
                        // | productid | productcategoryid | productname  | productdescription  | productprice |
                        ?>

<td><?php echo $subject["productid"]; ?></td>
<td> <?php echo $subject["productcategoryid"]; ?> </td>
<td><?php echo $subject["productname"]; ?></td>
<td> <?php echo $subject["productdescription"]; ?> </td>
<td><?php echo $subject["productprice"]; ?> </td>
</tr>
                        <?php
                            }
                            if($index == "0"){
                                $error = "No such product! Please Try Again!";
                            }
                } else {
                    $error = "No such product! Please Try Again!";
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

