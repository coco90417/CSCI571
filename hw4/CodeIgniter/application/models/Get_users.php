<?php
    

class Get_users extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_user($customerid){
        $query = " SELECT *  from Customers WHERE customerid = '" . $customerid . "' ;  " ;
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            return  $query_return->result_array();
        }
    }
    
    function login_user($username, $password){
        $query = " SELECT *  from Customers WHERE username = '" . $username . "' AND password='". $password. "' ;  " ;
        $query_return = $this->db->query($query);
        if ($query_return->num_rows() > 0)
        {
            return  $query_return->result_array();
        }
    }
    
    function insert_user($username, $password, $firstname, $lastname){
        $querydata = array(
                      'username' => $username  ,
                      'password' => $password ,
                      'firstname' => $firstname ,
                      'lastname' => $lastname
                      );
        if ($this->db->insert('Customers', $querydata))
        {
            return  TRUE;
        }else{
            return  FALSE;
        }
    }
    
    function update_user($customerid, $username, $password, $firstname, $lastname, $billaddress, $shipaddress, $creditcard, $security, $expirationdate){
        $querydata = array(
                           'username' => $username  ,
                           'password' => $password ,
                           'firstname' => $firstname ,
                           'lastname' => $lastname ,
                           'billaddress' => $billaddress ,
                           'shipaddress' => $shipaddress ,
                           'creditcard' => $creditcard ,
                           'security' => $security ,
                           'expirationdate' => $expirationdate
                           );
        $this->db->where('customerid', $customerid);
        if ($this->db->update('Customers', $querydata))
        {
            return  TRUE;
        }else{
            return  FALSE;
        }
    }
    
    
}
?>