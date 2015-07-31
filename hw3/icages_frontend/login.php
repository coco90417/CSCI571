<?php session_start();
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
    }elseif(isset($_POST['profile'])){
         header("location:user.php");
    };
    require_once("../icages_backend/includes/db_connection.php");
    if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600 || isset($_POST['logout'])){
        require("logout.php");
    };
    
    $error=''; // Error Message
    if (isset($_POST['loginsubmit'])) {
        if(empty($_POST['username']) || empty($_POST['password'])){
            $error = "Username or Password is invalid";
        }else{
            // $username and $password
            $username=$_POST['username'];
            $password=$_POST['password'];
            $username = stripslashes($username);
            $password = stripslashes($password);
            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);
            // Selecting Database
            $query  = "SELECT * ";
            $query .= "FROM Customers ";
            $query .= "WHERE username = '" . $username . "' and password = '" .$password . "' " ;
            $query .= "LIMIT 1 ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $subject = mysql_fetch_assoc($result);
                
                if( $subject){
                    $_SESSION['username']=$subject["username"]; // Initializing Session
                    $_SESSION['customerid']=$subject["customerid"];
                    $_SESSION['start'] = time();
                    header("location:user.php");
                }else{
                    $error = "Username or Password is invalid, please sign up or try again";
                }
            } else {
                $error = "Username or Password is invalid, please sign up or try again";
            }
        }
    }elseif(isset($_POST['signupsubmit'])){
        $username=$_POST['newusername'];
        $password=$_POST['newpassword'];
        $firstname=$_POST['lname'];
        $lastname=$_POST['fname'];
        $username = stripslashes($username);
        $password = stripslashes($password);
        $firstname = stripslashes($firstname);
        $lastname = stripslashes($lastname);
        
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
        $firstname = mysql_real_escape_string($firstname);
        $lastname = mysql_real_escape_string($lastname);
        
        // Selecting Database
        $query  = "INSERT INTO Customers (username, password, firstname, lastname) ";
        $query .= "VALUES ('". $username . "', '" . $password . "','"  . $firstname . "','" . $lastname . "') ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "Account Created $username Successfully!";
        } else {
            $error = "Username or Password is invalid";
        };
    }elseif(isset($_POST['managersubmit'])){
        if(empty($_POST['manager-username']) || empty($_POST['manager-password'])){
            $managererror = "Username or Password is invalid";
        }else{
            // $username and $password
            $username=$_POST['manager-username'];
            $password=$_POST['manager-password'];
            $username = stripslashes($username);
            $password = stripslashes($password);
            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);
            // Selecting Database
            $query  = "SELECT * ";
            $query .= "FROM Users ";
            $query .= "WHERE username = '" . $username . "' and password = '" .$password . "' " ;
            $query .= "LIMIT 1 ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $subject = mysql_fetch_assoc($result);
                
                if( $subject){
                    $_SESSION['managerid']=$subject["userid"]; // Initializing Session
                    $_SESSION['start'] = time();
                    header("location:manager.php");
                }else{
                    $error = "Manager username or Password is invalid, please try again";
                }
            } else {
                $error = "Manager username or Password is invalid, please try again";
            }
        }
    };
?>

<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
<link rel="stylesheet" type="text/css" href="stylesheet/mystyle.css">
</head>
<body>
<div id="header">
<a href="home.php"><img src="img/logo.png" height="40"/></a>
<form action="" method="POST">
<input type="submit" name="dna" value="DNA Sequencing"/>
<input type="submit" name="rna" value="RNA Sequencing"/>
<input type="submit" name="chip" value="ChIP Sequencing"/>
<input type="submit" name="target" value="Targeted Sequencing"/>
<div style="float:right">

<?php if(isset($_SESSION['customerid']) || isset($_SESSION['managerid'])){
    
?>
<input type="submit" name="logout" value="Log Out"/>

<?php
    };
    ?>
</div>
</form>

</div>

<br>


<div id="main">
<div class="login" style="margin:0 auto; width:500px; z-index:1">
<fieldset style="display:inline-block; width:500px">
<legend>Login</legend>
<form method="POST">
E-mail address:<br>
<input type="email" id="username" name="username" size="60" maxlength="60" required/><br><br>
Password:<br>
<input type="password" id="password" name="password" size="60" maxlength="60" required/><br><br>
<input type="submit" name="loginsubmit" value="Login"/>
</form>
<button class="signup">Sign Up </button>
<div style="float:right">
<button class="manager">Manager Login </button>
</div>
<br>

</fieldset>
</div>
<br>

<div class="signup" style="width:500px; margin:0 auto;  display:none">
<fieldset style="width:500px">
<legend>Sign Up</legend>
<form method="POST">
First name:<br>
<input type="text" id="fname" name="fname" size="60" maxlength="60" required/><br><br>
Last name:<br>
<input type="text" id="lname" name="lname" size="60"  maxlength="60" required/><br><br>
E-mail address:<br>
<input type="email" id="newusername" name="newusername" size="60"  maxlength="60" required/><br><br>
Password:<br>
<input type="password" id="newpassword" name="newpassword" size="60"  maxlength="60" required/><br><br>
<input type="submit" name="signupsubmit"  value="Create Account"/>
</form>
</fieldset>
<br>

</div>
<br>

<div class="manager" style="margin:0 auto; width:500px; z-index:1; display:none">
<fieldset style="display:inline-block; width:500px">
<legend>Manager</legend>
<form method="POST">
User Name:<br>
<input type="text" id="manager-username" name="manager-username" size="60" maxlength="10" required/><br><br>
Password:<br>
<input type="password" id="manager-password" name="manager-password" size="60" maxlength="10" required/><br><br>
<input type="submit" name="managersubmit" value="Login"/>
</form>
<br>

</fieldset>
</div>

<div style="margin:0 auto; width:500px; z-index:1">
<span style="color:red; font-weight:bold"><?php echo $error; ?></span>
</div>
</div>

</body>

<script type="text/javascript">

$(document).ready(function(){
                  $("button.signup").click(function(){
                                    $("div.signup").toggle();
                                    });
                  $("button.manager").click(function(){
                         $("div.manager").toggle();
                         });
});

</script>

</html>



