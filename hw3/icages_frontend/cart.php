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
    if(isset($_SESSION['customerid'])){
        $id=$_SESSION['customerid'];
    }else{
        $id="NA";
        header("location:login.php");
    };
    date_default_timezone_set('America/Los_Angeles');
    $today = date("Y-m-d");
    
    $update_msg="";
    if(isset($_POST['check-out'])){
        $confirm_query = " select * from Customers where customerid='" . $_SESSION['customerid'] . "' ; ";
        $confirm_result = mysql_query($confirm_query, $connection);
        if($confirm_result){
            $confirm_subject = mysql_fetch_assoc($confirm_result);
            if($confirm_subject['billadress'] == "NULL" || $confirm_subject['shipaddress'] == "NULL" || !(preg_match("/\d{16}/", $confirm_subject['creditcard']))  || !(preg_match("/\d{3}/", $confirm_subject['security'])) || $confirm_subject['expirationdate'] == "NULL" ){
                $_SESSION['check_out'] = "yes";
                header("location:user.php");
            }else{
                $update_orders =  " update Orders SET paid='yes' WHERE orderid='". $_SESSION['orderid'] . "' ; ";
                $update_result = mysql_query($update_orders, $connection);
                if($update_result){
                    $update_msg = "Thank you for your purchase! A confirmation email will be soon send to you! ";
                }
                
                // multiple recipients
                $to  = $_SESSION['username'] ;
                
                // subject
                $subject = 'Confirmation Order From iCAGES on ' . $today  ;
                
                $query_order = "select * from Orders where orderid='" . $_SESSION['orderid'] . "' ; ";
                $query_result = mysql_query($query_order, $connection);
                
                if ($query_result) {
                    while($subject_query = mysql_fetch_assoc($query_result)) {
                        $orderdate = $subject_query['orderdate'];
                        $ordertotal = $subject_query['ordertotal'];
                    }
                };
                
                $orderitems_arr = array();
                $count_arr = array();
                
                $items_query = " select * from OrderItems as oi, Product as p where oi.orderid='" . $_SESSION['orderid'] .  "' and p.productid=oi.productid ; ";
                $query_result = mysql_query($items_query, $connection);
                
                if ($query_result) {
                    while($subject_query = mysql_fetch_assoc($query_result)) {
                        array_push($orderitems_arr, $subject_query['productname']) ;
                        array_push($count_arr, $subject_query['count']) ;
                    }
                };
                
                
                // message
                $message = '
                <html>
                <head>
                <title>Thank you for your purchase</title>
                    </head>
                    <body>
                    <h3>Summary of your order</h3>
                    <p>You have ordered in total ' . $ordertotal . ' dollars of items on ' . $orderdate. '</p>
                <p>Your orders are confirmed and will be shipped to you to your address tomorrow morning. </p>
                </body>
                </html>
                ';
                
                // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                
                // Mail it
                mail($to, $subject, $message, $headers);
                $customerid =  $_SESSION['customerid'];
                session_destroy();
                session_start();
                $_SESSION['customerid'] = $customerid;
                header("location:checkout_success.php");
                
            }
            
        }
        
    }

    
    
    ?>


<?php
    
    if(!isset($_SESSION['orderid']) || $_SESSION['orderid'] == ""){
        $query = "SELECT * FROM Orders ";
        $query .= "WHERE orderdate='" . $today . "' AND customerid='" . $_SESSION['customerid'] . "' AND paid IS NULL ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $subject = mysql_fetch_assoc($result);
            if(isset($subject['orderid'])){
                $_SESSION['orderid'] = $subject['orderid'];
            }else{
                unset($_SESSION['orderid']);
            }
        } else {
            unset($_SESSION['orderid']);
        };
    }
    ?>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
