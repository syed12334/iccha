<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {
	protected $data;
	public function __construct() {
		date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper("utility_helper");
        $this->load->model("master_db");
        $this->load->model("home_db");
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
            "includes/header",
            $this->data,
            true
        );
        $this->data["header1"] = $this->load->view(
            "includes/header2",
            $this->data,
            true
        );
        $this->data["footer"] = $this->load->view(
            "includes/footer1",
            $this->data,
            true
        );
        $this->data["js"] = $this->load->view("jsFile", $this->data, true);
	}
    public function index() {
         $requesturi = $_SERVER['REQUEST_URI'];
        $res = str_replace("/iccha/", "", $requesturi);
        $this->session->set_userdata('urlredirect',$res);
        //echo $res;exit;
        $purl =  $this->uri->segment(2);
        $this->data['products'] = $products = $this->home_db->getProductviewpage($purl);
        //echo $this->db->last_query();exit();
        $this->data['getImages'] = $this->master_db->getRecords('product_images',['pid'=>$products[0]->pid],'*');
        $this->data['getSize'] = $this->master_db->sqlExecute('select ps.selling_price, ps.stock,s.sname,c.name as cname,c.co_id as cid,s.s_id as sid,c.ccode from product_size ps left join sizes s on s.s_id = ps.sid left join colors c on c.co_id = ps.coid where ps.pid ='.$products[0]->pid.'');
        $this->data['related'] = $this->home_db->getRelatedprod($products[0]->pid,$products[0]->subcat_id);
        //echo $this->db->last_query();exit;
        $this->data['reviews'] = $this->master_db->getRecords('reviews',['pid'=>$products[0]->pid],'*');
        $this->load->view('product_view',$this->data);
    }
 }
?>
