<?php require_once("../includes/db_connection.php"); ?>
<?php
    
    if (isset($_GET['id'])) {
    
    // $username and $password
    
    $userid = $_GET['id'];
    
    $userid = stripslashes($userid);
    
    $userid = mysql_real_escape_string($userid);
    
    // Selecting Database
    
    $query  = "SELECT * FROM Users ";
    
    $query .= "WHERE userid='" . $userid . "' ; ";
    
    $result = mysql_query($query, $connection);
    
    if ($result) {
        
        $subject = mysql_fetch_assoc($result);
        
        #  username | password | usertype | firstname | lastname | age
        
        echo $subject["username"] . " " . $subject["password"] . " " . $subject["usertype"] . " " . $subject["firstname"] . " " . $subject["lastname"] . " " . $subject["age"] . " "  . $subject["salary"] ;
        
    } else {
        
        $error = "No Such User, Please Try Again!";
        
        echo null;
        
    }
    
}
?>
