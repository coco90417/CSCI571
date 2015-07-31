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
        <label>Start Date :</label>
        <input id="search-startdate" name="search-startdate" placeholder="startdate" type="date" />
        <label>End Date :</label>
        <input id="search-enddate" name="search-enddate" placeholder="enddate" type="date" />

        <input name="search-submit" type="submit" value=" Search " />
    </form>


		<table style="width:100%"  border=1>
            <td>product id</td>
            <td>product category id</td>
            <td>product name</td>
            <td>product description </td>
            <td>product price </td>
            <td>special sales id</td>
            <td>start date</td>
            <td>end date</td>
            <td>percent off</td>
            </tr>
        <?php
            $error=''; // Error Message
            if (isset($_POST['search-submit'])) {
                // $username and $password
                $price=$_POST['search-price'];
                $productname=$_POST['search-productname'];
                $productcategory=$_POST['search-productcategory'];
                $startdate=$_POST['search-startdate'];
                $enddate=$_POST['search-enddate'];
                
                $price = stripslashes($price);
                $productname = stripslashes($productname);
                $productcategory = stripslashes($productcategory);
                $startdate = stripslashes($startdate);
                $enddate = stripslashes($enddate);

                $price = mysql_real_escape_string($price);
                $productname = mysql_real_escape_string($productname);
                $productcategory = mysql_real_escape_string($productcategory);
                $startdate = mysql_real_escape_string($startdate);
                $enddate = mysql_real_escape_string($enddate);
                
                // select *  from Product as p, SpecialSales as s where p.productprice <= 1000 and s.startdate > '12-12-2011' and p.productid = s.productid;
                
                if($price == "1"){
                    $price_query = " p.productprice <= 1000 ";
                }elseif($price == "2"){
                    $price_query = " p.productprice > 1000 and p.productprice <= 2000 ";
                }elseif($price == "3"){
                    $price_query = " p.productprice > 2000 and p.productprice <= 3000 ";
                }elseif($price == "4"){
                    $price_query = " p.productprice > 3000 and p.productprice <= 4000 ";
                }elseif($price == "5"){
                    $price_query = " p.productprice > 4000  ";
                }else{
                    $price_query = " ";
                    $price = "";
                }
                
                // Selecting Database
                if($price_query == " " && $productname == "" && $productcategory == ""  && $startdate==""  && $enddate=="" ){
                    $query = " SELECT *  from Product as p, SpecialSales as s WHERE p.productid = s.productid ; ";
                }else{
                    $query = " SELECT *  from Product as p, SpecialSales as s WHERE p.productid = s.productid ";
                    $non_empty = array();
                    $productname_query = " p.productname = '" . $productname . "' ";
                    $productcategory_query = " p.productcategoryid = '" . $productcategory . "' " ;
                    $startdate_query = " s.startdate > '" . $startdate . "' ";
                    $enddate_query = " s.enddate < '" . $enddate . "' ";
                    
                    $entities = array($price, $productname, $productcategory, $startdate, $enddate);
                    $queries = array($price_query, $productname_query, $productcategory_query, $startdate_query, $enddate_query);
                    for($x = 0; $x < 6; $x++){
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
                        // | productid | productcategoryid | productname  | productdescription  | productprice | specialsalesid | productid | startdate  | enddate    | percentoff |
                        ?>

                        <td><?php echo $subject["productid"]; ?></td>
                        <td> <?php echo $subject["productcategoryid"]; ?> </td>
                        <td><?php echo $subject["productname"]; ?></td>
                        <td> <?php echo $subject["productdescription"]; ?> </td>
                        <td><?php echo $subject["productprice"]; ?> </td>
                        <td><?php echo $subject["specialsalesid"]; ?> </td>
                        <td><?php echo $subject["startdate"] ; ?></td>
                        <td><?php echo $subject["enddate"] ; ?></td>
                        <td><?php echo $subject["percentoff"] ; ?></td>
                        </tr>

                        <?php
                            }
                            if($index == "0"){
                                $error = "No such sale! Please Try Again!";
                            }
                } else {
                    $error = "No such sale! Please Try Again!";
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

