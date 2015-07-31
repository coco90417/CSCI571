<?php require_once("../icages_backend/includes/db_connection.php"); ?>
<?php
    if (isset($_GET['id'])) {
    
    // $username and $password
    
    $userid = $_GET['id'];
    
    $userid = stripslashes($userid);
    
    $userid = mysql_real_escape_string($userid);
    
    // Selecting Database
    
    $query  = "SELECT * FROM Customers ";
    
    $query .= "WHERE customerid='" . $userid . "' ; ";
    
    $result = mysql_query($query, $connection);
    
    if ($result) {
        
        $subject = mysql_fetch_assoc($result);
        
# | customerid | username  | password | firstname | lastname | billaddress | shipaddress | creditcard    | security | expirationdate
        
        echo $subject["customerid"] . "\t" . $subject["username"] . "\t" . $subject["password"] . "\t" . $subject["firstname"] . "\t" . $subject["lastname"] . "\t" . $subject["billaddress"] . "\t"  . $subject["shipaddress"] . "\t" . $subject["creditcard"] . "\t" . $subject["security"] . "\t" . $subject["expirationdate"] ;
        
    } else {
        
        $error = "No Such User, Please Try Again!";
        
        echo null;
        
    }
    
}
?>
