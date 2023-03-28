<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_account extends CI_Controller {
	protected $data;
	public function __construct() {
		date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper("utility_helper");
        $this->load->model("master_db");
        $this->load->model("home_db");
        $this->load->model("cart_db");
        $this->data["detail"] = "";
        $this->data['session'] = CUSTOMER_SESSION; 
         if($this->session->userdata($this->data['session'])) {
            $new = $this->session->userdata($this->data['session']);
            $getWishlist = $this->master_db->getRecords('wishlist',['uid'=>$new['id'],'pid !='=>0],'*');
            $this->data['wishcount'] = $getWishlist;
        }
        $this->load->library('form_validation');
        $this->data["category"] = $this->master_db->getRecords(
            "category",
            ["status" => 0],
            "id as cat_id,page_url,cname,ads_image,icons",
            "cname asc",
            "",
            "",
            "14"
        );
        $this->data["header"] = $this->load->view(
            "includes/header1",
            $this->data,
            true
        );
        $this->data["footer"] = $this->load->view(
            "includes/footer1",
            $this->data,
            true
        );
        $this->data["js"] = $this->load->view("jsFile", $this->data, true);
        if (!$this->session->userdata($this->data['session'])) {
            redirect(base_url().'login');
        }
	}
    public function index() {
        $details = $this->session->userdata($this->data['session']);
        $this->data['orders'] = $this->master_db->getRecords('orders',['user_id'=>$details['id']],'*');
        $this->data['users'] = $this->master_db->getRecords('users',['u_id'=>$details['id']],'*');
        $this->data['wishlist'] = $this->home_db->viewWishlist($details['id']);
        //echo $this->db->last_query();exit();
        $this->load->view('my_account',$this->data);
    }
    public function order_view() {
        $oid = icchaDcrypt($this->uri->segment(2));
        $this->data['orders_products'] = $this->master_db->getRecords('order_products',['oid'=>$oid],'*');
        $this->data['billing'] = $this->master_db->getRecords('order_bills',['oid'=>$oid],'*');
        $this->data['orders'] = $this->master_db->getRecords('orders',['oid'=>$oid],'*');
        $this->load->view('order_view',$this->data);
    }
    public function removeWishlist() {
        $pid = icchaDcrypt($this->input->post('pid'));
        $del = $this->master_db->deleterecord('wishlist',['id'=>$pid]);
        $result = ['status'=>true,'msg'=>'Wishlist deleted successfully'];
        echo json_encode($result);
    }
}
?>