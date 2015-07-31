<?php session_start();
    if (isset($_POST['login'])){
        if(isset($_SESSION['customerid'])){
            header("location:user.php");
        }else{
            header("location:login.php");
        };
    }elseif(isset($_POST['cart'])){
        header("location:cart.php");
    }elseif(isset($_POST['dna']) || isset($_POST['rna']) || isset($_POST['chip']) || isset($_POST['target'])){
        if (isset($_POST['dna'])) {
            $_SESSION['type'] = "dna";
        } elseif(isset($_POST['rna'])){
            $_SESSION['type'] = "rna";
        }elseif(isset($_POST['chip'])){
            $_SESSION['type'] = "chip";
        }elseif(isset($_POST['target'])){
            $_SESSION['type'] = "target";
        }
        header("location:galary.php");
    }elseif(isset($_POST['logout'])){
        require("logout.php");
    }elseif(isset($_POST['profile'])){
        header("location:user.php");
    };
    require_once("../icages_backend/includes/db_connection.php");
    if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
        require("logout.php");
    };
?>


<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
<link rel="stylesheet" type="text/css" href="stylesheet/mystyle.css">
</head>
<div id="header">
<a href="home.php"><img src="img/logo.png" height="40"/></a>
</div>
<div style="display:inline-block">
<form action="" method="POST">
<input type="submit" name="logout" value="Log Out"/>
</form>
</div>
<div style="float:right;display:inline-block">
<button class="filter">Filter Summary</button>
</div>

<br>


<div class="filter" style="width:500px; margin:0 auto;  display:none">
<fieldset style="width:500px">
<legend>Filter Summary</legend>
<form method="POST">
Sold from<br>
<input type="date" id="filter-from" name="filter-from" size="60" maxlength="60" /><br><br>
To:<br>
<input type="date" id="filter-to" name="filter-to" size="60"  maxlength="60" /><br><br>
<?php
    $query  = "SELECT DISTINCT productcategoryid, productcategoryname  ";
    $query .= "FROM ProductCategory ;";
    $result = mysql_query( $query, $connection);
    if($result){
        ?>
Product Category:<br>
<select id="product-category" name="product-category">
<option value="">----</option>
<?php
        while($subject = mysql_fetch_assoc($result)) {
        ?>
<option value="<?php echo $subject['productcategoryid'];?>" ><?php echo $subject['productcategoryname'];?> </option>
<?php
    }
    ?>
</select><br><br>
<?php
    }
    ?>


<?php
    $query  = "SELECT DISTINCT p.productid, p.productname from SpecialSales as s, Product as p where s.productid=p.productid; ";
    $result = mysql_query( $query, $connection);
    if($result){
    
    ?>
Special Sales Items:<br>
<select id="special-sales" name="special-sales">
<option value="">----</option>
<?php
    while($subject = mysql_fetch_assoc($result)) {
        
    ?>
<option value="<?php echo $subject['productid'];?>" ><?php echo $subject['productname'];?> </option>
<?php
    }
    
    ?>
</select><br><br>
<?php
    }
    ?>

<?php
    $query  = "SELECT DISTINCT productid, productname from Product ; ";
    $result = mysql_query( $query, $connection);
    if($result){
        ?>
Product Name:<br>
<select id="product-name" name="product-name">
<option value="">----</option>
<?php
    while($subject = mysql_fetch_assoc($result)) {
        ?>
<option value="<?php echo $subject['productid'];?>" ><?php echo $subject['productname'];?> </option>
<?php
    }
    ?>
</select><br><br>
<?php
    }
    ?>

Sort By:<br>
Total Quantity:<input type="radio" id="rb1" name="sort" value="1" checked /><br>
Total Sales:<input type="radio" id="rb2" name="sort" value="2"/><br>
<br><br>

<input type="submit" name="filter-submit"  value="Update"/>
</form>
</fieldset>
<br>

</div>



<div id="main">


