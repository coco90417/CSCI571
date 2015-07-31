<?php require_once("../includes/db_connection.php"); ?>
<?php
    
    if (isset($_GET['id'])) {
    
    // $username and $password
    
    $specialsalesid = $_GET['id'];
    
    $specialsalesid = stripslashes($specialsalesid);
    
    $specialsalesid = mysql_real_escape_string($specialsalesid);
    
    // Selecting Database
    
    $query  = "SELECT * FROM SpecialSales ";
    
    $query .= "WHERE $specialsalesid='" . $specialsalesid . "' ; ";
    
    $result = mysql_query($query, $connection);
    
    if ($result) {
        
        $subject = mysql_fetch_assoc($result);
        
        #   specialsalesid | productid | startdate  | enddate    | percentoff
        
        echo $subject["productid"] . " " . $subject["startdate"] . " " . $subject["enddate"] . " " . $subject["percentoff"] ;
        
    } else {
        
        $error = "No Such Special Sales, Please Try Again!";
        
        echo null;
        
    }
    
}
?>
