<?php if (session_status() == PHP_SESSION_NONE) {
           session_start();
        }
class Get_items extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_special(){
        
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $query = " SELECT *  from Product as p, SpecialSales as s WHERE p.productid = s.productid AND s.startdate <= '" . $today . "' AND s.enddate >= '" . $today . "' ; ";
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            return  $query_return->result_array();
        }
    }
    
    function get_special_category($productcategoryid){
        
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $query = " SELECT *  from Product as p, SpecialSales as s WHERE p.productid = s.productid AND p.productcategoryid = '" . $productcategoryid . "' AND s.startdate <= '" . $today . "' AND s.enddate >= '" . $today . "' ; ";
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            return  $query_return->result_array();
        }
    }
    
    function get_nonspecial_category($productcategoryid){
        
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $query = " SELECT *  from Product as p WHERE p.productcategoryid = '" . $productcategoryid . "' AND p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<='" . $today . "' AND enddate>='" . $today . "' ) ;  " ;
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            return  $query_return->result_array();
        }
    }
    
    function get_orderhistory($customerid){
        $query = " select * from Orders WHERE customerid='" . $customerid . "' AND paid = 'yes'; ";
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            return $query_return->result_array();
        }
    }
    
    function get_orderhistory_items($orderid){
        $query = "(select p.productname as productname, oi.count as count, ROUND(p.productprice * (100 - s.percentoff)/100) as productprice from OrderItems as oi, Product as p, Orders as o, SpecialSales as s WHERE o.orderid=oi.orderid AND s.productid=p.productid AND oi.productid=p.productid AND s.startdate < o.orderdate AND s.enddate > o.orderdate AND oi.orderid='" . $orderid . "' ) union ( select p.productname as productname, oi.count as count, p.productprice as productprice from OrderItems as oi, Product as p, Orders as o WHERE o.orderid=oi.orderid AND  oi.productid=p.productid AND p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<=o.orderdate AND enddate>=o.orderdate ) AND oi.orderid='" . $orderid . "') ; ";
                                                                                                                                                                                                                                                                                                                                                                              
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0){
            return $query_return->result_array();
        }
    }
    
    function add_orders($productid, $count, $price){
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $result = $this->get_order();
        if(isset($result[0])){
            $orderid = $result[0]['orderid'];
            $_SESSION['orderid'] = $orderid;
            $ordertotal = $result[0]['ordertotal'];
            $total = $ordertotal + $price * $count;
            $orderdata = array(
                               'orderdate' => $today ,
                               'ordertotal' => $total ,
                               'customerid' => $_SESSION['customerid']
                               );
            
            $orderitemsdata = array(
                                    'productid' => $productid ,
                                    'count' => $count,
                                    'orderid' => $orderid
                                    );
       
            $orderitemsresult =  $this->db->where('orderid', $orderid)->where('productid', $productid)->get('OrderItems');
            $this->db->where('orderid', $orderid)->update('Orders', $orderdata);
            if($orderitemsresult->num_rows() > 0 ){
                $originalresult = $orderitemsresult->result_array();
                $originalcount = $originalresult[0]['count'];
                $finalcount = $originalcount + $count;
                $orderitemsnewdata = array(
                
                                        'count' => $finalcount,
                
                                        );
                $this->db->where('orderid', $orderid)->where('productid', $productid)->update('OrderItems', $orderitemsnewdata);
            }else{
                
                $this->db->where('orderid', $orderid)->insert('OrderItems', $orderitemsdata);
            }
        }else{
            $orderdata = array(
                               'orderdate' => $today ,
                               'ordertotal' => $price * $count ,
                               'customerid' => $_SESSION['customerid']
                               );
            $this->db->insert('Orders', $orderdata);
            $result = $this->get_order();
            $orderid = $result[0]['orderid'];
            $_SESSION['orderid'] = $orderid;
            $orderitemsdata = array(
                                    'productid' => $productid ,
                                    'count' => $count,
                                    'orderid' => $orderid
                                    );
            
            if($this->db->insert('OrderItems', $orderitemsdata)){
                return TRUE ;
            }else{
                return FALSE ;
            }
        }
        
    }
    
    function get_orderspecialtoday(){
        $customerid = $_SESSION['customerid'];
        if(isset($_SESSION['orderid'])){
            $orderid = $_SESSION['orderid'];
            date_default_timezone_set('America/Los_Angeles');
            $today = date("Y-m-d");
            $query = "SELECT * FROM Orders as o, SpecialSales as s, OrderItems as oi, Product as p where p.productid=s.productid AND o.paid IS NULL AND oi.orderid= o.orderid AND oi.productid = p.productid AND s.startdate <= '" . $today . "' AND s.enddate >= '" . $today . "' AND o.orderid='". $orderid . "' AND o.orderdate='" . $today. "' AND o.customerid='" . $customerid ."';";
            $query_return = $this->db->query($query);
            if($query_return->num_rows() > 0){
                return $query_return->result_array();
            }else{
                return FALSE;
            }

        }else{
            return FALSE;
        }
    }
    
    function get_ordernonspecialtoday(){
        $customerid = $_SESSION['customerid'];
        if(isset($_SESSION['orderid'])){
            $orderid = $_SESSION['orderid'];
            date_default_timezone_set('America/Los_Angeles');
            $today = date("Y-m-d");
            $query = "SELECT * FROM Orders as o, OrderItems as oi, Product as p where p.productid not in (SELECT productid FROM SpecialSales WHERE startdate<=o.orderdate AND enddate>=o.orderdate ) AND o.paid IS NULL AND oi.orderid= o.orderid AND oi.productid = p.productid AND o.orderid='". $orderid . "' AND o.orderdate='" . $today. "' AND o.customerid='" . $customerid ."';";
            $query_return = $this->db->query($query);
            if($query_return->num_rows() > 0){
                return $query_return->result_array();
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    
    
    function update_product($productid, $count, $price){
        $customerid = $_SESSION['customerid'];
        $orderid = $_SESSION['orderid'];
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
       
        
        $query = " select * from OrderItems as oi, Orders as o WHERE o.orderid=oi.orderid AND oi.productid = '" . $productid . "' AND o.customerid= '" . $customerid. "' AND o.orderid='" . $orderid . "';  " ;
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            $find = $query_return->result_array();
        }
        $ordertotal = $find[0]['ordertotal'];
        $oldcount = $find[0]['count'];
 
        $ordertotal = $ordertotal + ($count-$oldcount) * $price;
        
        $orderitemsdata = array(
                                'count' => $count
                                );
        
        $orderdata = array(
                    'ordertotal' =>  $ordertotal
        );
        $this->db->where('orderid', $orderid)->where('productid', $productid)->update('OrderItems', $orderitemsdata);
        $this->db->where('orderid', $orderid)->update('Orders', $orderdata);
    }
    
    function checkout(){
        $customerid = $_SESSION['customerid'];
        $orderid = $_SESSION['orderid'];
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $orderdata = array(
                           'paid' =>  'yes'
                           );
        $this->db->where('orderid', $orderid)->where('customerid', $customerid)->where('orderdate', $today)->update('Orders', $orderdata);
    }

    
    
    function delete_product($productid, $count, $price){
        $customerid = $_SESSION['customerid'];
        $orderid = $_SESSION['orderid'];
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        
        
        $query = " select * from OrderItems as oi, Orders as o WHERE o.orderid=oi.orderid AND oi.productid = '" . $productid . "' AND o.customerid= '" . $customerid. "' AND o.orderid='" . $orderid . "';  " ;
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            $find = $query_return->result_array();
        }
        $ordertotal = $find[0]['ordertotal'];
        $oldcount = $find[0]['count'];
        $orderitemsid = $find[0]['orderitemsid'];

        $ordertotal = $ordertotal - $count * $price;
        $orderdata = array(
                           'ordertotal' =>  $ordertotal
                           );
        $orderitemsdata = array(
                                'orderitemsid' => $orderitemsid
                                );
        $this->db->where('orderid', $orderid)->update('Orders', $orderdata);
        $this->db->delete('OrderItems', $orderitemsdata);

    }
    
    function delete_all_product(){
        $customerid = $_SESSION['customerid'];
        $orderid = $_SESSION['orderid'];
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $this->db->where('orderid', $orderid)->delete('Orders');
        $this->db->where('orderid', $orderid)->delete('OrderItems');
    }
    
    
    function get_order(){
        $customerid = $_SESSION['customerid'];
        date_default_timezone_set('America/Los_Angeles');
        $today = date("Y-m-d");
        $query = "SELECT * FROM Orders WHERE orderdate='" . $today. "' AND customerid='" . $customerid ."' AND paid IS NULL ;";
        $query_return = $this->db->query($query);
        if($query_return->num_rows() == 1){
            return $query_return->result_array();
        }else{
            return FALSE;
        }
    }
}
?>