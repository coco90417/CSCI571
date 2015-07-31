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


<div style="color:red; font-weight:bold"  >Thank you for your purchase! A confirmation email will be soon send to you! </div>

</div>

<div id="similarProducts">
</div>
</body>

</html>


