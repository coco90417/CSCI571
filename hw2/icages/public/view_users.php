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
        <label>Usertype :</label>
        <select id="search-usertype" name="search-usertype" >
        <option value="0" >----</option>
        <option value="1" >Admin</option>
        <option value="2">Manager</option>
        <option value="3">Sales</option>
        </select>
        <label>Salary Range (USD/year) :</label>
        <select id="search-salary" name="search-salary" >
        <option value="0" >----</option>
        <option value="1" >Below 100,000</option>
        <option value="2">100,000-200,000</option>
        <option value="3">200,000-300,000</option>
        <option value="4">Above 300,000</option>
        </select>
        <input name="search-submit" type="submit" value=" Search " />
    </form>


		<table style="width:100%" border=1>
        <tr>
<td>user id</td>
<td>user name</td>
<td>user type</td>
<td> first name </td>
<td>last name </td>
<td>age</td>
<td>salary</td>
</tr>
        <?php
            $error=''; // Error Message
            if (isset($_POST['search-submit'])) {
                // $username and $password
                $usertype=$_POST['search-usertype'];
                $salary=$_POST['search-salary'];
                
                $usertype = stripslashes($usertype);
                $salary = stripslashes($salary);
                
                $usertype = mysql_real_escape_string($usertype);
                $salary = mysql_real_escape_string($salary);
          
                if($salary == "1"){
                    $salary_query = " salary <= 100000 ";
                }elseif($salary == "2"){
                    $salary_query = " salary > 100000 and salary <= 200000 ";
                }elseif($salary == "3"){
                    $salary_query = " salary > 200000 and salary <= 300000 ";
                }elseif($salary == "4"){
                    $salary_query = " salary >= 300000 ";
                }else{
                    $salary_query = " ";
                }
                
                if($usertype == "1"){
                    $usertype_query = " usertype = 'admin' ";
                }elseif($usertype == "2"){
                    $usertype_query = " usertype = 'manager' ";
                }elseif($usertype == "3"){
                    $usertype_query = " usertype = 'sales' ";
                }else{
                    $usertype_query = " ";
                }

                // Selecting Database
                if($usertype_query == " " && $salary_query == " "){
                    $query = " SELECT * FROM Users ; ";
                }elseif($usertype_query == " " ){
                    $query  = "SELECT * FROM Users ";
                    $query .= "WHERE " . $salary_query ;
                    $query .= " ; ";
                }elseif($salary_query == " "){
                    $query  = "SELECT * FROM Users ";
                    $query .= "WHERE " . $usertype_query;
                    $query .= " ; ";
                }else{
                    $query  = "SELECT * FROM Users ";
                    $query .= "WHERE " . $salary_query . "and".  $usertype_query;
                    $query .= " ; ";
                }
                $result = mysql_query($query, $connection);
                if ($result) {
                    $index = 0;
                    while($subject = mysql_fetch_assoc($result)) {
                        $index ++;
                        // output data from each row
                        ?>
                        <td><?php echo $subject["userid"]; ?></td>
                        <td> <?php echo $subject["username"]; ?> </td>
                        <td><?php echo $subject["usertype"]; ?></td>
                        <td> <?php echo $subject["firstname"]; ?> </td>
                        <td><?php echo $subject["lastname"]; ?> </td>
                        <td><?php echo $subject["age"]; ?> </td>
                        <td><?php echo $subject["salary"] ; ?></td>
                        </tr>
                        <?php
                            }
                            
                            if($index == "0"){
                                $error = "No such user! Please Try Again!";
                            }
                } else {
                    $error = "No such user! Please Try Again!";
                }
            }
            ?>

		</table>
  </div>
<ul>
<?php
    if($_SESSION['usertype'] === "manager" ){
        ?> <li><a href="manager.php">Back to manager page</a></li>
<?php    }elseif($_SESSION['usertype'] == "admin"){
    ?><li><a href="admin.php">Back to admin page</a></li>
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

