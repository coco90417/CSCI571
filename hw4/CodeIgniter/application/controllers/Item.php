<?php if (session_status() == PHP_SESSION_NONE) {
            session_start();
      }
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    
class Item extends CI_Controller {
    public $data=array();
    public function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
        
    }
    
    public function addtocart(){
        $productid=$this->input->post('productid');
        $count=$this->input->post('count');
        $price = $this->input->post('price');
        $cart = array();
        $cart['id'] = $productid;
        $cart['count'] = $count;
        $cart['price'] = $price;
        $productid = stripslashes($productid);
        $count = stripslashes($count);
        $price = stripslashes($price);
        $productid = mysql_real_escape_string($productid);
        $count = mysql_real_escape_string($count);
        $price = mysql_real_escape_string($price);
        $this->load->model("Get_items");
        if($this->Get_items->add_orders($productid, $count, $price)){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    public function updateproduct(){
        $productid=$this->input->post('productid');
        $count=$this->input->post('count');
        $price = $this->input->post('price');
        $cart = array();
        $cart['id'] = $productid;
        $cart['count'] = $count;
        $cart['price'] = $price;
        $productid = stripslashes($productid);
        $count = stripslashes($count);
        $price = stripslashes($price);
        $productid = mysql_real_escape_string($productid);
        $count = mysql_real_escape_string($count);
        $price = mysql_real_escape_string($price);
        $this->load->model("Get_items");
        if($this->Get_items->update_product($productid, $count, $price)){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    public function deleteproduct(){
        $productid=$this->input->post('productid');
        $count=$this->input->post('count');
        $price = $this->input->post('price');
        $cart = array();
        $cart['id'] = $productid;
        $cart['count'] = $count;
        $cart['price'] = $price;
        $productid = stripslashes($productid);
        $count = stripslashes($count);
        $price = stripslashes($price);
        $productid = mysql_real_escape_string($productid);
        $count = mysql_real_escape_string($count);
        $price = mysql_real_escape_string($price);
        $this->load->model("Get_items");
        if($this->Get_items->delete_product($productid, $count, $price)){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    public function deleteallproduct(){
        $cart = array();
        $this->load->model("Get_items");
        if($this->Get_items->delete_all_product()){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }

    
    
}
    
?>