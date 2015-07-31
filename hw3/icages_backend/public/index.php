<?php require_once("login.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>iCAGES Corp</title>
<link href="stylesheets/custom.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="main">
    <h1>Welcome to iCAGES Corp. Please Login.</h1>
        <form action="" method="post">
            <label>UserName :</label>
                <input id="name" name="username" placeholder="username" type="text" />
            <label>Password :</label>
                <input id="password" name="password" placeholder="****" type="password" />
            <input name="submit" type="submit" value=" Login " />
        <span><?php echo $error; ?></span>
        </form>
</div>

<div id="footer">Copyright &copy; 2015 iCAGES Corp</div>

</body>
</html>
<?php
    // Close database connection
    if (isset($connection)) {
        mysql_close($connection);
    }
    ?>
