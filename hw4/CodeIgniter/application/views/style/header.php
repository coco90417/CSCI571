<?php
    if(isset($_SESSION['customerid'])){
        $id = $_SESSION['customerid'];
    }else{
        $id = "NA";
    }
    ?>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.1/angular.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/stylesheet/mystyle.css'); ?>">
</head>

<body>
<div style="display:none" id="my-hidden-id"><?php echo $id; ?></div>
<div id="header">
<a href="<?php echo base_url('index.php/welcome/index');?>"><img src="<?php echo base_url('assets/img/logo.png'); ?>" height="40"/></a>
<form action="<?php echo base_url('index.php/welcome/navigate');?>" method="POST">
<input type="submit" name="dna" value="DNA Sequencing"/>
<input type="submit" name="rna" value="RNA Sequencing"/>
<input type="submit" name="chip" value="ChIP Sequencing"/>
<input type="submit" name="target" value="Targeted Sequencing"/>
<div style="float:right">
<?php
    if($id == "NA"){
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
