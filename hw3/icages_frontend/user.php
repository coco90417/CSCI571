<?php session_start();
    if(!isset($_SESSION['customerid'])){
        header("location:login.php");
    }else{
        if(isset($_POST['cart'])){
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
        }elseif(isset($_POST['profile']) && isset($_SESSION['customerid'])){
        header("location:user.php");
        };
        require_once("../icages_backend/includes/db_connection.php");
        if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
        require("logout.php");
        };
    }
?>

<?php $id=$_SESSION['customerid'];
    $checkout_msg = "";
    if( $_SESSION['check_out'] == "yes"){
    
        $checkout_msg = "Please update your billing information for us to process checking out!";
    };
    
    
    ?>



<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
<link rel="stylesheet" type="text/css" href="stylesheet/mystyle.css">
</head>
<body onload="autoFill('<?php echo $id;?>')">
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
<input type="submit" name="cart" value="My Cart"/>
</div>
</form>

</div>

<br>


<div id="main">
<?php
$error=''; // Error Message
if (isset($_POST['update-submit'])) {
    // $username and $password
    $username=$_POST['update-email'];
    $password=$_POST['update-password'];
    $firstname=$_POST['update-firstname'];
    $lastname=$_POST['update-lastname'];
    $bill_street = $_POST['update-bill-street'];
    $bill_city = $_POST['update-bill-city'];
    $bill_state = $_POST['update-bill-state'];
    $bill_postcode = $_POST['update-bill-postcode'];
    $ship_street = $_POST['update-ship-street'];
    $ship_city = $_POST['update-ship-city'];
    $ship_state = $_POST['update-ship-state'];
    $ship_postcode = $_POST['update-ship-postcode'];
    
    $bill_street = str_replace( ",", " ", $bill_street);
    $bill_city= str_replace(",", " ", $bill_city);
    $bill_state= str_replace( ",", " ", $bill_state);
    $bill_postcode= str_replace( ",", " ", $bill_postcode);
    $ship_street = str_replace( ",", " ", $ship_street);
    $ship_city= str_replace( ",", " ", $ship_city);
    $ship_state= str_replace( ",", " ", $ship_state);
    $ship_postcode= str_replace( ",", " ", $ship_postcode);
    $card=$_POST['update-card'];
    $security=$_POST['update-security'];
    $expire=$_POST['update-expire'];
    
    $username = stripslashes($username);
    $password = stripslashes($password);
    $firstname = stripslashes($firstname);
    $lastname = stripslashes($lastname);
    $bill_street = stripslashes($bill_street);
    $bill_city = stripslashes($bill_city);
    $bill_state = stripslashes($bill_state);
    $bill_postcode = stripslashes($bill_postcode);
    $ship_street = stripslashes($ship_street);
    $ship_city = stripslashes($ship_city);
    $ship_state = stripslashes($ship_state);
    $ship_postcode = stripslashes($ship_postcode);
    $card = stripslashes($card);
    $security = stripslashes($security);
    $expire = stripslashes($expire);
    
    
    
    $bill = $bill_street . "," . $bill_city . "," . $bill_state . "," . $bill_postcode;
    $ship = $ship_street . "," . $ship_city . "," . $ship_state . "," . $ship_postcode;
    
    
    // Selecting Database
    $query  = "UPDATE Customers ";
    $query .= "SET username='" . $username . "', password='". $password .  "', firstname='". $firstname ."', lastname='" . $lastname . "', billaddress='" . $bill ."', shipaddress='" . $ship  ."', creditcard='" . $card  . "', security='" . $security .  "', expirationdate='" . $expire . "' " ;
    $query .= "WHERE customerid='" . $_SESSION['customerid'] . "' ; ";
    $result = mysql_query($query, $connection);
    if ($result) {
        $error = "Update Customer $username Successfully!";
        $checkout_msg="";
    } else {
        $error = "Please Try Again!";
    }
    if(!isset($_SESSION['customerid'])){
        $_SESSION['customerid'] = $id;
    }
}
?>


