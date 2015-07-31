<?php if (session_status() == PHP_SESSION_NONE) {
            session_start();
      }
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    
class User extends CI_Controller {
    public $data=array();
    public function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
        
    }
    
    public function login(){
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
        $this->load->model("Get_users");
        $user = $this->Get_users->login_user($username, $password);
        
        if(isset($user)){
            $_SESSION['customerid'] =  $user[0]['customerid'];
            $_SESSION['start'] = time();
            $this->load->view('style/header');
            $this->loaduser($user[0]);
            $this->load->view('style/footer');
        }else{
            $this->load->view('style/header');
            $this->load->view('login');
            $this->load->view('error/login');
            $this->load->view('style/footer');
        }
        
    }
    
    public function loaduser($user){
        $this->load->view('user', $user);
        $this->load->model("Get_items");
        $orderhistory = $this->Get_items->get_orderhistory($_SESSION['customerid']);
        if(isset($orderhistory)){
            foreach($orderhistory as $myorderhistory){
                $this->load->view('orderhistory', $myorderhistory);
                $orderid = $myorderhistory['orderid'];
                $subsubject = $this->Get_items->get_orderhistory_items($orderid);
                if(isset($subsubject)){
                    foreach($subsubject as $mysubsubject){
                        $this->load->view('orderhistory_items', $mysubsubject);
                    }
                }
            }
        }
        $this->load->view('user_end');
    }
    
    public function signup(){

        $username=$this->input->post('newusername');
        $password=$this->input->post('newpassword');
        $firstname=$this->input->post('fname');
        $lastname=$this->input->post('lname');
        
        $username = stripslashes($username);
        $password = stripslashes($password);
        $firstname = stripslashes($firstname);
        $lastname = stripslashes($lastname);
        
        $this->load->view('style/header');
        $this->load->model("Get_users");
        
        $this->load->view('login');
        if($this->Get_users->insert_user($username, $password, $firstname, $lastname)){
            $this->load->view('error/signup_succsess');
        }else{
            $this->load->view('error/signup_failure');
        }
        $this->load->view('style/footer');
    }
    
 
    
    public function update(){
        $username=$this->input->post('update-email');
        $password=$this->input->post('update-password');
        $firstname=$this->input->post('update-firstname');
        $lastname=$this->input->post('update-lastname');
        $bill_street = $this->input->post('update-bill-street');
        $bill_city = $this->input->post('update-bill-city');
        $bill_state = $this->input->post('update-bill-state');
        $bill_postcode = $this->input->post('update-bill-postcode');
        $ship_street = $this->input->post('update-ship-street');
        $ship_city = $this->input->post('update-ship-city');
        $ship_state = $this->input->post('update-ship-state');
        $ship_postcode = $this->input->post('update-ship-postcode');
        
        $bill_street = str_replace( ",", " ", $bill_street);
        $bill_city= str_replace(",", " ", $bill_city);
        $bill_state= str_replace( ",", " ", $bill_state);
        $bill_postcode= str_replace( ",", " ", $bill_postcode);
        $ship_street = str_replace( ",", " ", $ship_street);
        $ship_city= str_replace( ",", " ", $ship_city);
        $ship_state= str_replace( ",", " ", $ship_state);
        $ship_postcode= str_replace( ",", " ", $ship_postcode);
        
        $card=$this->input->post('update-card');
        $security=$this->input->post('update-security');
        $expire=$this->input->post('update-expire');
        
        $username = stripslashes($username);
        $password = stripslashes($password);
        $firstname = stripslashes($firstname);
        $lastname = stripslashes($lastname);
        $bill_street = stripslashes($bill_street);
        $bill_city = stripslashes($bill_city);
        $bill_state = stripslashes($bill_state);
        $bill_postcode = stripslashes($bill_postcode);
        $ship_street = stripslashes($ship_street);
        $ship_city = stripslashes($ship_city);
        $ship_state = stripslashes($ship_state);
        $ship_postcode = stripslashes($ship_postcode);
        $card = stripslashes($card);
        $security = stripslashes($security);
        $expire = stripslashes($expire);
        
        $billaddress = $bill_street . "," . $bill_city . "," . $bill_state . "," . $bill_postcode;
        $shipaddress = $ship_street . "," . $ship_city . "," . $ship_state . "," . $ship_postcode;
        
        $this->load->model("Get_users");
        $this->Get_users->update_user($_SESSION['customerid'], $username, $password, $firstname, $lastname, $billaddress, $shipaddress, $card, $security, $expire);
        $user = $this->Get_users->get_user($_SESSION['customerid']);
        
        if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
            $this->logout();
        }else{
        $this->load->view('style/header');
        if(isset($user)){
            $this->load->view('error/user_update_success');
            $this->loaduser($user[0]);
        }
        $this->load->view('style/footer');
        }

    }
    
    
    public function checkout(){
        $username=$this->input->post('update-email');
        $password=$this->input->post('update-password');
        $firstname=$this->input->post('update-firstname');
        $lastname=$this->input->post('update-lastname');
        $bill_street = $this->input->post('update-bill-street');
        $bill_city = $this->input->post('update-bill-city');
        $bill_state = $this->input->post('update-bill-state');
        $bill_postcode = $this->input->post('update-bill-postcode');
        $ship_street = $this->input->post('update-ship-street');
        $ship_city = $this->input->post('update-ship-city');
        $ship_state = $this->input->post('update-ship-state');
        $ship_postcode = $this->input->post('update-ship-postcode');
        
        $bill_street = str_replace( ",", " ", $bill_street);
        $bill_city= str_replace(",", " ", $bill_city);
        $bill_state= str_replace( ",", " ", $bill_state);
        $bill_postcode= str_replace( ",", " ", $bill_postcode);
        $ship_street = str_replace( ",", " ", $ship_street);
        $ship_city= str_replace( ",", " ", $ship_city);
        $ship_state= str_replace( ",", " ", $ship_state);
        $ship_postcode= str_replace( ",", " ", $ship_postcode);
        
        $card=$this->input->post('update-card');
        $security=$this->input->post('update-security');
        $expire=$this->input->post('update-expire');
        
        $username = stripslashes($username);
        $password = stripslashes($password);
        $firstname = stripslashes($firstname);
        $lastname = stripslashes($lastname);
        $bill_street = stripslashes($bill_street);
        $bill_city = stripslashes($bill_city);
        $bill_state = stripslashes($bill_state);
        $bill_postcode = stripslashes($bill_postcode);
        $ship_street = stripslashes($ship_street);
        $ship_city = stripslashes($ship_city);
        $ship_state = stripslashes($ship_state);
        $ship_postcode = stripslashes($ship_postcode);
        $card = stripslashes($card);
        $security = stripslashes($security);
        $expire = stripslashes($expire);
        
        $billaddress = $bill_street . "," . $bill_city . "," . $bill_state . "," . $bill_postcode;
        $shipaddress = $ship_street . "," . $ship_city . "," . $ship_state . "," . $ship_postcode;
        
        $this->load->model("Get_users");
        $this->Get_users->update_user($_SESSION['customerid'], $username, $password, $firstname, $lastname, $billaddress, $shipaddress, $card, $security, $expire);
        $this->load->model("Get_items");
        $this->Get_items->checkout();
        $user = $this->Get_users->get_user($_SESSION['customerid']);
        
        if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
            $this->logout();
        }else{
        $this->load->view('style/header');
        if(isset($user)){
            $this->load->view('error/checkout_success');
        }
        $this->load->view('style/footer');
        }
        
    }
    
    public function logout(){
        $this->load->view('style/empty');
        $this->load->view('style/header');
        $this->load->model("Get_items");
        $data['specials'] = $this->Get_items->get_special();
        $this->load->view('home', $data);
        $this->load->view('style/footer');
    }
    
}
    
?>