<link rel="stylesheet" type="text/css" href="stylesheet/mystyle.css">
</head>
<div id="header">
<a href="home.php"><img src="img/logo.png" height="40"/></a>
<form action="" method="POST">
<input type="submit" name="dna" value="DNA Sequencing"/>
<input type="submit" name="rna" value="RNA Sequencing"/>
<input type="submit" name="chip" value="ChIP Sequencing"/>
<input type="submit" name="target" value="Targeted Sequencing"/>
<div style="float:right">
<input type="submit" name="logout" value="Log Out"/>
<input type="submit" name="profile" value="My Profile"/>
</div>
</form>
</div>

<br>


<div id="main">


<div id="please-login" style="color:red; font-weight:bold"></div>


<?php
    
    if(isset($_SESSION['orderid'] )){
        
    ?>

<table border="1" style="border-collapse: separate; border-spacing: 10px 20px; display:inline; ">
<tr>
<td>Price</td>
<td>Count</td>
<td>Name</td>
<td>Delete</td>

<?php } ?>

<?php
    $error=''; // Error Message
    if($_SESSION['type'] == "dna"){
        $productcategoryid = "1";
    }elseif($_SESSION['type'] == "rna"){
        $productcategoryid = "2";
    }elseif($_SESSION['type'] == "chip"){
        $productcategoryid = "3";
    }elseif($_SESSION['type'] == "target"){
        $productcategoryid = "4";
    }
    $specialsalesproductid = array();
    $query = " SELECT *  from Product as p, SpecialSales as s, OrderItems as oi, Orders as o WHERE o.orderid=oi.orderid AND o.paid IS NULL AND oi.productid=p.productid AND oi.orderid='" . $_SESSION['orderid']  . "' AND p.productid=s.productid ; ";
    // select * from SpecialSales as s, Product as p , OrderItems as oi WHERE oi.productid=p.productid  AND oi.orderid=1 AND p.productid=s.productid;
    $result = mysql_query($query, $connection);
    if ($result) {
            $index = 0;

            while($subject = mysql_fetch_assoc($result)) {
                $index ++;
                // specialsalesid | productid | startdate  | enddate    | percentoff | productid | productcategoryid | productname      | productdescription | productprice | orderitemsid | orderid | count | productid |
?>


<?php $productid=$subject['productid'];  $count=$subject['count']; $orderprice= $subject["productprice"] * (1-$subject["percentoff"]/100); ?>

    <tr>
    <div class='one-product'  style='text-align: center'>
            <td width="400" style="text-align:center">
            <span style='text-decoration:line-through; color:gray'>$<?php echo $subject["productprice"]; ?></span><span style='color: red'>$<?php echo $subject["productprice"] * (1-$subject["percentoff"]/100) ; ?><br>You Will Save $<?php echo $subject["productprice"] * $subject["percentoff"]/100 ; ?> (<?php echo $subject["percentoff"] ; ?>%)</span></td>
            <td width="300" style="text-align:center">


<form id="add-cart-form" method="post" action="" >
<input type="number" id="add-cart" class="update-cart-number" name="add-cart" min="1" value="<?php echo $count; ?>" max="10000" onchange="updateProduct('<?php echo $productid;?>', '<?php echo $orderprice;?>', $(this))" style="width:40px"/>
<input type="hidden" id="productid-cart" name="productid-cart" value=<?php echo "'" . $subject['productid'] . "'" ;?> />
<input type="hidden" id="productprice-cart" name="productprice-cart" value=<?php echo "'" . $subject["productprice"] * (1-$subject["percentoff"]/100) . "'" ;?> />
<td width="400"><?php echo $subject["productname"]; ?></td>
<td width="400"> <input type="button" id="delete-product" name="delete-product" value="Delete" onclick="deleteProduct('<?php echo $productid;?>', '<?php echo $orderprice;?>', $(this))" /> </td>
            </div>
            </tr>
</form>
<?php
    array_push($specialsalesproductid, $subject["productid"]);
    }
    }
    
    ?>



