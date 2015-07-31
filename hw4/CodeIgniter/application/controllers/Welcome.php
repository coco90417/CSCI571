<?php
    session_start();
    defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
    public $data=array();
    public function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
        
    }
    
	public function index()
    {
        
        if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
            $this->logout();
        }else{
        $this->load->model("Get_items");
        $data['specials'] = $this->Get_items->get_special();
        $this->load->view('style/header');
		$this->load->view('home', $data);
        $this->load->view('style/footer');
        }
	}
    
    public function navigate(){

        $dna=$this->input->post('dna');
        $rna=$this->input->post('rna');
        $chip=$this->input->post('chip');
        $target=$this->input->post('target');
        $login=$this->input->post('login');
        $logout=$this->input->post('logout');
        $profile=$this->input->post('profile');
        $cart=$this->input->post('cart');
        if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
            $this->logout();
        }else{
        if(isset($dna)){

            $this->load->view('style/header');
            $productcategoryid = "1";
            $this->load->model("Get_items");
            $data['specials_category'] = $this->Get_items->get_special_category($productcategoryid);
            $data['nonspecials_category'] = $this->Get_items->get_nonspecial_category($productcategoryid);
            $this->load->view('galary', $data);
            $this->load->view('style/footer');
        }else if(isset($rna)){

            $this->load->view('style/header');
            $productcategoryid = "2";
            $this->load->model("Get_items");
            $data['specials_category'] = $this->Get_items->get_special_category($productcategoryid);
            $data['nonspecials_category'] = $this->Get_items->get_nonspecial_category($productcategoryid);
            $this->load->view('galary', $data);
            $this->load->view('style/footer');
        }else if(isset($chip)){

            $this->load->view('style/header');
            $productcategoryid = "3";
            $this->load->model("Get_items");
            $data['specials_category'] = $this->Get_items->get_special_category($productcategoryid);
            $data['nonspecials_category'] = $this->Get_items->get_nonspecial_category($productcategoryid);
            $this->load->view('galary', $data);
            $this->load->view('style/footer');
        }else if(isset($target)){

            $this->load->view('style/header');
            $productcategoryid = "4";
            $this->load->model("Get_items");
            $data['specials_category'] = $this->Get_items->get_special_category($productcategoryid);
            $data['nonspecials_category'] = $this->Get_items->get_nonspecial_category($productcategoryid);
            $this->load->view('galary', $data);
            $this->load->view('style/footer');
        }else if(isset($login)){

            $this->load->view('style/header');
            $this->load->view('login');
            $this->load->view('style/footer');
        }else if(isset($logout)){
            $this->logout();
        }else if(isset($profile)){
            $this->load->view('style/header');
            if(isset($_SESSION['customerid'])){
                $this->load->model("Get_users");
                $user = $this->Get_users->get_user($_SESSION['customerid']);
                if(isset($user)){
                    $this->loaduser($user[0]);
                }
            }
            $this->load->view('style/footer');
        }else if(isset($cart)){
            $this->load->view('style/header');
            if(isset($_SESSION['customerid'])){
                
                $this->loadcart();
                
            }
            $this->load->view('style/footer');
        }
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
    
    public function loaduser($user){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->load->view('user', $user);
        $this->load->model("Get_items");
        $orderhistory = $this->Get_items->get_orderhistory($_SESSION['customerid']);
        if(isset($orderhistory)){
            foreach($orderhistory as $myorderhistory){
                $this->load->view('orderhistory', $myorderhistory);
                $orderid = $myorderhistory['orderid'];
                $subsubject = array();
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
    
    public function loadcart(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
       
        $this->load->model("Get_items");
        $orderspecialtoday = $this->Get_items->get_orderspecialtoday();
        $ordernonspecialtoday = $this->Get_items->get_ordernonspecialtoday();
        if(!isset($orderspecialtoday[0]['orderid']) && !isset($ordernonspecialtoday[0]['orderid'])){
            $this->load->view('error/nothing_in_cart');
        }else{
        
        
            $this->load->view('cart');
            if(isset($orderspecialtoday[0]['orderid'])){
                foreach($orderspecialtoday as $special){
                    $this->load->view('cart_specialitems', $special);
                }
            }
            
            if(isset($ordernonspecialtoday[0]['orderid'])){
                foreach($ordernonspecialtoday as $nonspecial){
                    $this->load->view('cart_nonspecialitems', $nonspecial);
                }
            }
            $this->load->view('cart_end');
        }
    }

    
    public function checkout(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->load->model("Get_users");
        $user = $this->Get_users->get_user($_SESSION['customerid']);
        if(isset($_SESSION['start']) && time() - $_SESSION['start'] > 600){
            $this->logout();
        }else{
        $this->load->view('style/header');
        $this->load->view('error/review_payment');
        $this->load->view('checkout', $user[0]);
        $this->load->view('style/footer');
        }
    }
}
    
?>