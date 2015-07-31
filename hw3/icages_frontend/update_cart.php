<?php  session_start();
    require_once("../icages_backend/includes/db_connection.php"); ?>
<?php
    date_default_timezone_set('America/Los_Angeles');
    $today = date("Y-m-d");
    if(isset($_POST['delete']) && $_POST['delete'] == "all"){
        $query = "DELETE From Orders ";
        $query .= " WHERE orderid='" . $_SESSION['orderid'] . "' ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "Successfully deleted order!";
        } else {
            $error = "Cannot delete order, Please Try Again!";
        };
        $query = "DELETE From OrderItems ";
        $query .= " WHERE orderid='" . $_SESSION['orderid'] . "' ; ";
        $result = mysql_query($query, $connection);
        if ($result) {
            $error = "Successfully deleted order!";
        } else {
            $error = "Cannot delete order, Please Try Again!";
        };
        
        unset($_SESSION['orderid']); 
    }else{
        $productid = $_POST['productid'];
        $orderprice = $_POST['orderprice'];
        $count = $_POST['count'];
    # not delete
        if(!isset($_POST['delete']) && !isset($_POST['update'])){

            
            # adding
            $customerid = $_SESSION['customerid'];
            $today = $_SESSION['today'];
            $count = stripslashes($count);
            $customerid = stripslashes($customerid);
            $today = stripslashes($today);

            
            $count = mysql_real_escape_string($count);
            $customerid = mysql_real_escape_string($customerid);
            $today = mysql_real_escape_string($today);
            
            # | orderid | orderdate  | ordertotal | customerid | paid |
            # | orderitemsid | orderid | count | productid |
            
            if(isset($_SESSION['orderid'])){
                # update order total
                $query = "UPDATE Orders ";
                $query .= " SET ordertotal = ordertotal + " . $orderprice * $count ;
                $query .= " WHERE orderid='" . $_SESSION['orderid'] . "' ; ";
                $result = mysql_query($query, $connection);
                if ($result) {
                    $error = "Successfully updated order!";
                } else {
                    $error = "Cannot update order, Please Try Again!";
                };
                
                # check whether this product has already been in orderitems table
                $query = "SELECT * FROM OrderItems ";
                $query .= "WHERE productid='" . $productid . "' AND orderid='" . $_SESSION['orderid'] . "' ; "  ;
                $result = mysql_query($query, $connection);
                if ($result) {
                    $subject = mysql_fetch_assoc($result);
                    if(isset($subject['orderitemsid'])){
                        $query = "UPDATE OrderItems " ;
                        $query .= " SET count=count + " . $count . " ";
                        $query .= "  WHERE orderitemsid='" .$subject['orderitemsid'] . "'; ";
                        $result = mysql_query($query, $connection);
                        if ($result) {
                            $error = "Successfully updated orderitems!";
                        } else {
                            $error = "Cannot update orderitem, Please Try Again!";
                        };
                    }else{
                        $query = "INSERT INTO OrderItems ";
                        $query .= "(orderid, count, productid) VALUES('" . $_SESSION['orderid'] . "', '" . $count . "' , '" . $productid . "') ; " ;
                        $result = mysql_query($query, $connection);
                        if ($result) {
                            $error = "Successfully updated orderitems!";
                        } else {
                            $error = "Cannot update orderitem, Please Try Again!";
                        };
                    }
                    $error = "Successfully updated orderitems!";
                } else {
                    $error = "Cannot update orderitem, Please Try Again!";
                };
                
                
            }else{
                # orders
                $query = "INSERT INTO Orders ";
                $query .= "(orderdate, ordertotal, customerid) VALUES ('" . $today . "','" . $orderprice * $count . "' ,'" . $customerid . "'); ";
                $result = mysql_query($query, $connection);
                if ($result) {
                    $error = "Successfully updated order!";
                } else {
                    $error = "Cannot update order, Please Try Again!";
                };
                
                # get order id
                $query = "SELECT * FROM Orders ";
                $query .= "WHERE orderdate='" . $today . "' AND customerid='" . $customerid . "' AND paid IS NULL ; ";
                $result = mysql_query($query, $connection);
                if ($result) {
                    $subject = mysql_fetch_assoc($result);
                    if(isset($subject['orderid'])){
                        $_SESSION['orderid'] = $subject['orderid'];
                    }
                } else {
                    $error = "Cannot update order, Please Try Again!";
                };
                
                # orderitems
                $query = "INSERT INTO OrderItems ";
                $query .= "(orderid, count, productid) VALUES('" . $_SESSION['orderid'] . "', '" . $count . "' , '" . $productid . "') ; ";
                $result = mysql_query($query, $connection);
                if ($result) {
                    $error = "Successfully updated orderitems!";
                } else {
                    $error = "Cannot update orderitem, Please Try Again!";
                };
                
            }
        
        }elseif($_POST['delete'] == "yes"){
            # delete order items
            $query = "DELETE From OrderItems ";
            $query .= " WHERE productid = '" . $productid . "' AND" ;
            $query .= " orderid='" . $_SESSION['orderid'] . "' ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Successfully deleted order!";
            } else {
                $error = "Cannot delete order, Please Try Again!";
            };
            
            # update order table
            $query = "UPDATE Orders ";
            $query .= " SET ordertotal=ordertotal-" .$count * $orderprice. "; "  ;
            $result = mysql_query($query, $connection);
            
            # if order total == 0 distroy total and restart another orderid
            $query = "SELECT * FROM Orders ";
            $query .= "WHERE orderid='" . $_SESSION['orderid'] . "' ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $subject = mysql_fetch_assoc($result);
                if($subject['ordertotal'] == "0"){
                    $query = "DELETE From Orders ";
                    $query .= " orderid='" . $_SESSION['orderid'] . "' ; ";
                    $result = mysql_query($query, $connection);
                    if ($result) {
                        $error = "Successfully deleted order!";
                    } else {
                        $error = "Cannot delete order, Please Try Again!";
                    };
                    $_SESSION['orderid'] = "";
                }
            };
        }elseif($_POST['update'] == "yes"){
            # update order total
            $pricedifference = ($count - $subject['count'] ) * $orderprice;
            
            $query = "UPDATE Orders ";
            $query .= " SET ordertotal = ordertotal + " . $pricedifference;
            $query .= " WHERE orderid='" . $_SESSION['orderid'] . "' ; ";
            $result = mysql_query($query, $connection);
            if ($result) {
                $error = "Successfully updated order!";
            } else {
                $error = "Cannot update order, Please Try Again!";
            };
            
            # update order item table
            $query = "SELECT * FROM OrderItems ";
            $query .= "WHERE productid='" . $productid . "' AND orderid='" . $_SESSION['orderid'] . "' ; "  ;
            $result = mysql_query($query, $connection);
            if ($result) {
                $subject = mysql_fetch_assoc($result);
                if(isset($subject['orderitemsid']) && $count != '0'){
                    $query = "UPDATE OrderItems " ;
                    $query .= " SET count='" . $count . "'";
                    $query .= "  WHERE orderitemsid='" .$subject['orderitemsid'] . "'; ";
                    $result = mysql_query($query, $connection);
                    if ($result) {
                        $error = "Successfully updated orderitems!";
                    } else {
                        $error = "Cannot update orderitem, Please Try Again!";
                    };
                }
            } else {
                $error = "Cannot update orderitem, Please Try Again!";
            };

        }
    }
?>
