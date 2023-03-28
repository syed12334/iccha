<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Home extends CI_Controller
{
    protected $data;
    public function __construct()
    {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper("utility_helper");
        $this->load->model("master_db");
        $this->load->model("home_db");
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
    public function index()
    {
        $requesturi = $_SERVER['REQUEST_URI'];
        $res = str_replace("/iccha/", "", $requesturi);
        $this->session->set_userdata('urlredirect',$res);
        $this->data["slider"] = $this->master_db->getRecords(
            "slider_img",
            ["status" => 0],
            "image,stitle as title,stagline as tagline,sliderlink as link",
            "id desc"
        );
        $this->data["ads1"] = $this->master_db->getRecords(
            "ads",
            ["status" => 0, "above" => 0],
            "ad_banner,ad_name as title,ad_link as link,id",
            "id desc",
            "",
            "",
            "2"
        );
        $this->data["ads2"] = $this->master_db->getRecords(
            "ads",
            ["status" => 0, "below" => 0],
            "ad_banner,ad_name as title,ad_link as link,id",
            "id asc",
            "",
            "",
            "2"
        );
        $this->data["ads3"] = $this->master_db->getRecords(
            "ads",
            ["status" => 0, "below" => 0],
            "ad_banner,ad_name as title,ad_link as link,id",
            "id asc",
            "",
            "",
            "1"
        );
        //echo $this->db->last_query();exit;
        $this->data["categoryimg"] = $this->master_db->getRecords(
            "category",
            ["status" => 0, "image !=" => ""],
            "image,page_url,cname as title",
            "id desc"
        );
        $this->data["newarrivals"] = $this->home_db->getPopularproducts();
        $this->data["best"] = $this->home_db->getBestproducts();
        $this->data["feature"] = $this->home_db->getFeatureproducts();
        $this->data["category"] = $this->master_db->getRecords(
            "category",
            ["status" => 0, "showcategory" => 0],
            "id as cat_id,page_url,cname,ads_image,icons",
            "cname asc",
            "",
            "",
            "3"
        );
        $this->data["brand"] = $this->master_db->getRecords(
            "brand",
            ["status" => 0],
            "brand_img",
            "id desc",
            "",
            "",
            "12"
        );
        $this->load->view("index", $this->data);
    }
    public function category()
    {
        $this->load->view("maincategory", $this->data);
    }
    public function products()
    {
        $page_url = $this->uri->segment(3);
       $id = "";$where="";
        $getSubcategoryid = $this->master_db->getRecords(
            "subcategory",
            ["page_url" => $page_url],
            "id"
        );
        //echo $this->db->last_query();exit;
        $getSubsubcategoryid = $this->master_db->getRecords(
            "subsubcategory",
            ["page_url" => $page_url],
            "id"
        );
         //echo $this->db->last_query();exit;
        if (count($getSubcategoryid) == 0) {
             $id = @$getSubsubcategoryid[0]->id;
            $this->data['filters'] = $this->home_db->getProductsize('',$id);
            //echo $this->db->last_query();
        }   
        elseif (count($getSubsubcategoryid) == 0) {
            $id = @$getSubcategoryid[0]->id;
            $this->data['filters'] = $this->home_db->getProductsize($id,'');
            // echo $this->db->last_query();
        }
        $this->load->view("products", $this->data);
    }
    public function productsFilters() {
      //echo "<pre>";print_r($_POST);exit;
        $page_url = $this->input->post('id');
        $id = "";$where="";
        $getSubcategoryid = $this->master_db->getRecords(
            "subcategory",
            ["page_url" => $page_url],
            "id"
        );
        $getSubsubcategoryid = $this->master_db->getRecords(
            "subsubcategory",
            ["page_url" => $page_url],
            "id"
        );
        if (count($getSubcategoryid) == 0) {
            $id = $getSubsubcategoryid[0]->id;
            $perpage = "";
            if (!empty($this->uri->segment(3))) {
                $perpage .= $this->uri->segment(3);
            }
            $this->load->library("pagination");
             $config = array();
              $config["base_url"] = base_url() . "home/products/" . $page_url;
              $config["total_rows"] = $this->home_db->getProductcount("", $id);
              $config["per_page"] = 6;
              $config["uri_segment"] = 3;
              $config["use_page_numbers"] = TRUE;
              $config["full_tag_open"] = '<ul class="pagination">';
              $config["full_tag_close"] = '</ul>';
              $config["first_tag_open"] = '<li>';
              $config["first_tag_close"] = '</li>';
              $config["last_tag_open"] = '<li>';
              $config["last_tag_close"] = '</li>';
              $config['next_link'] = '&gt;';
              $config["next_tag_open"] = '<li>';
              $config["next_tag_close"] = '</li>';
              $config["prev_link"] = "&lt;";
              $config["prev_tag_open"] = "<li>";
              $config["prev_tag_close"] = "</li>";
              $config["cur_tag_open"] = "<li class='active'><a href='#'>";
              $config["cur_tag_close"] = "</a></li>";
              $config["num_tag_open"] = "<li>";
              $config["num_tag_close"] = "</li>";
              $config["num_links"] = 1;
              $this->pagination->initialize($config);
            $this->pagination->initialize($config);
             $offset = "";$offsetnew ="";$off ="";
            if(!empty($perpage) && $perpage !='') {
              $offset .= (@$perpage -1) * @$config['per_page'];
            }
            else {
                $offset .='';
            }
            if($offset ==0) {
            $offsetnew .='';
           }else {
            $offsetnew .=$offset;
            $off .= ",".$offsetnew;
           }
           //echo $offsetnew;exit;
          
            $this->data['products'] = $this->master_db->sqlExecute('select p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,p.page_url,s.page_url as spage_url,p.page_url,ss.page_url as sspage_url from products p left join product_size ps on p.id = ps.pid left join subcategory s on s.id = p.subcat_id left join subsubcategory ss on ss.id = p.sub_sub_id left join brand b on b.id = p.brand_id where p.sub_sub_id = '.$id.' and p.status =0 group by ps.pid,p.ptitle order by p.id desc limit '.$config["per_page"].' '.$off.'  ');
            // $this->data['products'] = $this->home_db->getProducts(
            //     "",
            //     $id,
            //     $config["per_page"],
            //     $offset
            // );
             //echo $this->db->last_query();exit;
            $this->data["links"] = $links = $this->pagination->create_links();
            $html =  $this->load->view('productsfilterslist',$this->data,true);
            $output = ['products'=>$html,'links'=>$links];
        } elseif (count($getSubsubcategoryid) == 0) {
            $id = $getSubcategoryid[0]->id;
            $perpage = "";
            if (!empty($this->uri->segment(3))) {
                $perpage .= $this->uri->segment(3);
            }
            $this->load->library("pagination");
             $config = array();
              $config["base_url"] = base_url() . "home/products/" . $page_url;
              $config["total_rows"] = $this->home_db->getProductcount($id, "");
              $config["per_page"] = 6;
              $config["uri_segment"] = 3;
              $config["use_page_numbers"] = TRUE;
              $config["full_tag_open"] = '<ul class="pagination">';
              $config["full_tag_close"] = '</ul>';
              $config["first_tag_open"] = '<li>';
              $config["first_tag_close"] = '</li>';
              $config["last_tag_open"] = '<li>';
              $config["last_tag_close"] = '</li>';
              $config['next_link'] = '&gt;';
              $config["next_tag_open"] = '<li>';
              $config["next_tag_close"] = '</li>';
              $config["prev_link"] = "&lt;";
              $config["prev_tag_open"] = "<li>";
              $config["prev_tag_close"] = "</li>";
              $config["cur_tag_open"] = "<li class='active'><a href='#'>";
              $config["cur_tag_close"] = "</a></li>";
              $config["num_tag_open"] = "<li>";
              $config["num_tag_close"] = "</li>";
              $config["num_links"] = 1;
            $this->pagination->initialize($config);
              $offset = "";$offsetnew ="";$off ="";
            if(!empty($perpage) && $perpage !='') {
              $offset .= (@$perpage -1) * @$config['per_page'];
            }
            else {
                $offset .= '';
            }
           if($offset ==0) {
            $offsetnew .='';
           }else {
            $offsetnew .=$offset;
            $off .= ",".$offsetnew;
           }
           //echo $offsetnew;exit;
            $this->data['products'] = $this->master_db->sqlExecute('select p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,p.page_url,s.page_url as spage_url,p.page_url,ss.page_url as sspage_url from products p left join product_size ps on p.id = ps.pid left join subcategory s on s.id = p.subcat_id left join subsubcategory ss on ss.id = p.sub_sub_id left join brand b on b.id = p.brand_id where p.subcat_id = '.$id.' and p.status =0 group by ps.pid order by p.id desc limit '.$config["per_page"].' '.$off.' ');
            // $this->data['products'] = $this->home_db->getProducts(
            //     $id,
            //     "",
            //     $config["per_page"],
            //     $offset
            // );
           // echo $this->db->last_query();exit;
            $this->data["links"] = $links =  $this->pagination->create_links();
           $html =  $this->load->view('productsfilterslist',$this->data,true);
           $output = ['products'=>$html,'links'=>$links];
        }
        echo json_encode($output);
    }
    public function checkpincode() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $this->form_validation->set_rules('cpincode','Pincode','trim|required|numeric|exact_length[6]',['exact_length'=>'Six numbers are allowed','numeric'=>'Only numbers are allowed','required'=>'Pincode is required']);
             if($this->form_validation->run() ==TRUE) {
                 $cpincode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cpincode', true))));
                 $count = $this->master_db->sqlExecute('select c.noofdays,amount from pincodes p left join cities c on c.id = p.cid where p.pincode='.$cpincode.'');
                 if(count($count) >0) {
                    $subtotal =[];
                    $this->session->set_userdata('pincode',$cpincode);
                    $date = date('D m, y',strtotime('+'.$count[0]->noofdays.' days'));
                    $array = array(
                        'status'   => true,
                        'msg' => '<b style="font-size:15px;"><i class="fas fa-shuttle-van" style="margin-right:5px"></i>Get it by '.$date.'</b>',
                        'value' =>set_value($cpincode),
                        'amount' =>$count[0]->amount
                     );
                 }else {
                    $array = array(
                    'status'   => false,
                    'msg' => '<font style="color:red;font-size:14px;font-weight:bold">Unfortunately we do not ship to your pincode</font>',
               );
                 }
             }
             else {
                $array = array(
                    'formerror'   => false,
                    'pincode_error' => form_error('cpincode'),
               );
             }
         }else {
             $array = array(
                        'status'   => false,
                        'msg' => 'Invalid request',
                     );
         }
         echo json_encode($array);
    }
      public function pincodeCheck() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                 $cpincode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cpincode', true))));
                 $count = $this->master_db->sqlExecute('select c.noofdays,amount from pincodes p left join cities c on c.id = p.cid where p.pincode='.$cpincode.'');
                 if(count($count) >0) {
                    $tax = [];$totalAmount ="";
                    if(count($this->cart->contents()) >0) {
                      foreach ($this->cart->contents() as $cart) {
                        $tax[] = $cart['price'] *$cart['tax'] / 100;
                      }
                    }
                    if($this->session->userdata('discount')) {
                        $amount = floatval(array_sum($tax) + $this->cart->total() + $count[0]->amount)   * $this->session->userdata('discount') / 100;
                        $totalAmount .= '<span id="totalAmount">'. sprintf("%.2f",array_sum($tax) + $this->cart->total() + $count[0]->amount - $amount).'<div id="pincodeAm"></div></span>';
                    }else {
                        $totalAmount .= '<span id="totalAmount">'. sprintf("%.2f",array_sum($tax) + $count[0]->amount + $this->cart->total()).'<div id="pincodeAm"></div></span>';
                    }
                    //echo $totalAmount;exit;
                    $this->session->set_userdata('pamount',$count[0]->amount);
                    $date = date('D m, y',strtotime('+'.$count[0]->noofdays.' days'));
                    $array = array(
                        'status'   => true,
                        'msg' => '<b>Shipping is available to entered pincode '.$cpincode.'</b>',
                        'value' =>set_value($cpincode),
                        'amount' =>'<i class="fas fa-rupee-sign"></i> '.$count[0]->amount,
                        'totalamount'=>$totalAmount
                     );
                 }else {
                    $array = array(
                    'status'   => false,
                    'msg' => '<font style="color:red;font-size:14px;font-weight:bold">Unfortunately we do not ship to your pincode</font>',
               );
            }
         }else {
             $array = array(
                        'status'   => false,
                        'msg' => 'Invalid request',
                     );
         }
         echo json_encode($array);
    }
      public function reviews() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                 $this->form_validation->set_rules('reviews','Reviews','trim|required|regex_match[/^([A-Za-z0-9 ])+$/i]',['regex_match'=>'Invalid reviews','numeric'=>'Only numbers are allowed','required'=>'Review is required']);
                 if($this->form_validation->run() ==TRUE) {
                     $reviews = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('reviews', true))));
                     $pid = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pid', true))));
                     $ratings = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ratings', true))));
                     if($this->session->userdata(CUSTOMER_SESSION)) {
                        $db['pid'] = decode($pid);
                        $db['review_descp'] = $reviews;
                        $db['rating'] = $ratings;
                        $db['user_id'] = $this->session->userdata(CUSTOMER_SESSION)['id'];
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $insert = $this->master_db->insertRecord('reviews',$db);
                        if($insert >0) {
                            $array = array(
                                'status'   => true,
                                'csrf_token'=> $this->security->get_csrf_hash(),
                                'msg' => 'Review saved successfully'
                             );
                         }else {
                            $array = array(
                                'status'   => false,
                                'msg' => '<font style="color:red;font-size:14px;font-weight:bold">Unfortunately we do not ship to your pincode</font>',
                                'csrf_token'=> $this->security->get_csrf_hash()
                            );
                        }
                     }else {
                            $array = array(
                                'status'   => -1,
                                'url' => base_url().'login',
                                'csrf_token'=> $this->security->get_csrf_hash()
                            );
                     }
                 }
                 else {
                    $array = array(
                        'formerror'   => false,
                        'rating_error' => form_error('reviews'),
                        'csrf_token'=> $this->security->get_csrf_hash()
                   );
                 }
             }else {
                     $array = array(
                                'status'   => -1,
                                'msg' => 'Invalid request',
                                'csrf_token'=> $this->security->get_csrf_hash()
                            );
             }
         echo json_encode($array);
    }
    public function state() {
        //echo "<pre>";print_r($_POST);
        $id = trim($this->input->post('id'));
        $sid = trim($this->input->post('sid'));
        if(!empty($id)) {
            $getCity = $this->master_db->getRecords('cities',['sid'=>$id],'id,cname');
             $html ="";$naming ="";
            
             $html .="<option value=''>Select City</otpion>";
            if(count($getCity) >0) {
                foreach ($getCity as  $value) {
                    $html .="<option value='".$value->id."'>".$value->cname."</option>";
                } 
                $array = ['status'=>true,'msg'=>$html];  
            }else {
                $array = ['status'=>false,'msg'=>$html];
            }
        }else {
            $array = ['status'=>false,'msg'=>'Required fields are missing'];
        }
        echo json_encode($array);
    }
    public function city() {
        $id = trim($this->input->post('id'));
        $sid = trim($this->input->post('sid'));
        if(!empty($id)) {
            $getCity = $this->master_db->getRecords('area',['cid'=>$id],'id,areaname as cname');
             $html ="";
            
             $html .="<option value=''>Select Area</otpion>";
            if(count($getCity) >0) {
                foreach ($getCity as  $value) {
                    $html .="<option value='".$value->id."'>".$value->cname."</option>";
                } 
                $array = ['status'=>true,'msg'=>$html];  
            }else {
                $array = ['status'=>false,'msg'=>$html];
            }
        }else {
            $array = ['status'=>false,'msg'=>'Required fields are missing'];
        }
        echo json_encode($array);
    }
}
?>