<div style="margin:0 auto; width:500px; z-index:1">
<fieldset style="display:inline-block; width:500px">
<legend>Update My Information</legend>
    <form method="POST">
    Email : <br>
    <input id="update-email" name="update-email" placeholder="email" type="email" size="60" required/><br>
    Password : <br>
    <input id="update-password" name="update-password" placeholder="password" type="password" size="60" required /><br>
    Firstname: <br>
    <input id="update-firstname" name="update-firstname" placeholder="firstname" maxlength="60" size="60" type="text" required/><br>
    Lastname :<br>
    <input id="update-lastname" name="update-lastname" placeholder="lastname" maxlength="60" size="60" type="text" required/><br>
    Billing Address :<br>
    <input id="update-bill-street" name="update-bill-street" placeholder="street" maxlength="60" size="60" type="text" required />
    <input id="update-bill-city" name="update-bill-city" placeholder="city" maxlength="60"  size="60" type="text" required />
    <input id="update-bill-state" name="update-bill-state" placeholder="state" maxlength="2" size="60" pattern="AL|AK|AR|AZ|CA|CO|CT|DC|DE|FL|GA|HI|IA|ID|IL|IN|KS|KY|LA|MA|MD|ME|MI|MN|MO|MS|MT|NC|ND|NE|NH|NJ|NM|NV|NY|OH|OK|OR|PA|RI|SC|SD|TN|TX|UT|VA|VT|WA|WI|WV|WY|al|ak|ar|az|ca|co|ct|dc|de|fl|ga|hi|ia|id|il|in|ks|ky|la|ma|md|me|mi|mn|mo|ms|mt|nc|nd|ne|nh|nj|nm|nv|ny|oh|ok|or|pa|ri|sc|sd|tn|tx|ut|va|vt|wa|wi|wv|wy" title="Two letter state code" type="text" required />
    <input id="update-bill-postcode" name="update-bill-postcode" placeholder="postcode" type="text" maxlength="5" pattern="[0-9]{5}" required title="Postcode" /><br>
    Shipping Address: <br>
    <input id="update-ship-street" name="update-ship-street" placeholder="street" maxlength="60" size="60" type="text" required />
    <input id="update-ship-city" name="update-ship-city" placeholder="city" maxlength="60"  size="60" type="text" required />
    <input id="update-ship-state" name="update-ship-state" placeholder="state" maxlength="2" size="60" pattern="AL|AK|AR|AZ|CA|CO|CT|DC|DE|FL|GA|HI|IA|ID|IL|IN|KS|KY|LA|MA|MD|ME|MI|MN|MO|MS|MT|NC|ND|NE|NH|NJ|NM|NV|NY|OH|OK|OR|PA|RI|SC|SD|TN|TX|UT|VA|VT|WA|WI|WV|WY|al|ak|ar|az|ca|co|ct|dc|de|fl|ga|hi|ia|id|il|in|ks|ky|la|ma|md|me|mi|mn|mo|ms|mt|nc|nd|ne|nh|nj|nm|nv|ny|oh|ok|or|pa|ri|sc|sd|tn|tx|ut|va|vt|wa|wi|wv|wy" title="Two letter state code" type="text" required />
    <input id="update-ship-postcode" name="update-ship-postcode" placeholder="postcode" type="text" pattern="[0-9]{5}" maxlength="5" pattern="[0-9]{5}" title="Postcode" required /><br>
    Credit Card Number: <br>
    <input id="update-card" name="update-card" placeholder="card number" type="text" maxlength="16" pattern="[0-9]{16}" size="60" required/><br>
    Security Code: <br>
    <input id="update-security" name="update-security" placeholder="security code" type="text" maxlength="3" pattern="[0-9]{3}" size="60" required/><br>
    Expiration Date: <br>
    <input id="update-expire" name="update-expire" placeholder="expiration date" type="date" required/><br>
    <input id="update-submit" name="update-submit" value="Update" type="submit" />
    </form>
</fieldset>
<span style="color:red; font-weight:bold"><?php echo $error ; ?></span>
</div>

<br>


<div style="margin:0 auto; width:500px; z-index:1">
<span style="color:red; font-weight:bold"><?php echo $checkout_msg; ?></span>

<br>

