<?php require_once("../includes/db_connection.php"); ?>
<?php
    
    if (isset($_GET['id'])) {
    
    // $username and $password
    
    $productid = $_GET['id'];
    
    $productid = stripslashes($productid);
    
    $productid = mysql_real_escape_string($productid);
    
    // Selecting Database
    
    $query  = "SELECT * FROM Product ";
    
    $query .= "WHERE productid='" . $productid . "' ; ";
    
    $result = mysql_query($query, $connection);
    
    if ($result) {
        
        $subject = mysql_fetch_assoc($result);
        
        #  | productid | productcategoryid | productname           | productdescription                  | productprice
        
        echo $subject["productcategoryid"] . " " . $subject["productname"] . " " . $subject["productdescription"] . " " . $subject["productprice"] ;
        
    } else {
        
        $error = "No Such Product, Please Try Again!";
        
        echo null;
        
    }
    
}
?>
