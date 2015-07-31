<?php require_once("../includes/db_connection.php"); ?>
<?php
    
    if (isset($_GET['id'])) {
    
    // $username and $password
    
    $categoryid = $_GET['id'];
    
    $categoryid = stripslashes($categoryid);
    
    $categoryid = mysql_real_escape_string($categoryid);
    
    // Selecting Database
    
    $query  = "SELECT * FROM ProductCategory ";
    
    $query .= "WHERE productcategoryid='" . $categoryid . "' ; ";
    
    $result = mysql_query($query, $connection);
    
    if ($result) {
        
        $subject = mysql_fetch_assoc($result);
        
        #  | productcategoryid | productcategoryname | productdescription
        
        echo  $subject["productcategoryname"] . " " . $subject["productdescription"]  ;
        
    } else {
        
        $error = "No Such ProductCategory, Please Try Again!";
        
        echo null;
        
    }
    
}
?>