<?php
    $error=''; // Error Message
    date_default_timezone_set('America/Los_Angeles');
    $today = date("Y-m-d");
    $_SESSION['today'] = $today;
    $query = " SELECT *  from Orders WHERE customerid='" . $_SESSION['customerid'] . "' AND paid='yes' ; ";
    $result = mysql_query($query, $connection);
    if ($result) {
        $index = 0;
        
        ?>


<h3 class="order-history">Order History</h3>
<table border="1" style="border-collapse: separate; border-spacing: 10px 20px; display:inline; ">



<?php
        while($subject = mysql_fetch_assoc($result)) {
            $index ++;
            // | productid | productcategoryid | productname  | productdescription  | productprice | specialsalesid | productid | startdate  | enddate    | percentoff |
            ?>
<tr class="main">
<td width="300" style="text-align:center">Order Date:<?php echo $subject["orderdate"]; ?></td>
<td width="300" style="text-align:center">Order Total:<?php echo $subject["ordertotal"]; ?></td>
<td width="300" style="text-align:center"><button>Details</button></td>
</tr>

<?php
    $subquery = "(select p.productname as productname, oi.count as count, ROUND(p.productprice * (100 - s.percentoff)/100) as productprice from OrderItems as oi, Product as p, Orders as o, SpecialSales as s WHERE o.orderid=oi.orderid AND s.productid=p.productid AND oi.productid=p.productid AND s.startdate < o.orderdate AND s.enddate > o.orderdate AND oi.orderid='" . $subject["orderid"] . "' ) union ( select p.productname as productname, oi.count as count, p.productprice as productprice from OrderItems as oi, Product as p, Orders as o WHERE o.orderid=oi.orderid AND  oi.productid=p.productid AND p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<=o.orderdate AND enddate>=o.orderdate ) AND oi.orderid='" . $subject["orderid"] . "') ; ";
    $subresult = mysql_query($subquery);
    if ($subresult) {
        ?>

<tr class="sub" style="display:none">
<td width="300" style="text-align:center">Name</td>
<td width="300" style="text-align:center">Count</td>
<td width="300" style="text-align:center">Price</td>
</tr>

<?php
        while($subsubject = mysql_fetch_assoc($subresult)) {
            ?>

<tr class="sub"  style="display:none">
<td width="300" style="text-align:center"><?php echo $subsubject["productname"]; ?></td>
<td width="300" style="text-align:center"><?php echo $subsubject["count"]; ?></td>
<td width="300" style="text-align:center"><?php echo $subsubject["productprice"]; ?></td>
</tr>


<?php
        }
    }
    
    ?>

<?php
    }
    }
    if($index == "0"){
        $error = "No Special Sales Today";
    }
    ?>


</table>

</div>

</div>

</body>

<script type="text/javascript">
function autoFill(id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var response = xmlhttp.responseText;
            var res = response.split("\t");
            document.getElementById("update-email").value = res[1];
            document.getElementById("update-password").value = res[2];
            document.getElementById("update-firstname").value = res[3];
            document.getElementById("update-lastname").value = res[4];
            var billaddress = res[5].split(",");
            var shipaddress = res[6].split(",");
            document.getElementById("update-bill-street").value = billaddress[0];
            document.getElementById("update-bill-city").value = billaddress[1];
            document.getElementById("update-bill-state").value = billaddress[2];
            document.getElementById("update-bill-postcode").value = billaddress[3];
            
            document.getElementById("update-ship-street").value = shipaddress[0];
            document.getElementById("update-ship-city").value = shipaddress[1];
            document.getElementById("update-ship-state").value = shipaddress[2];
            document.getElementById("update-ship-postcode").value = shipaddress[3];
            
            document.getElementById("update-card").value = res[7];
            document.getElementById("update-security").value = res[8];
            document.getElementById("update-expire").value = res[9];
        }
    }
    xmlhttp.open("GET", "get_users.php?id=" + id, true);
    xmlhttp.send();
};


$(document).ready(function(){
                  $("button").click(function(){
                                    $(this).closest("tr").nextUntil("tr.main").toggle();
                                    });
                  });

</script>

</html>



