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

<?php
    if(isset($_SESSION['customerid'])){
        $id=$_SESSION['customerid'];
    }else{
        $id="NA";
    };
    ?>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
<link rel="stylesheet" type="text/css" href="stylesheet/mystyle.css">
</head>
<body onload="checkLogin('<?php echo $id;?>')">
<div id="header">
<a href="home.php"><img src="img/logo.png" height="40"/></a>
<form action="" method="POST">
<input type="submit" name="dna" value="DNA Sequencing"/>
<input type="submit" name="rna" value="RNA Sequencing"/>
<input type="submit" name="chip" value="ChIP Sequencing"/>
<input type="submit" name="target" value="Targeted Sequencing"/>
<div style="float:right">
<?php
    if(!isset($_SESSION['customerid'])){
    ?>
<input type="submit" name="login" value="Log In"/>
<?php }else{
    ?>
<input type="submit" name="logout" value="Log Out"/>

<input type="submit" name="profile" value="My Profile"/>
<input type="submit" name="cart" value="My Cart"/>
<?php
    }
    ?>

</div>
</form>
</div>

<br>


<div id="main">


<div id="please-login" style="color:red; font-weight:bold"></div>


<table border="1" style="border-collapse: separate; border-spacing: 10px 20px; display:inline; ">
<tr>
<td>Price</td>
<td>Order</td>
<td>Name</td>
<td>Description</td>

<?php
    $error=''; // Error Message
    date_default_timezone_set('America/Los_Angeles');
    $today = date("Y-m-d");
    $_SESSION['today'] = $today;
    $query = " SELECT *  from Product as p, SpecialSales as s WHERE p.productid = s.productid AND s.startdate <= '" . $today . "' AND s.enddate >= '" . $today . "' ; ";
    $result = mysql_query($query, $connection);
    if ($result) {
        $index = 0;
        while($subject = mysql_fetch_assoc($result)) {
            $index ++;
            // | productid | productcategoryid | productname  | productdescription  | productprice | specialsalesid | productid | startdate  | enddate    | percentoff |
            ?>
<tr>
<div style='text-align: center'>
<td width="300" style="text-align:center">
<span style='text-decoration:line-through; color:gray'>$<?php echo $subject["productprice"]; ?></span><span style='color: red'>$<?php echo $subject["productprice"] * (1-$subject["percentoff"]/100) ; ?><br>You Will Save $<?php echo $subject["productprice"] * $subject["percentoff"]/100 ; ?> (<?php echo $subject["percentoff"] ; ?>%)</span></td>
<td width="300" style="text-align:center">
<form id="add-cart-form" method="post" action="" >

<input type="number" id="add-cart-special" name="add-cart-special" min="1" value="1" max="10000" style="width:40px"/>
<input type="hidden" id="productid-cart-special" name="productid-cart-special" value=<?php echo "'" . $subject['productid'] . "'" ;?> />
<input type="hidden" id="productprice-cart-special" name="productprice-cart-special" value=<?php echo "'" . $subject["productprice"] * (1-$subject["percentoff"]/100) . "'" ;?> />

<?php $productid=$subject['productid'];  $count=$subject['count']; $orderprice= $subject["productprice"] * (1-$subject["percentoff"]/100); ?>

<input type="submit" id="button-cart-special" name="button-cart-special-name" class="button-cart-special" onclick="addProduct('<?php echo $productid;?>', '<?php echo $orderprice;?>', $(this))" value="Add to My Cart" disabled/></td>
</form>
<td width="400"><?php echo $subject["productname"]; ?></td>
<td width="600"> <?php echo $subject["productdescription"]; ?> </td>
</div>
</tr>

<?php
    }
    }
    if($index == "0"){
        $error = "No Special Sales Today";
    }
    ?>


</table>


<br>

<div style="color:red; font-weight:bold; display:none;" id="myElem" >Successfully updated orderitems!</div>
</div>

<div id="similarProducts">
</div>
</body>

<script type="text/javascript">
function checkLogin(id){
    var btns = document.getElementsByName("button-cart-special-name");
    if(id == "NA"){
        document.getElementById("please-login").innerHTML = "Please login to shop!";
    };
    for(var i = 0; i < btns.length; i++){
        if(id == "NA"){
            if(!btns[i].hasAttribute("disabled")){
                btns[i].addAttribute("disabled");
            };
        }else{
            if(btns[i].hasAttribute("disabled")){
                btns[i].removeAttribute("disabled");
            };
        };
    }
};
$(document).ready(function(event){
                  $(".button-cart-special").click( function(event){
                                                  event.preventDefault();
                                                  $("#myElem").fadeIn('slow').delay(1000).fadeOut('slow');
                                                  });
                  });
function addProduct( productid , orderprice, that)
{
    var count= that.parents('form:first').find('#add-cart-special').val();
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open( "POST", "update_cart.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request_string = "productid=" + productid +  "&orderprice=" + orderprice + "&count=" + count;
    xmlhttp.send(request_string);
}
</script>

</html>