<div id="please-login" style="color:red; font-weight:bold"></div>




<?php
    $error=''; // Error Message
    if (isset($_POST['filter-submit'])) {
        // $username and $password
        $startdate=$_POST['filter-from'];
        $enddate=$_POST['filter-to'];
        $productcategory=$_POST['product-category'];
        $specialsales = $_POST['special-sales'];
        $productname = $_POST['product-name'];
        $sort = $_POST['sort'];
        
        
        // Selecting Database
        
        //
        //  select productname, sum(orderprice) as totalsale, sum(count) as totalquantity from (select p.productname as productname, ROUND(p.productprice*(1-s.percentoff/100), 0) as orderprice, o.orderdate  as orderdate, oi.count   as count from Orders as o, SpecialSales as s, OrderItems as oi, Product as p where p.productid=s.productid AND oi.orderid= o.orderid AND oi.productid = p.productid and o.paid='yes' union select p.productname, p.productprice as orderprice, o.orderdate  as orderdate, oi.count   as count from Orders as o, OrderItems as oi, Product as p where p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<=o.orderdate AND enddate>=o.orderdate ) AND oi.orderid= o.orderid AND oi.productid = p.productid and o.paid='yes' ) as unioned group by productname order by totalsale desc ;
        
        
        // special sales should be treated differently
       
    
        $query_one = "select productname, productid, sum(orderprice) as totalsale, productprice, sum(count) as totalquantity from (" ;
        
        $query_two = " select p.productname as productname, p.productid as productid, ROUND(p.productprice*(1-s.percentoff/100), 0) as orderprice, p.productprice as productprice, o.orderdate  as orderdate, oi.count  as count from Orders as o, SpecialSales as s, OrderItems as oi, Product as p where p.productid=s.productid AND oi.orderid= o.orderid AND oi.productid=p.productid and o.paid='yes' ";
        
        $query_three = "union ";
        
        $query_four = "select p.productname, p.productid as productid, p.productprice as orderprice, p.productprice as productprice, o.orderdate  as orderdate, oi.count   as count from Orders as o, OrderItems as oi, Product as p where p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<=o.orderdate AND enddate>=o.orderdate) AND oi.orderid= o.orderid AND oi.productid = p.productid and o.paid='yes' ";
        
        $query_five = ") as unioned group by productname ";
        $query_six = " ; ";
            
            $specialsales_query = " s.productid='" . $specialsales . "' ";
            $startdate_query = " o.orderdate >= '" . $startdate . "' ";
            $enddate_query = " o.orderdate <='" . $enddate. "' ";
            $productcategory_query = " p.productcategoryid = '" . $productcategory . "' ";
            $productname_query = " p.productid='" . $productname . "' ";
            $non_empty = array();
            
            
            // order should be treated differently
            if($sort == "1"){
                $sort_query = " order by totalquantity desc ";
                $sort_subquery  = " order by count desc ";
            }else{
                $sort_query = " order by totalsale desc ";
                $sort_subquery  = " order by orderprice * count desc ";
            }
            
            $entities = array($startdate, $enddate, $productcategory, $productname);
            $queries = array($startdate_query, $enddate_query, $productcategory_query, $productname_query );
            for($x = 0; $x < 4; $x++){
                if(!$entities[$x] == ""){
                    array_push($non_empty, $x);
                }
            }
            
            $intermediate_query = "";
            for($y = 0; $y < count($non_empty); $y++){
                $intermediate_query .= " AND " . $queries[$non_empty[$y]];
                
            }
            
            if($specialsales == ""){
                $query = $query_one . $query_two .  $intermediate_query . $query_three . $query_four . $intermediate_query . $query_five . $sort_query  . $query_six ;
            }else{
                $query = $query_one . $query_two . $intermediate_query . " AND " . $specialsales_query . $query_five . $sort_query . $query_six;
                
            }
        

        
        $result = mysql_query($query, $connection);
        if ($result) {
            
        ?>

<table border="1" style="border-collapse: separate; border-spacing: 10px 20px; display:inline; ">

<?php
            $index = 0;
            while($subject = mysql_fetch_assoc($result)) {
                $index ++;
                //  special sales:
                // select p.productname as productname,  ROUND(p.productprice*(1-s.percentoff/100), 0) as orderprice, o.orderdate  as orderdate, oi.count   as count from Orders as o, SpecialSales as s, OrderItems as oi, Product as p where p.productid=s.productid AND oi.orderid= o.orderid AND oi.productid = p.productid and o.paid='yes'  AND  p.productid= '1' ;
                // non special sales;
                // select p.productname, p.productprice as orderprice, o.orderdate  as orderdate, oi.count   as count from Orders as o, OrderItems as oi, Product as p where p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<=o.orderdate AND enddate>=o.orderdate ) AND oi.orderid= o.orderid AND oi.productid = p.productid and o.paid='yes'  AND  p.productid= '1'  ;
                ?>
<tr class="order-main">
<td  width="400" style="text-align:center">Total Sales: $<?php echo $subject["totalsale"]; ?></td>
<td  width="400" style="text-align:center">Product Name: <?php echo $subject["productname"]; ?> </td>
<td  width="400" style="text-align:center">Total Quantity: <?php echo $subject["totalquantity"]; ?> </td>
<td  width="400" style="text-align:center"><button class="order-details">Details</button></td>
</tr>

<tr class="sub" style="display:none">
<td width="400" style="text-align:center">Order Price</td>
<td width="400" style="text-align:center">Order Quantity</td>
<td width="400" style="text-align:center">Order Date</td>
</tr>

<?php
    
    // special sales
    $special_query = $query_two . $intermediate_query .  " AND p.productid='" . $subject['productid'] . "'" .  $sort_subquery . $query_six;
    $special_result = mysql_query($special_query, $connection);
    
    if ($special_result) {
        while($special_subject = mysql_fetch_assoc($special_result)) {
            
?>

<tr class="sub" style="display:none">
<td width="400" style="text-align:center"><span style='text-decoration:line-through; color:gray'>$<?php echo $subject["productprice"]; ?></span><span style='color: red'>$<?php echo $special_subject["orderprice"] ; ?></span></td>
<td width="400" style="text-align:center"><?php echo $special_subject["count"] ; ?></td>
<td width="400" style="text-align:center"><?php echo $special_subject["orderdate"] ; ?></td>
</tr>

<?php
        }
    }
    
    // non special sales
    $nonspecial_query = $query_four . $intermediate_query .  " AND p.productid='" . $subject['productid'] . "'" .  $sort_subquery . $query_six;
    $nonspecial_result = mysql_query($nonspecial_query, $connection);
    if ($nonspecial_result) {
        while($nonspecial_subject = mysql_fetch_assoc($nonspecial_result)) {

    
        
        ?>

<tr class="sub" style="display:none">
<td width="300" style="text-align:center">$<?php echo $subject["productprice"] ; ?></td>
<td width="300" style="text-align:center"><?php echo $nonspecial_subject["count"] ; ?></td>
<td width="300" style="text-align:center"><?php echo $nonspecial_subject["orderdate"] ; ?></td>
</tr>


        <?php
            }
            }
            }
    ?>

</table>

<?php
    
    if($index == "0"){
        $error = "No such ordered item! Please Try Again!";
    }
    } else {
        $error = "No such ordered item! Please Try Again!";
    }
    }
    ?>





<br>

<div style="color:red; font-weight:bold"  ><?php echo $error ; ?></div>



</div>

</body>

<script type="text/javascript">
$(document).ready(function(){
                  $("button.filter").click(function(){
                                           $("div.filter").toggle();
                                           });
                  });
$(document).ready(function(){
                  $("button.order-details").click(function(){
                                    $(this).closest("tr").nextUntil("tr.order-main").toggle();
                                    });
                  });
</script>
</html>


