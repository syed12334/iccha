<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
class Checkout extends CI_Controller {
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
        $this->load->library('form_validation');
         if($this->session->userdata($this->data['session'])) {
            $new = $this->session->userdata($this->data['session']);
            $getWishlist = $this->master_db->getRecords('wishlist',['uid'=>$new['id'],'pid !='=>0],'*');
            $this->data['wishcount'] = $getWishlist;
        }
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
         if (!$this->session->userdata($this->data['session'])) {
            redirect(base_url().'login');
        }else {
            //echo "<pre>";print_r($this->session->userdata(CUSTOMER_SESSION));
            $this->data['states'] = $this->master_db->getRecords('states',['status'=>0],'id,name');
            $this->data['cities'] = $this->master_db->getRecords('cities',['status'=>0],'id,cname');
            $this->data['area'] = $this->master_db->getRecords('area',['status'=>0],'id,areaname');
             $this->load->view('checkout',$this->data);
        }
    }
    public function confirmorder() {
        //echo "<pre>";print_r();exit;
        $details = $this->session->userdata($this->data['session']);
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $this->form_validation->set_rules('bfname','First Name','trim|required|regex_match[/^([a-zA-Z ])+$/i]|max_length[20]',['required'=>'Billing First name is required','regex_match'=>'Invalid billing first name','max_length'=>'Maximum 20 characters are allowed']);
            //$this->form_validation->set_rules('blname','Last Name','trim|required|regex_match[/^([a-zA-Z ])+$/i]|max_length[20]',['required'=>'Billing First name is required','regex_match'=>'Invalid billing last name','max_length'=>'Maximum 20 characters are allowed']);
            $this->form_validation->set_rules('bemail','Billing Email','trim|required|valid_email|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/]',['required'=>'Billing email is required','valid_email'=>'Enter valid email','regex_match'=>'Invalid email']);
            $this->form_validation->set_rules('bphone','Product Title','trim|required|numeric|exact_length[10]',['numeric'=>'Only numeric values are allowed','exact_length'=>'10 Numbers are allowed','required'=>'Billing phone number is required']);
            $this->form_validation->set_rules('bpincode','Product Code','trim|required|numeric|exact_length[6]',['required'=>'Billing pincode is required','exact_length'=>'Minimum 6 numbers are allowed','numeric'=>'Only numeric values are allowed']);
             $this->form_validation->set_rules('bstate','Billing State','trim|required',['required'=>'Billing state is required']);
            $this->form_validation->set_rules('bcity','Billing city','trim|required',['required'=>'Billing city is required']);
            $this->form_validation->set_rules('barea','Billing Area','trim|required',['required'=>'Billing area is required']);
            $this->form_validation->set_rules('baddress','Billing Address ','trim|required|regex_match[/^([a-zA-Z0-9#., ])+$/i]',['required'=>'Please enter billing address','regex_match'=>'Invalid address']);
            if($this->input->post('shipped') ==1) {
                    $this->form_validation->set_rules('sfname','First Name','trim|required|regex_match[/^([a-zA-Z ])+$/i]|max_length[20]',['required'=>'Shipping First name is required','regex_match'=>'Invalid shipping first name','max_length'=>'Maximum 20 characters are allowed']);
                    //$this->form_validation->set_rules('slname','Last Name','trim|required|regex_match[/^([a-zA-Z ])+$/i]|max_length[20]',['required'=>'Shipping First name is required','regex_match'=>'Invalid shipping last name','max_length'=>'Maximum 20 characters are allowed']);
                    $this->form_validation->set_rules('semail','Shipping Email','trim|required|valid_email|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/]',['required'=>'Shipping email is required','valid_email'=>'Enter valid email','regex_match'=>'Invalid email']);
                    $this->form_validation->set_rules('sphone','Product Title','trim|required|numeric|exact_length[10]',['numeric'=>'Only numeric values are allowed','exact_length'=>'10 Numbers are allowed','required'=>'Shipping phone number is required']);
                    $this->form_validation->set_rules('spincode','Product Code','trim|required|numeric|exact_length[6]',['required'=>'Shipping pincode is required','exact_length'=>'Minimum 6 numbers are allowed','numeric'=>'Only numeric values are allowed']);
                     $this->form_validation->set_rules('sstate','Shipping State','trim|required',['required'=>'Shipping state is required']);
                    $this->form_validation->set_rules('scity','Shipping city','trim|required',['required'=>'Shipping city is required']);
                    $this->form_validation->set_rules('sarea','Shipping Area','trim|required',['required'=>'Shipping area is required']);
                    $this->form_validation->set_rules('saddress','Shipping Address ','trim|required|regex_match[/^([a-zA-Z0-9#., ])+$/i]',['required'=>'Please enter shipping address','regex_match'=>'Invalid address']);
            }
            $this->form_validation->set_rules('pmode','Payment mode','trim|required',['required'=>'Please select payment mode']);
            if($this->form_validation->run() ==TRUE) {
                $bfname = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bfname', true))));
                $blname = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('blname', true))));
                $bemail = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bemail', true))));
                $bphone = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bphone', true))));
                $bpincode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bpincode', true))));
                $bstate = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bstate', true))));
                $bcity = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('bcity', true))));
                $barea = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('barea', true))));
                $baddress = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('baddress', true))));
                $shipped = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('shipped', true))));
                $pmode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pmode', true))));
                $sfname = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('sfname', true))));
                $slname = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('slname', true))));
                $semail = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('semail', true))));
                $sphone = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('sphone', true))));
                $spincode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('spincode', true))));
                $sstate = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('sstate', true))));
                $scity = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('scity', true))));
                $sarea = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('sarea', true))));
                $saddress = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('saddress', true))));
                $pincodeAmount = "";
                if($shipped ==1) {
                        $getSpincode = $this->master_db->getRecords('pincodes',['pincode'=>$spincode],'*');
                        if(count($getSpincode) ==0) {
                            $array = ['status'=>false,'msg'=>'Shipping is not available for entered pincode '.$spincode.'','csrf_token'=> $this->security->get_csrf_hash()];
                            echo json_encode($array);exit;
                        }else {
                            $pincodeAmount .= $getSpincode[0]->amount;
                        }
                }else {
                        $getBpincode = $this->master_db->getRecords('pincodes',['pincode'=>$bpincode],'*');
                        if(count($getBpincode) ==0) {
                            $array = ['status'=>false,'msg'=>'Shipping is not available for entered pincode '.$bpincode.'','csrf_token'=> $this->security->get_csrf_hash()];
                            echo json_encode($array);exit;
                        }else {
                            $pincodeAmount .= $getBpincode[0]->amount;
                        }
                }
                if(isset($bfname) && !empty($bfname) && isset($bemail) && !empty($bemail) && isset($bphone) && !empty($bphone) && isset($bpincode) && !empty($bpincode) && isset($bstate) && !empty($bstate) && isset($bcity) && !empty($bcity) && isset($barea) && !empty($barea) && isset($baddress) && !empty($baddress)) {
                    $tax =[];
                    if(is_array($this->cart->contents()) && !empty($this->cart->contents())) {
                        foreach ($this->cart->contents() as $key => $cart) {
                            $tax[] = $cart['price'] *$cart['tax'] / 100;
                        }
                    }
                    $totalAmount = "";
                    $orders['user_id'] = $details['id'];
                    if($this->session->userdata('discount')) {
                        $amount = floatval(array_sum($tax) + $this->cart->total() + $pincodeAmount) * $this->session->userdata('discount') / 100;
                        $orders['totalamount'] =  sprintf("%.2f",array_sum($tax) + $this->cart->total() + $pincodeAmount - $amount);
                        $orders['discount'] = $this->session->userdata('discount');
                         
                       $totalAmount .=sprintf("%.2f",array_sum($tax) + $this->cart->total() + $pincodeAmount - $amount);
                    }else {
                        $orders['totalamount'] =  sprintf("%.2f",array_sum($tax) + $this->cart->total() + $pincodeAmount);
                        $totalAmount .=sprintf("%.2f",array_sum($tax) + $this->cart->total() + $pincodeAmount);
                    }
                    $orders['delivery_charges'] = $this->session->userdata('pamount');
                    $orders['taxamount'] = array_sum($tax);
                    $orders['subtotal'] = $this->cart->total();
                    $orders['pmode'] = $pmode;
                    $orders['order_date'] = date('Y-m-d H:i:s');
                    $oid = $this->master_db->insertRecord('orders',$orders);
                    if($oid >0) {
                         $orderNo = $this->cart_db->generateOrderNo($oid);
                         $db = array('orderid' => $orderNo);
                         $this->master_db->updateRecord('orders',$db,['oid'=>$oid]);
                         if(is_array($this->cart->contents()) && !empty($this->cart->contents())) {
                            foreach ($this->cart->contents() as $key => $cart) {
                                $oproducts['oid'] = $oid;
                                $oproducts['qty'] = $cart['qty'];
                                $oproducts['name'] = $cart['name'];
                                $oproducts['pcode'] = $cart['pcode'];
                                $oproducts['price'] = $cart['price'];
                                $oproducts['image'] = $cart['image'];
                                $oproducts['purl'] = $cart['purl'];
                                $oproducts['pid'] = $cart['id'];
                                $oproducts['stock'] = $cart['stock'];
                                $oproducts['tax'] = $cart['tax'];
                                $this->master_db->insertRecord('order_products',$oproducts);
                            }
                        }
                        $bills['oid'] = $oid;
                        $bills['bfname'] = $bfname;
                        $bills['bemail'] = $bemail;
                        $bills['bphone'] = $bphone;
                        $bills['bpincode'] = $bpincode;
                        $bills['bstate'] = $bstate;
                        $bills['bcity'] = $bcity;
                        $bills['barea'] = $barea;
                        $bills['baddress'] = $baddress;
                        if($shipped ==1) {
                            $bills['sfname'] = $sfname;
                            $bills['semail'] = $semail;
                            $bills['sphone'] = $sphone;
                            $bills['spincode'] = $spincode;
                            $bills['sstate'] = $sstate;
                            $bills['scity'] = $scity;
                            $bills['sarea'] = $sarea;
                            $bills['saddress'] = $saddress;
                        }
                        $this->master_db->insertRecord('order_bills',$bills);
                        if($pmode ==1) {
                            $notes = array("categ"=>"New", "pname"=>'Betroot lim', "pcode"=>'ICCHA123');
                            $api = new Api(TEST_MERCHANT_KEY, TEST_MERCHANT_SECRET);
                            $razor_amt = $totalAmount * 100;
                            $order  = $api->order->create(array('receipt' => 'ICCHA123', 'amount' => $razor_amt, 'currency' => 'INR', 'payment_capture'=>1, 'notes'=>$notes));
                            $payment['oid'] = $oid;
                            if(isset($order["id"])){
                                $payment['order_id'] = $order["id"];
                            }
                            $this->master_db->insertRecord('payment_log',$payment);
                        }else if($pmode ==2) {
                            $payment['oid'] = $oid;
                            $payment['status'] = 2;
                            $this->master_db->insertRecord('payment_log',$payment);
                        }
                        $array = ['status'=>true,'msg'=>'Order placed','url'=>base_url().'checkout/orderProcess/'.$orderNo.'','csrf_token'=> $this->security->get_csrf_hash()];
                    }
                }else {
                    $array = ['status'=>false,'msg'=>'Required fields are missing','csrf_token'=> $this->security->get_csrf_hash()];
                }
            }else {
                 $array = array(
                'formerror'   => false,
                'bfname_error' => form_error('bfname'),
                //'blname_error' => form_error('blname'),
                'bemail_error' => form_error('bemail'),
                'bphone_error' => form_error('bphone'),
                'bpincode_error' => form_error('bpincode'),
                'bstate_error' => form_error('bstate'),
                'bcity_error' => form_error('bcity'),
                'barea_error' => form_error('barea'),
                'baddress_error' => form_error('baddress'),
                'sfname_error' => form_error('sfname'),
                //'slname_error' => form_error('slname'),
                'semail_error' => form_error('semail'),
                'sphone_error' => form_error('sphone'),
                'spincode_error' => form_error('spincode'),
                'sstate_error' => form_error('sstate'),
                'scity_error' => form_error('scity'),
                'sarea_error' => form_error('sarea'),
                'pmode_error' => form_error('pmode'),
                'saddress_error' => form_error('saddress'),
                'csrf_token'=> $this->security->get_csrf_hash()
               );
            }
           echo json_encode($array);
       } 
    }
    public function orderProcess() {
         $this->load->library('Mail');
        $oid = $this->uri->segment(3);
        if(isset($oid) && !empty($oid)) {
           $getOrders =  $this->master_db->getRecords('orders',['orderid'=>$oid],'totalamount,pmode,oid,orderid');
            $pmode = $getOrders[0]->pmode;
            if($pmode ==1) {
                $this->data['orders'] = $getOrders;
                $this->data['payment'] = $this->master_db->getRecords('payment_log',['oid'=>$getOrders[0]->oid],'*');
                $this->load->view('payment',$this->data);
            }
            else if($pmode ==2) {
                    $this->data['orders'] = $orders = $this->master_db->getRecords('orders',['orderid'=>$oid],'*');
                    //echo $this->db->last_query();exit;
                    $this->data['orderproducts'] = $this->master_db->getRecords('order_products',['oid'=>$orders[0]->oid],'*');
                    $this->data['payment'] = $this->master_db->getRecords('payment_log',['oid'=>$orders[0]->oid],'*');
                    $this->data['billing'] = $this->master_db->sqlExecute('select * from order_bills where oid='.$orders[0]->oid.'');
                     $this->data['order_bill'] = $order_bills =  $this->master_db->getRecords('order_bills',['oid'=>$orders[0]->oid],'*');
                    $social_links = $this->master_db->getRecords('sociallinks',['status'=>0],'*');
                    $this->data['social'] = $social_links;
                    $html = $this->load->view('order_success',$this->data,true);
                    $this->mail->sendMail($order_bills[0]->bemail,$html,'Your Order Summary');
                    $this->load->view('order_summary',$this->data); 
                    $this->session->unset_userdata('discount');
                    $this->session->unset_userdata('pamount');
                    $this->cart->destroy();
            }
        }
    }
    public function paymentResponse() {
        if($_SERVER['REQUEST_METHOD']=='POST'){
             $this->load->library('Mail');
                $val = 0;
                $payid = $this->input->post('paymentID');
                $orderID = $this->input->post('orderID');
                $signature = $this->input->post('signature');
                $oid = $this->input->post('oid');
                if ($payid == "" || $orderID == "" || $signature == "")
                {
                    echo '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Registration un-successful. Payment Details not found</div>';
                }
                else{
                    $generated_signature = hash_hmac('sha256',  $orderID . '|' . $payid, TEST_MERCHANT_SECRET);
                    if($generated_signature == $signature){
                        $db =['pay_id'=>$payid,'hash'=>$signature,'status'=>1];
                         $update = $this->master_db->updateRecord('payment_log',$db,['oid'=>$oid]);
                         if($update >0) {
                            $this->data['orders'] = $this->master_db->getRecords('orders',['oid'=>$oid],'*');
                            $this->data['orderproducts'] = $this->master_db->getRecords('order_products',['oid'=>$oid],'*');
                            $this->data['order_bill'] = $order_bills =  $this->master_db->getRecords('order_bills',['oid'=>$oid],'*');
                            $this->data['payment'] = $this->master_db->getRecords('payment_log',['oid'=>$oid],'*');
                            $this->data['billing'] = $this->master_db->sqlExecute('select * from order_bills where oid='.$oid.'');
                            $social_links = $this->master_db->getRecords('sociallinks',['status'=>0],'*');
                            //echo $this->db->last_query();exit;
                            $this->data['social'] = $social_links;
                            $html = $this->load->view('order_success',$this->data,true);
                            $this->mail->sendMail($order_bills[0]->bemail,$html,'Your Order Summary');
                             $this->load->view('order_summary',$this->data); 
                             $this->session->unset_userdata('discount');
                             $this->session->unset_userdata('pamount');
                             $this->cart->destroy();                       
                        }

                    }
                    else{
                        $db =['status'=>-1];
                         $update = $this->master_db->updateRecord('payment_log',$db,['oid'=>$oid]);
                         if($update >0) {
                            echo "Payment un-successful";
                         }
                    }
                }
        }
    }
    public function fetchPaymentStatus() {
         $api = new Api(TEST_MERCHANT_KEY, TEST_MERCHANT_SECRET);
         $orderID = "order_KlQJymQ0fFrmnb";
         $order  = $api->order->fetch($orderID)->payments();
        $orderDetails = $order->toArray();
        echo "<pre>";print_r($orderDetails);
    }
 }
?>