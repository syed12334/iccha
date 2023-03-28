<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
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
	public function register() {
        if (!$this->session->userdata($this->data['session'])) {
            $this->load->view('login',$this->data);
        }else {
            redirect(base_url());
        }
    }
    public function registerSave() {
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			     $this->form_validation->set_rules('name','Name','trim|required|regex_match[/^([A-Za-z ])+$/i]|max_length[50]',['max_length'=>'Only 50 characters are allowed','regex_match'=>'Invalid name','required'=>'Name is required']);
		        $this->form_validation->set_rules('emailid','Email','trim|required|valid_email|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/]',['valid_email'=>'Enter valid email','required'=>'Email is required','regex_match'=>'Invalid email']);
		        $this->form_validation->set_rules('phone','Phone','trim|required|numeric|exact_length[10]',['numeric'=>'Only numeric values are allowed','exact_length'=>'Phone number should be 10 digits','required'=>'Phone number is required']);
		        //$this->form_validation->set_rules('password','Password','trim|required',['maxlength'=>'Only 12 characters are allowed','required'=>'Password is required']);
		        //$this->form_validation->set_rules('cpassword','Password','trim|required|matches[password]',['matches'=>'Confirm password should match password','required'=>'Confirm password is required']);
		         if($this->form_validation->run() ==TRUE) {
		            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
		            $email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('emailid', true))));
		            $phone = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('phone', true))));
		           // $password = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('password', true))));
		            //$cpassword = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('cpassword', true))));
		            if(isset($name) && !empty($name) && isset($email) && !empty($email) && isset($phone) && !empty($phone) ) {
		                $getUsers = $this->master_db->getRecords('users',['email'=>$email,'phone'=>$phone],'*');
		                if(count($getUsers) >0) {
		                    $array = ['status'=>false,'msg'=>'Email or password already exists try another','csrf_token'=> $this->security->get_csrf_hash()];
		                }else {
		                    $otp = rand(1234,9876);
		                    $db['name'] = $name;
		                    $db['email'] = $email;
		                    $db['phone'] = $phone;
		                   // $db['password'] = password_hash($password,PASSWORD_BCRYPT);
		                    $db['otp'] = $otp;
		                    $db['created_at'] = date('Y-m-d H:i:s');
		                    $in = $this->master_db->insertRecord('users',$db);
		                    if($in >0) {
		                        //$this->session->set_userdata('emailid',$email);
		                        //$this->load->library('Mail');
		                        $this->data['otp'] = $otp;
		                        //$html = $this->load->view('otpemail',$this->data,true);
		                        //$this->mail->sendMail($email,$html,'OTP Confirmation');
		                        $array = ['status'=>true,'msg'=>'Account created successfully','csrf_token'=> $this->security->get_csrf_hash()];
		                    }else {
		                        $array = ['status'=>false,'msg'=>'Error in creating account','csrf_token'=> $this->security->get_csrf_hash()];
		                    }
		                }
		            }else {
		                $array = ['status'=>false,'msg'=>'Required fields are missing','csrf_token'=> $this->security->get_csrf_hash()];
		            }
		         }else {
		             $array = array(
			            'formerror'   => false,
			            'name_error' => form_error('name'),
			            'email_error' => form_error('emailid'),
			            'phone_error' => form_error('phone'),
			            //'password_error' => form_error('password'),
			            //'cpassword_error' => form_error('cpassword'),
			            'csrf_token'=> $this->security->get_csrf_hash()
		           );
		         }
			}else {
				$array = ['status'=>false,'msg'=>'Invalid request','csrf_token'=> $this->security->get_csrf_hash()];
			}
         echo json_encode($array);
    }
    public function otp() {
        if($this->session->userdata('emailid')) {
            $this->load->view('loginotp',$this->data);
        }else {
            redirect(base_url().'login');
        }
    	
    }
    public function verifyotp() {
    	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        $this->form_validation->set_rules('otpval','Phone','trim|required|numeric',['numeric'=>'Only numeric values are allowed','required'=>'OTP is required']);
         if($this->form_validation->run() ==TRUE) {
         	 $otp = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('otpval', true))));
         	 $email = $this->session->userdata('emailid');
         	$getOtp = $this->master_db->getRecords('users',['otp'=>$otp,'email'=>$email],'u_id as id,name,email,phone');
         	//echo $this->db->last_query();exit;
         	if(count($getOtp) >0) {
                $savesession =array('id'=>$getOtp[0]->id,'email'=>$getOtp[0]->email,'phone'=>$getOtp[0]->phone,'name'=>$getOtp[0]->name);
                $this->session->set_userdata(CUSTOMER_SESSION, $savesession);  
         		$array = ['status'=>true,'msg'=>'OTP verified successfully','csrf_token'=> $this->security->get_csrf_hash()];
         	}else {
         		 $array = ['status'=>false,'msg'=>'Invalid OTP','csrf_token'=> $this->security->get_csrf_hash()];
         	}
        }else {
        	 $array = array(
	            'formerror'   => false,
	            'otp_error' => form_error('otpval'),
	            'csrf_token'=> $this->security->get_csrf_hash()
           );
        }
      }else {
      		$array = ['status'=>false,'msg'=>'Invalid Request','csrf_token'=> $this->security->get_csrf_hash()];
      }
      echo json_encode($array);
    }
    public function loginsave() {
    	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		       $this->form_validation->set_rules('email','Email','trim|required|valid_email|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/]',['valid_email'=>'Enter valid email','required'=>'Email is required','regex_match'=>'Invalid email']);
		       if($this->form_validation->run() ==TRUE) {
		            $email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('email', true))));
		            $getEmail = $this->master_db->getRecords('users',['email'=>$email],'*');
		            if(count($getEmail) >0) {
		                //$otp = rand(1234,9876);
		                $otp = rand(1234,9876);
		                //$this->load->library('Mail');
		                //$this->data['otp'] = $otp;
		                //$html = $this->load->view('otpemail',$this->data,true);
		                //$this->mail->sendMail($email,$html,'OTP Confirmation');
		                $update = $this->master_db->updateRecord('users',['otp'=>$otp],['u_id'=>$getEmail[0]->u_id]);
		                if($update >0) {
		                    $this->session->set_userdata('emailid',$email);
		                     $array = array(
		                        'status'   => true,
		                        'msg'       => 'OTP Sent Successfully',
		                        'csrf_token'=> $this->security->get_csrf_hash()
		                    );
		                }
		               else {
		                    $array = array(
		                        'status'   => failure,
		                        'msg'       => 'Error in updating otp',
		                        'csrf_token'=> $this->security->get_csrf_hash()
		                    );
		               }
		            }else {
		                $array = array(
		                    'status'   => false,
		                    'msg'       => 'Email not exists try another',
		                    'csrf_token'=> $this->security->get_csrf_hash()
		                );
		            }
		        }else {
		            $array = array(
		                'formerror'   => false,
		                'email_error' => form_error('email'),
		                'csrf_token'=> $this->security->get_csrf_hash()
		           );
		        }
    	}else {
        	  $array = array(
                    'status'   => false,
                    'msg'       => 'Invalid request',
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
    	}
    	echo json_encode($array);
    }
    public function resendOtp() {
    	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		        $email =  $this->session->userdata('emailid');;
		        $getEmail = $this->master_db->getRecords('users',['email'=>$email],'*');
		        if(!empty($email) && $email !="") {
		                if(count($getEmail) >0) {
		                $otp = rand(1234,9876);
		                $this->load->library('Mail');
		                $this->data['otp'] = $otp;
		                $html = $this->load->view('otpemail',$this->data,true);
		                $this->mail->sendMail($email,$html,'Resend OTP');
		                $update = $this->master_db->updateRecord('users',['otp'=>$otp],['u_id'=>$getEmail[0]->u_id]);
		                if($update >0) {
		                    $result = ['status'=>true,'msg'=>'OTP Resend Successfully','csrf_token'=> $this->security->get_csrf_hash()];
		                }else {
		                    $result = ['status'=>false,'msg'=>'Error in updating','csrf_token'=> $this->security->get_csrf_hash()];
		                }
		            }else {
		                $result = ['status'=>false,'msg'=>'Email doesnt exists','csrf_token'=> $this->security->get_csrf_hash()];
		            }
		        }else {
		            $result = ['status'=>false,'msg'=>'Please enter emailid','csrf_token'=> $this->security->get_csrf_hash()];
		        }
    	}else {
    		$result = ['status'=>false,'msg'=>'Invalid request','csrf_token'=> $this->security->get_csrf_hash()];
    	}
            echo json_encode($result);

    }
    public function logout() {
        $this->session->unset_userdata(CUSTOMER_SESSION);
        redirect(base_url().'login');
    }
    public function updateProfile() {
    	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			     $this->form_validation->set_rules('name','Name','trim|required|regex_match[/^([A-Za-z ])+$/i]|max_length[50]',['max_length'=>'Only 50 characters are allowed','regex_match'=>'Invalid name','required'=>'Name is required']);
		        $this->form_validation->set_rules('email','Email','trim|required|valid_email|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/]',['valid_email'=>'Enter valid email','required'=>'Email is required','regex_match'=>'Invalid email']);
		        $this->form_validation->set_rules('phone','Phone','trim|required|numeric|exact_length[10]',['numeric'=>'Only numeric values are allowed','exact_length'=>'Phone number should be 10 digits','required'=>'Phone number is required']);
		         if($this->form_validation->run() ==TRUE) {
		            $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
		            $email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('email', true))));
		            $phone = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('phone', true))));
		            $uid = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('uid', true))));
		           
		            if(isset($name) && !empty($name) && isset($email) && !empty($email) && isset($phone) && !empty($phone) ) {
		                    $db['name'] = $name;
		                    $db['email'] = $email;
		                    $db['phone'] = $phone;
		                    $db['modified_at'] = date('Y-m-d H:i:s');
		                    $in = $this->master_db->updateRecord('users',$db,['u_id'=>$uid]);
		                    if($in >0) {
		                        $array = ['status'=>true,'msg'=>'Profile updated successfully','csrf_token'=> $this->security->get_csrf_hash()];
		                    }else {
		                        $array = ['status'=>false,'msg'=>'Error in updating profile','csrf_token'=> $this->security->get_csrf_hash()];
		                    }
		               
		            }else {
		                $array = ['status'=>false,'msg'=>'Required fields are missing','csrf_token'=> $this->security->get_csrf_hash()];
		            }
		         }else {
		             $array = array(
			            'formerror'   => false,
			            'name_error' => form_error('name'),
			            'email_error' => form_error('email'),
			            'phone_error' => form_error('phone'),
			            'csrf_token'=> $this->security->get_csrf_hash()
		           );
		         }
		         echo json_encode($array);
			}
    }
}