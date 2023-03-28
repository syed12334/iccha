<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Cart extends CI_Controller
{
    protected $data;
    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper("utility_helper");
        $this->load->model("master_db");
        $this->load->model("home_db");
        $this->load->model("cart_db");
        $this->data['session'] = CUSTOMER_SESSION; 
         if($this->session->userdata($this->data['session'])) {
            $new = $this->session->userdata($this->data['session']);
            $getWishlist = $this->master_db->getRecords('wishlist',['uid'=>$new['id'],'pid !='=>0],'*');
            $this->data['wishcount'] = $getWishlist;
        }
        $this->data["detail"] = "";
        $this->data["category"] = $this->master_db->getRecords(
            "category",
            ["status" => 0],
            "id as cat_id,page_url,cname,ads_image,icons",
            "cname asc",
            "",
            "",
            "14"
        );
        $this->load->library("encryption");
        $this->data["header"] = $this->load->view(
            "includes/header",
            $this->data,
            true
        );
        $this->data["header1"] = $this->load->view(
            "includes/header1",
            $this->data,
            true
        );
        $this->data["footer"] = $this->load->view(
            "includes/footer",
            $this->data,
            true
        );
        $this->data["js"] = $this->load->view("jsFile", $this->data, true);
    }
    public function addtocart()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //echo "<pre>";print_r($_POST);exit;
                $id = decode($_POST["id"]);
                $colors = trim($this->input->post('colors'));
                $sizes = trim($this->input->post('sizes'));
                $product = $this->cart_db->getCartproducts($id);
                $db = [
                    "id" => $product[0]->pid,
                    "qty" => 1,
                    "image" => base_url() . $product[0]->image,
                    "price" => $product[0]->price,
                    "discount" => $product[0]->discount,
                    "pcode" => $product[0]->pcode,
                    "name" => $product[0]->ptitle,
                    "purl" => $product[0]->page_url,
                    "stock" => $product[0]->stock,
                    "sizeid" => $product[0]->sid,
                    "cid" => $product[0]->coid,
                    "tax"   =>$product[0]->tax,
                    "coid"  =>$colors,
                    "sid"  =>$sizes,
                    "plink" => base_url() . "product/" . $product[0]->page_url . "",
                    "dmsg" => "",
                ];
                if ($this->cart->insert($db)) {
                    $subtotal = [];
                    foreach ($this->cart->contents() as $cart) {
                        $subtotal[] = $cart['subtotal'];
                    }
                    $html = $this->load->view("cartitems", $this->data, true);
                    $result = [
                        "status" => true,
                        "msg" => $html,
                        "count" => count($this->cart->contents()),
                        'subtotal'=>array_sum($subtotal)
                    ];
                } else {
                    $result = [
                        "status" => false,
                        "msg" => "Error in adding",
                    ];
                }
        }else {
             $result = [
                        "status" => true,
                        "msg" => 'Invalid request',
                    ];
        }
        echo json_encode($result);
    }
    public function removeCartitem()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                $rowid = $this->input->post("id");
                $pre = $this->input->post("pre");
                //echo "<pre>";print_r($_POST);exit;
                $dat = [
                    "rowid" => $rowid,
                    "qty" => "0",
                ];
                if ($this->cart->update($dat)) {
                     $subtotal = [];
                    foreach ($this->cart->contents() as $cart) {
                        $subtotal[] = $cart['subtotal'];
                    }
                    if($pre ==1) {
                        $html = $this->load->view("cartitems", $this->data, true);
                        $result = [
                        "status" => true,
                        "msg" => $html,
                        "count" => count($this->cart->contents()),
                        'subtotal'=>array_sum($subtotal)
                        ];
                    }
                    else if($pre ==2) {
                        $html = $this->load->view("cartitemsdel", $this->data, true);
                        $result = [
                        "status" => true,
                        "msg" => $html,
                        "count" => count($this->cart->contents()),
                        'subtotal'=>array_sum($subtotal)
                        ];
                    }
                    
                } else {
                    $result = [
                        "status" => false,
                        "msg" => "Error in removing items",
                    ];
                }
                echo json_encode($result);
        }else {
            $result = [
                        "status" => false,
                        "msg" => "Invalid request",
                    ];
        }
        
    }
    public function updateCart()
    {
        $html ="";
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $rowid = $this->input->post("rowid");
            $qty = $this->input->post("qty");
            $msg = "";
            $chaneqty = 0;
            $tax = [];
            $ars = [];
            foreach ($this->cart->contents() as $items) {
                if ($items["rowid"] == $rowid) {
                    $dat = [
                        "rowid" => $rowid,
                        "qty" => $qty,
                    ];
                    $this->cart->update($dat);
                }
            }
            $html .= $this->load->view('cartitemsdel',$this->data,true);
        }else {
            $html .="Invalid request";
        }
       echo json_encode(['status'=>true,'msg'=>$html]);
    }
    public function cartDetails() {
        $this->load->view('cart',$this->data);
    }
    public function couponList() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                //echo "<pre>";print_r($_POST);exit;
                $this->load->library('form_validation');
                $this->form_validation->set_rules('couponcode','Coupon Code','trim|required|regex_match[/^([A-Za-z0-9])+$/i]|max_length[10]',['required'=>'Coupon Code is required','regex_match'=>'Only characters and numbers are allowed and spaces are not allowed','max_length'=>'Only 10 digits are allowed']);
                 if($this->form_validation->run() ==TRUE) {
                    $couponcode = trim(html_escape($this->input->post('couponcode')));
                    $getCoupon = $this->master_db->getRecords('vouchers',['title'=>$couponcode],'to_date,discount');
                    //echo $this->db->last_query();exit;
                    $tax =[];
                    if(count($this->cart->contents()) >0) {
                        foreach ($this->cart->contents() as $cart) {
                            $tax[] = $cart['tax'] / 100 * $cart['price'];
                        }
                    }
                    if(count($getCoupon) >0) {
                         $totalPrice = @array_sum($tax) + @$this->cart->total() + $this->session->userdata('pamount');
                         $totalDiscount = $totalPrice * $getCoupon[0]->discount / 100;
                         $totalAmount ="";
                         $total = @$totalPrice - @$totalDiscount;
                         $this->session->set_userdata('discount',@$getCoupon[0]->discount);
                         if($this->session->userdata('pamount')) {
                            $totalAmount .= '<span id="totalAmount">'. sprintf("%.2f",$total ).'<div id="pincodeAm"></div></span>';
                        }else {
                            $totalAmount .= '<span id="totalAmount">'. sprintf("%.2f",$total).'<div id="pincodeAm"></div></span>';
                        }
                    
                         $date = date('Y-m-d');
                        if($date  >=  $getCoupon[0]->to_date) {
                            $resul = array(
                                 'status'   => false,
                                 'msg'      =>'Coupon code is expired',
                            );
                        }else {
                            $resul = array(
                                 'status'   => true,
                                 'msg'      =>'Coupon code matched',
                                 'discount' => $getCoupon[0]->discount,
                                 'total'    =>$totalAmount,
                            );
                        }
                    }else {
                        $resul = array(
                             'status'   => false,
                             'msg'      =>'Coupon code does not exists try another',
                        );
                    }
                 }else {
                    $resul = array(
                             'formerror'   => false,
                            'coupon_error' => form_error('couponcode'),
                        );
                 }
        }else {
                 $resul = array(
                             'status'   => false,
                             'msg'      =>'Invalid request',
                        );
        }
                 echo json_encode($resul);
    }
    public function wishlist() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //echo "<pre>";print_r($_POST);exit;
            $details = $this->session->userdata($this->data['session']);
           $pid = decode($this->input->post('pid'));
            if (!$this->session->userdata($this->data['session'])) {
                $result = ['status'=>-1,'url'=>base_url().'login'];
            }else {
                $details = $this->session->userdata($this->data['session']);
                $getWishlist = $this->master_db->getRecords('wishlist',['pid'=>$pid,'uid'=>$details['id']],'*');
                if(count($getWishlist) >0) {
                    $result = ['status'=>false,'msg'=>'Product already added to wishlist'];
                }else {
                    $db['uid'] = $details['id'];
                    $db['pid'] = $pid;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('wishlist',$db);
                    if($in >0) {
                        $result = ['status'=>true,'msg'=>'Added to wishlist'];
                    }else {
                        $result = ['status'=>false];
                    } 
                }
            }
            echo json_encode($result);
        }
    }
    public function cancelOrder() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $oid = icchaDcrypt($this->input->post('pid'));
            $status =4;
            $db['status'] = $status;
            $update = $this->master_db->updateRecord('orders',$db,['oid'=>$oid]);
            if($update >0) {
                $result = ['status'=>true,'msg'=>'Order cancelled successfully'];
            }else {
                $result = ['status'=>false,'msg'=>'Error in cancelling order'];
            }
            echo json_encode($result);
        }
    }
}