<?php
    $query = " SELECT *  from Product as p, OrderItems as oi,  Orders as o WHERE o.orderid=oi.orderid AND o.paid IS NULL AND oi.productid=p.productid AND oi.orderid='" . $_SESSION['orderid']  . "' ; ";
    // select * from Product as p , OrderItems as oi WHERE oi.productid=p.productid  AND oi.orderid=1;
    $result = mysql_query($query, $connection);
    if ($result) {
        $index = 0;
        while($subject = mysql_fetch_assoc($result)) {
            if(!in_array( $subject["productid"], $specialsalesproductid)){
            $index ++;
            //  productid | productcategoryid | productname | productdescription | productprice | orderitemsid | orderid | count | productid |
            ?>

<?php $productid=$subject['productid'];  $count=$subject['count']; $orderprice= $subject["productprice"]; ?>
<tr>
<div class='one-product'  style='text-align: center'>
    
<td width="400" style="text-align:center">$<?php echo $subject["productprice"]; ?></td>
<td width="300" style="text-align:center">

<form id="add-cart-form" method="post" action="" >
<input type="number" id="add-cart" class="update-cart-number" name="add-cart" min="1" value="<?php echo $count; ?>" max="10000" onchange="updateProduct('<?php echo $productid;?>', '<?php echo $orderprice;?>', $(this))" style="width:40px"/>
<input type="hidden" id="productid-cart" name="productid-cart" value=<?php echo "'" . $subject['productid'] . "'" ;?> />
<input type="hidden" id="productprice-cart" name="productprice-cart" value=<?php echo "'" . $subject["productprice"] * (1-$subject["percentoff"]/100) . "'" ;?> />
<td width="400"><?php echo $subject["productname"]; ?></td>
<td width="400"> <input type="button" id="delete-product" name="delete-product" value="Delete" onclick="deleteProduct('<?php echo $productid;?>', '<?php echo $orderprice;?>', $(this))"  /> </td>
</form>
</div>
</tr>

<?php
    }
    }
    }
    ?>


<?php
    
    if(isset($_SESSION['orderid'] )){
        
        ?>


</table>


<br>
<form id="delete-form" method="post" action="" >
<input type="button" id="delete-all" name="delete-all" value="Delete All" onclick="deleteAll()" />
<div style="float:right">
<input type="submit" id="check-out" style="" name="check-out" value="Checkout" />
</div>
</td>
</form>

<?php }else{ ?>

<div style="color:red; font-weight:bold" >Please go shopping and fill me out:)</div>


<?php } ?>




<div style="color:red; font-weight:bold; display:none;" id="myElem" >Successfully updated your order!</div>

<div style="color:red; font-weight:bold; display:none;" id="myDelElem" >Successfully cleared your cart!</div>
<div style="color:red; font-weight:bold"  ><?php echo $update_msg; ?></div>

</div>

<div id="similarProducts">
</div>
</body>

<script type="text/javascript">
function updateProduct( productid , orderprice, that)
{
    var count= that.parents('form:first').find('#add-cart-special').val();
    var whetherupdate= 'yes';
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open( "POST", "update_cart.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request_string = "productid=" + productid +  "&orderprice=" + orderprice + "&count=" + count + "&update=" + whetherupdate;
    xmlhttp.send(request_string);
}

function deleteProduct( productid , orderprice, that)
{
    var count= that.parents('form:first').find('#add-cart-special').val();
    var whetherdelete='yes';
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open( "POST", "update_cart.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request_string = "productid=" + productid +  "&orderprice=" + orderprice + "&delete=" + whetherdelete;
    xmlhttp.send(request_string);
    that.parent().parent().hide();
    $("#myElem").fadeIn('slow').delay(500).fadeOut('slow');

}

function deleteAll()
{
    var whetherdelete='all';
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open( "POST", "update_cart.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request_string = "delete=" + whetherdelete;
    xmlhttp.send(request_string);
    $("#myDelElem").fadeIn('slow').delay(500).fadeOut('slow');
    $("table").hide();
    $("#delete-form").hide();
}


</script>
</html>


