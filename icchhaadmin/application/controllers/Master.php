<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller {
    protected $data;
    public function __construct() {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->model('master_db');
        $this->load->model('home_db');
        $this->data['detail'] = "";
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->data['session'] = ADMIN_SESSION;
        if (!$this->session->userdata($this->data['session'])) {
            redirect('Login', 'refresh');
        } else {
            $sessionval = $this->session->userdata($this->data['session']);
            $details = $this->home_db->getlogin($sessionval['name']);
            if (count($details)) {
                $this->data['detail'] = $details;
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                redirect(base_url() . "login/logout");
            }
        }
        $this->data['header'] = $this->load->view('includes/header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('includes/footer', $this->data, TRUE);
    }
    public function index() {
        $this->load->view('index', $this->data);
    }
    /* Category  */
    public function category() {
        $this->load->view('masters/category/category', $this->data);
    }
    public function getCategorylist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (cname like '%$val%') ";
            $where.= " or (image like '%$val%') ";
        }
        $order_by_arr[] = "cname";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from category " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            if (!empty($r->image)) {
                $image.= "<img src='" . app_url() . $r->image . "'  style='width:80px'/>";
            }
            $action = '<a href=' . base_url() . "master/editcategory/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            if($r->showcategory ==1) {
                $action.= "<button title='Show in homepage categories' class='btn btn-warning'  onclick='updateStatus(" . $r->id . ", 3)' >H</button>&nbsp;";
            }else {
                $action.= "<button title='Dont show in homepage categories' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 4)' style='background:#e08e0b!important;color:#fff!important;border-color:#e08e0b!important'>H</button>&nbsp;";
            }
            
            $sub_array[] = $i++;
            $sub_array[] = $action;
            // $sub_array[] = $image;
            $sub_array[] = ucfirst($r->cname);
            $sub_array[] =$r->id;
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function categoryadd() {
        $this->load->view('masters/category/categoryadd', $this->data);
    }
    public function editcategory() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['category'] = $this->master_db->getRecords('category', ['id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/category/categoryedit', $this->data);
    }
    public function categorysave() {
        // echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        if ($id == "") {
            $getCategory = $this->master_db->getRecords('category',['cname'=>$cname],'*');
            if(count($getCategory) >0) {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Category already exists</div>');
                 redirect(base_url() . 'master/categoryadd');
            }else {
                    $db['cname'] = $cname;
                    if (!empty($_FILES['image']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/category/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $config['max_width'] = 295;
                        $config['max_height'] = 672;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                            redirect(base_url() . 'master/categoryadd');
                        } else {
                            $upload_data = $this->upload->data();
                            $db['image'] = 'assets/category/' . $upload_data['file_name'];
                        }
                    }
                    if (!empty($_FILES['adimage']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/category/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $ext = pathinfo($_FILES["adimage"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $config['max_width'] = 295;
                        $config['max_height'] = 672;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('adimage')) {
                            $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                            redirect(base_url() . 'master/categoryadd');
                        } else {
                            $upload_data = $this->upload->data();
                            $db['ads_image'] = 'assets/category/' . $upload_data['file_name'];
                        }
                    }
                    $db['page_url'] = $this->master_db->create_unique_slug($cname,'category','page_url');
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('category', $db);
                    if ($in > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        redirect(base_url() . 'master/category');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                        redirect(base_url() . 'master/categoryadd');
                    }
            }
        } else {
            $ids = $this->input->post('cid');
            //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
            $getCategory = $this->master_db->getRecords('category',['cname'=>$cname],'*');
            // if(count($getCategory) >0) {
            //     $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Category already exists</div>');
            //             redirect(base_url() . 'master/category');
            // }else {
                $db['cname'] = $cname;
                if (!empty($_FILES['image']['name'])) {
                    //unlink("$images");
                    $uploadPath = '../assets/category/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                        redirect(base_url() . 'master/editcategory');
                    } else {
                        $upload_data1 = $this->upload->data();
                        $db['image'] = 'assets/category/' . $upload_data1['file_name'];
                    }
                }
                 if (!empty($_FILES['adimage']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/category/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $ext = pathinfo($_FILES["adimage"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('adimage')) {
                            $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                            redirect(base_url() . 'master/categoryadd');
                        } else {
                            $upload_data = $this->upload->data();
                            $db['ads_image'] = 'assets/category/' . $upload_data['file_name'];
                        }
                    }
                $db['page_url'] = $this->master_db->create_unique_slug($cname,'category','page_url');
                $db['modified_at'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('category', $db, ['id' => $id]);
                if ($update > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    redirect(base_url() . 'master/category');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                    redirect(base_url() . 'master/category');
                }   
            //}
        }
    }
    public function setcategoryStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('category', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status ==3) {
            $where_data = array('showcategory' => 0);
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status ==4) {
            $where_data = array('showcategory' => 1);
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /* Brand  */
    public function brand() {
        $this->load->view('masters/brand/brand', $this->data);
    }
    public function getbrandlist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
            $where.= " or (brand_img like '%$val%') ";
        }
        $order_by_arr[] = "name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from brand " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            if (!empty($r->brand_img)) {
                $image.= "<img src='" . app_url() . $r->brand_img . "'  style='width:80px'/>";
            }
            $action = '<a href=' . base_url() . "master/editbrand/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = ucfirst($r->name);
            $sub_array[] = $r->id;
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function brandadd() {
        $this->load->view('masters/brand/brandadd', $this->data);
    }
    public function editbrand() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['category'] = $this->master_db->getRecords('brand', ['id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/brand/brandedit', $this->data);
    }
    public function brandsave() {
        // echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        $getBrand = $this->master_db->getRecords('brand',['name'=>$cname],'*');
        if(count($getBrand) >0) {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Brand already exists try another</div>');
                    redirect(base_url() . 'master/brand');
        }else {
                    if ($id == "") {
                $db['name'] = $cname;
                if (!empty($_FILES['image']['name'])) {
                    //unlink("$images");
                    $uploadPath = '../assets/brand/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                    $config['max_width'] = 206;
                    $config['max_height'] = 93;
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                        redirect(base_url() . 'master/brandadd');
                    } else {
                        $upload_data = $this->upload->data();
                        $db['brand_img'] = 'assets/brand/' . $upload_data['file_name'];
                    }
                }
                $db['created_at'] = date('Y-m-d H:i:s');
                $in = $this->master_db->insertRecord('brand', $db);
                if ($in > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                    redirect(base_url() . 'master/brand');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                    redirect(base_url() . 'master/brand');
                }
            } else {
                $ids = $this->input->post('cid');
                //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
                $db['name'] = $cname;
                if (!empty($_FILES['image']['name'])) {
                    //unlink("$images");
                    $uploadPath = '../assets/brand/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                    $config['max_width'] = 206;
                    $config['max_height'] = 93;
                    $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                    $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                        redirect(base_url() . 'master/editbrand');
                    } else {
                        $upload_data1 = $this->upload->data();
                        $db['brand_img'] = 'assets/brand/' . $upload_data1['file_name'];
                    }
                }
                $db['modified_at'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('brand', $db, ['id' => $id]);
                if ($update > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    redirect(base_url() . 'master/brand');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                    redirect(base_url() . 'master/brand');
                }
            }
        }
        
    }
    public function setbrandStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('brand', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('brand', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('brand', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /* Subcategory  */
    public function subcategory() {
        $this->load->view('masters/subcategory/subcategory', $this->data);
    }
    public function getsubcategorylist() {
        $where = "where s.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (s.sname like '%$val%') ";
            $where.= " or (s.sub_img like '%$val%') ";
            $where.= " or (c.cname like '%$val%') ";
        }
        $order_by_arr[] = "s.sname";
        $order_by_arr[] = "";
        $order_by_arr[] = "s.id";
        $order_by_def = " order by s.id desc";
        $query = "select s.id,s.cat_id,s.sname,s.sub_img,s.created_at,s.status,c.cname from subcategory s left join category c on c.id = s.cat_id " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            if (!empty($r->sub_img)) {
                $image.= "<img src='" . app_url() . $r->sub_img . "'  style='width:80px'/>";
            }
            $action = '<a href=' . base_url() . "master/editsubcategory/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            // $sub_array[] = $image;
            $sub_array[] = $r->cname;
            $sub_array[] = ucfirst($r->sname);
            $sub_array[] = $r->id;
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function subcategoryadd() {
        $this->data['category'] = $this->master_db->getRecords('category', ['status' => 0], 'id,cname');
        $this->load->view('masters/subcategory/subcategoryadd', $this->data);
    }
    public function editsubcategory() {
        $this->data['category'] = $this->master_db->getRecords('category', ['status' => 0], 'id,cname');
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['subcategory'] = $this->master_db->getRecords('subcategory', ['id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/subcategory/subcategoryedit', $this->data);
    }
    public function subcategorysave() {
        //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        $cat_id = trim(html_escape($this->input->post('sid', true)));
        $getSubcategory = $this->master_db->getRecords('subcategory',['sname'=>$cname],'*');
        $getCategory = $this->master_db->getRecords('category',['id'=>$cat_id],'page_url');
        if(count($getSubcategory) >0) {
             $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Subcategory already exists try another</div>');
                redirect(base_url() . 'subcategory');
        }else {
              if (empty($id) && $id == "") {
                        $db['cat_id'] = $cat_id;
                        $db['sname'] = $cname;
                        if (!empty($_FILES['image']['name'])) {
                            //unlink("$images");
                            $uploadPath = '../assets/subcategory/';
                            $config['upload_path'] = $uploadPath;
                            $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                            $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                            $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                            $config['file_name'] = $new_name;
                            $config['max_width'] = 300;
                            $config['max_height'] = 300;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('image')) {
                                $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                                redirect(base_url() . 'subcategoryadd');
                            } else {
                                $upload_data = $this->upload->data();
                                $db['sub_img'] = 'assets/subcategory/' . $upload_data['file_name'];
                            }
                        }
                        $db['page_url'] = $getCategory[0]->page_url."-".$this->master_db->create_unique_slug($cname,'subcategory','page_url');
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('subcategory', $db);
                        if ($in > 0) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                            redirect(base_url() . 'subcategory');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                            redirect(base_url() . 'subcategoryadd');
                        }
                    } else if (!empty($id) && $id != "") {
                        //echo "updated";exit;
                        $ids = $this->input->post('cid');
                        //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
                        $db['cat_id'] = $cat_id;
                        $db['sname'] = $cname;
                        if (!empty($_FILES['image']['name'])) {
                            //unlink("$images");
                            $uploadPath = '../assets/subcategory/';
                            $config['upload_path'] = $uploadPath;
                            $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                            $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                            $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                            $config['file_name'] = $new_name;
                            $config['max_width'] = 300;
                            $config['max_height'] = 300;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('image')) {
                                $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                                redirect(base_url() . 'master/editsubcategory');
                            } else {
                                $upload_data1 = $this->upload->data();
                                $db['sub_img'] = 'assets/subcategory/' . $upload_data1['file_name'];
                            }
                        }
                        $db['page_url'] = $getCategory[0]->page_url."-".$this->master_db->create_unique_slug($cname,'subcategory','page_url');
                        $db['modified_at'] = date('Y-m-d H:i:s');
                        $update = $this->master_db->updateRecord('subcategory', $db, ['id' => $id]);
                        if ($update > 0) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                            redirect(base_url() . 'subcategory');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                            redirect(base_url() . 'master/editsubcategory');
                        }
                    }
        }
    
    }
    public function setsubcategoryStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('subcategory', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('subcategory', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('subcategory', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /* Sub Subcategory  */
    public function subsubcategory() {
        $this->load->view('masters/subsubcategory/subsubcategory', $this->data);
    }
    public function getsubsubcategorylist() {
        $where = "where ss.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (ss.ssname like '%$val%') ";
            $where.= " or (ss.subsub_img like '%$val%') ";
            $where.= " or (s.sname like '%$val%') ";
        }
        $order_by_arr[] = "ss.sname";
        $order_by_arr[] = "";
        $order_by_arr[] = "ss.id";
        $order_by_def = " order by ss.id desc";
        $query = "select ss.id,ss.sub_id,ss.ssname,ss.subsub_img,ss.created_at,ss.status,s.sname from subsubcategory ss  left join subcategory s on s.id = ss.sub_id " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            if (!empty($r->subsub_img)) {
                $image.= "<img src='" . app_url() . $r->subsub_img . "'  style='width:80px'/>";
            }
            $action = '<a href=' . base_url() . "master/editsubsubcategory/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            // $sub_array[] = $image;
            $sub_array[] = $r->sname;
            $sub_array[] = ucfirst($r->ssname);
            $sub_array[] = $r->id;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function subsubcategoryadd() {
        $this->data['category'] = $this->master_db->getRecords('subcategory', ['status' => 0], 'id,sname as cname');
        $this->load->view('masters/subsubcategory/subsubcategoryadd', $this->data);
    }
    public function editsubsubcategory() {
        $this->data['category'] = $this->master_db->getRecords('subcategory', ['status' => 0], 'id,sname as cname');
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['subcategory'] = $this->master_db->getRecords('subsubcategory', ['id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/subsubcategory/subsubcategoryedit', $this->data);
    }
    public function subsubcategorysave() {
        //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        $cat_id = trim(html_escape($this->input->post('sid', true)));
        $getSubcategory = $this->master_db->getRecords('subcategory',['id'=>$cat_id],'page_url');
        $getsubSubcategory = $this->master_db->getRecords('subsubcategory',['ssname'=>$cname],'*');
        if(count($getsubSubcategory) >0) {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Subsubcategory already exists try another</div>');
                        redirect(base_url() . 'subsubcategory');
        }else {
                    if (empty($id) && $id == "") {
                    $db['sub_id'] = $cat_id;
                    $db['ssname'] = $cname;
                    if (!empty($_FILES['image']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/subsubcategory/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config['max_width'] = 300;
                        $config['max_height'] = 300;
                        $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                            redirect(base_url() . 'subcategoryadd');
                        } else {
                            $upload_data = $this->upload->data();
                            $db['subsub_img'] = 'assets/subsubcategory/' . $upload_data['file_name'];
                        }
                    }
                    $db['page_url'] = $getSubcategory[0]->page_url."-".$this->master_db->create_unique_slug($cname,'subsubcategory','page_url');
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('subsubcategory', $db);
                    if ($in > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        redirect(base_url() . 'subsubcategory');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                        redirect(base_url() . 'subsubcategoryadd');
                    }
                } else if (!empty($id) && $id != "") {
                    //echo "updated";exit;
                    $ids = $this->input->post('cid');
                    //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
                    $db['sub_id'] = $cat_id;
                    $db['ssname'] = $cname;
                    if (!empty($_FILES['image']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/subsubcategory/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config['max_width'] = 300;
                        $config['max_height'] = 300;
                        $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                            redirect(base_url() . 'master/editsubsubcategory');
                        } else {
                            $upload_data1 = $this->upload->data();
                            $db['subsub_img'] = 'assets/subsubcategory/' . $upload_data1['file_name'];
                        }
                    }
                    $db['page_url'] = $getSubcategory[0]->page_url."-".$this->master_db->create_unique_slug($cname,'subsubcategory','page_url');
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('subsubcategory', $db, ['id' => $id]);
                    if ($update > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        redirect(base_url() . 'subsubcategory');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                        redirect(base_url() . 'master/editsubsubcategory');
                    }
                }
        }
    }
    public function setsubsubcategoryStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('subsubcategory', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('subsubcategory', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('subsubcategory', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /****** Register **********/
    public function register() {
        //echo "<pre>";print_r($_POST);exit;
        $type = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('type', true))));
        $title = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('title', true))));
        $price = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('price', true))));
        $vmonths = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('vmonths', true))));
        $noftype = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('noftype', true))));
        $noofpics = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('noofpics', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        if (!empty($id)) {
            $db['type'] = $type;
            $db['title'] = $title;
            $db['pprice'] = $price;
            $db['nmonths'] = $vmonths;
            $db['nproperties'] = $noftype;
            $db['npictures'] = $noofpics;
            $db['modified_date'] = date('Y-m-d H:i:s');
            $update = $this->master_db->updateRecord('packages', $db, ['id' => $id]);
            if ($update) {
                $results = ['status' => true, 'msg' => 'Updated successfully'];
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                echo json_encode($results);
            } else {
                $results = ['status' => false, 'msg' => 'Error in updating '];
                echo json_encode($results);
            }
        } else {
            if (!empty($type) && !empty($title) && !empty($price) && !empty($vmonths) && !empty($noftype)) {
                $db['type'] = $type;
                $db['title'] = $title;
                $db['pprice'] = $price;
                $db['nmonths'] = $vmonths;
                $db['nproperties'] = $noftype;
                $db['npictures'] = $noofpics;
                $db['status'] = 0;
                $db['created_date'] = date('Y-m-d H:i:s');
                $in = $this->master_db->insertRecord('packages', $db);
                if ($in) {
                    $result = ['status' => true, 'msg' => 'Inserted successfully'];
                    echo json_encode($result);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                } else {
                    $result = ['status' => false, 'msg' => 'Error in inserting '];
                }
            } else {
                $result = ['status' => false, 'msg' => 'Required fields are missing'];
                echo json_encode($result);
            }
        }
    }
    /* Ads  */
    public function ads() {
        $this->load->view('masters/ads/ads', $this->data);
    }
    public function getAds() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (ad_name like '%$val%') ";
            $where.= " or (ad_link like '%$val%') ";
        }
        $order_by_arr[] = "ad_name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from ads " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            if (!empty($r->ad_banner)) {
                $image.= "<img src='" . app_url() . $r->ad_banner . "'  style='width:80px'/>";
            }
            $action = '<a href=' . base_url() . "master/editads/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $image;
            $sub_array[] = ucfirst($r->ad_name);
            $sub_array[] = $r->ad_link;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function adsadd() {
        $this->load->view('masters/ads/adsadd', $this->data);
    }
    public function editads() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['ads'] = $this->master_db->getRecords('ads', ['id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/ads/adsedit', $this->data);
    }
    public function adssave() {
        // echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        $adlink = trim(html_escape($this->input->post('adlink', true)));
        $this->form_validation->set_rules('cname','Ads Name','regex_match[/^([A-Za-z0-9% ])+$/i]|max_length[50]',['regex_match'=>'Only characters, numbers and percentage are allowed','max_length'=>'Maximum 50 characters are allowed']);
        $this->form_validation->set_rules('adlink','Ad Link','valid_url',['valid_url'=>'Enter valid url']);
        if($id =="") {
            if(empty($_FILES['image']['name'][0])) {
                $this->form_validation->set_rules('image','Ads Image ','required',['required'=>'Please upload ads image']);       
            }
        }
        if($this->form_validation->run() ==TRUE) {
                 if ($id == "") {
                    if (!empty($_FILES['image']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/ads/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config['max_width'] = 610;
                        $config['max_height'] = 200;
                        $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                            
                             $resul = array(
                             'status'   => false,
                            'msg' =>"<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>",
                            'csrf_token'=> $this->security->get_csrf_hash()
                            );
                        } else {
                            $upload_data = $this->upload->data();
                            $db['ad_banner'] = 'assets/ads/' . $upload_data['file_name'];
                        }
                    }
                    $db['ad_name'] = $cname;
                    $db['ad_link'] = $adlink;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('ads', $db);
                    if ($in > 0) {
                       
                        $resul = array(
                             'status'   => true,
                            'msg' =>"Inserted successfully",
                            'csrf_token'=> $this->security->get_csrf_hash()
                            );
                    } else {
                        $resul = array(
                             'status'   => false,
                            'msg' =>"Error in inserting",
                            'csrf_token'=> $this->security->get_csrf_hash()
                            );
                    }
                } else {
                    $ids = $this->input->post('cid');
                    //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
                    if (!empty($_FILES['image']['name'])) {
                        //unlink("$images");
                        $uploadPath = '../assets/ads/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config['max_width'] = 610;
                        $config['max_height'] = 200;
                        $ext = pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('image')) {
                          $resul = array(
                             'status'   => false,
                            'msg' =>"<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>",
                            'csrf_token'=> $this->security->get_csrf_hash()
                            );
                        } else {
                            $upload_data1 = $this->upload->data();
                            $db['ad_banner'] = 'assets/ads/' . $upload_data1['file_name'];
                        }
                    }
                    $db['ad_name'] = $cname;
                    $db['ad_link'] = $adlink;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('ads', $db, ['id' => $id]);
                    if ($update > 0) {
                         $resul = array(
                         'status'   => true,
                        'msg' =>"Updated successfully",
                        'csrf_token'=> $this->security->get_csrf_hash()
                        );
                    } else {
                        $resul = array(
                         'status'   => false,
                        'msg' =>"Error in updating",
                        'csrf_token'=> $this->security->get_csrf_hash()
                        );
                    }
                }
        }else {
                 $resul = array(
                     'formerror'   => false,
                    'ads_error' => form_error('cname'),
                    'link_error' => form_error('adlink'),
                    'image_error' => form_error('image'),
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
        }
        echo json_encode($resul);
       
    }
    public function setadsStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('ads', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('ads', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('ads', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function users() {
        $this->load->view('users', $this->data);
    }
    public function getuserlist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
            $where.= " or (email like '%$val%') ";
            $where.= " or (phone like '%$val%') ";
            $where.= " or (address like '%$val%') ";
        }
        $order_by_arr[] = "b=name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from users " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $id = $r->id;
            $getpid = "";
            $getPayid = $this->master_db->getRecords('payment_log', ['user_id' => $id], 'pay_id');
            if (count($getPayid) > 0) {
                $getpid.= $getPayid[0]->pay_id;
            }
            $action = "";
            $sub_array = array();
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btns' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btns' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $terms = "";
            if ($r->terms == 1) {
                $terms.= "Agreed";
            }
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->name;
            $sub_array[] = $r->email;
            $sub_array[] = $r->phone;
            $sub_array[] = $r->address;
            $sub_array[] = $terms;
            $sub_array[] = $getpid;
            $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> " . date('d M y', strtotime($r->created_at)) . "<br/>" . "<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> " . date('h:i:s A', strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function setusersStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'));
        $this->master_db->updateRecord('users', $where_data, array('id' => $id));
        echo json_encode(['status' => 1, "csrf_token" => $this->security->get_csrf_hash() ]);
    }
    public function getuserreviews() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
            $where.= " or (email like '%$val%') ";
            $where.= " or (phone like '%$val%') ";
            $where.= " or (address like '%$val%') ";
        }
        $order_by_arr[] = "b=name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from users " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btns' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btns' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->name;
            $sub_array[] = $r->email;
            $sub_array[] = $r->phone;
            $sub_array[] = $r->address;
            $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> " . date('d M y', strtotime($r->created_at)) . "<br/>" . "<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> " . date('h:i:s A', strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    /****** States ******/
    public function states() {
        $this->load->view('masters/states/states', $this->data);
    }
    public function getStates() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
        }
        $order_by_arr[] = "name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from states " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editstates?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = ucfirst($r->name);
            $sub_array[] = $r->id;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function stateadd() {
        $this->load->view('masters/states/statesadd', $this->data);
    }
    public function savestates() {
        //echo "<pre>";print_r($_POST);exit;
        $title = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('title', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $getState = $this->master_db->getRecords('states',['name'=>$title],'*');
        if(count($getState) >0) {
                  $results = ['status' => false, 'msg' => 'State already exists try another ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
        }else {
                if (!empty($id)) {
                $db['name'] = $title;
                $db['modified_date'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('states', $db, ['id' => $id]);
                if ($update) {
                    $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    echo json_encode($results);
                } else {
                    $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
                }
            } else {
                if (!empty($title)) {
                    $db['name'] = $title;
                    $db['status'] = 0;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('states', $db);
                    if ($in) {
                        $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                    } else {
                        $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    }
                } else {
                    $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($result);
                }
            }  
        }
    }
    public function setstatesStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('states', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('states', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('states', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function editstates() {
        $this->load->library('encrypt');
        $id = icchaDcrypt($_GET['id']);
        //echo $id;exit;
        $getStates = $this->master_db->getRecords('states', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['property'] = $getStates;
        $this->load->view('masters/states/statesadd', $this->data);
    }
    /****** City ******/
    public function city() {
        $this->load->view('masters/city/cities', $this->data);
    }
    public function getcity() {
        $where = "where c.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (c.cname like '%$val%') ";
            $where.= " or (s.name like '%$val%') ";
            $where.= " or (c.created_at like '%$val%') ";
        }
        $order_by_arr[] = "c.name";
        $order_by_arr[] = "";
        $order_by_arr[] = "c.id";
        $order_by_def = " order by c.id desc";
        $query = "select c.id,c.cname,s.name as sname,c.created_at,c.status,c.noofdays from cities c left join states s on s.id = c.sid  " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editcity?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->cname;
            $sub_array[] = $r->noofdays;
            $sub_array[] = $r->sname;
            $sub_array[] = $r->id;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function cityadd() {
        $getStates = $this->master_db->getRecords('states', ['status' => 0], 'id,name', 'name asc');
        $this->data['states'] = $getStates;
        $this->load->view('masters/city/cityadd', $this->data);
    }
    public function setcityStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('cities', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('cities', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('cities', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function savecity() {
        //echo "<pre>";print_r($_POST);exit;
        $state = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('state', true))));
        $city = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('city', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $noofdays = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('noofdays', true))));
        $getCity = $this->master_db->getRecords('cities',['cname'=>$city],'*');
        if(count($getCity) >0) {
            $results = ['status' => false, 'msg' => 'City already exists try another', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
        }else {
                    if (!empty($id)) {
                $db['sid'] = $state;
                $db['cname'] = $city;
                $db['noofdays'] = $noofdays;
                $db['modified_date'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('cities', $db, ['id' => $id]);
                if ($update) {
                    $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    echo json_encode($results);
                } else {
                    $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
                }
            } else {
                if (!empty($city)) {
                    $db['sid'] = $state;
                    $db['cname'] = $city;
                    $db['noofdays'] = $noofdays;
                    $db['status'] = 0;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('cities', $db);
                    if ($in) {
                        $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                    } else {
                        $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    }
                } else {
                    $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($result);
                }
            }
        }
        
    }
    public function editcity() {
        $id = icchaDcrypt($_GET['id']);
        $getStates = $this->master_db->getRecords('states', ['status' => 0], 'id,name', 'name asc');
        $this->data['states'] = $getStates;
        //echo $id;exit;
        $cities = $this->master_db->getRecords('cities', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['city'] = $cities;
        $this->load->view('masters/city/cityadd', $this->data);
    }
    /****** Sliders ******/
    public function sliders() {
        $this->load->view('masters/sliders/slider', $this->data);
    }
    public function getslider() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (image like '%$val%') ";
            $where.= " or (created_at like '%$val%') ";
        }
        $order_by_arr[] = "image";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select id,image, created_at,status from slider_img   " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editslider?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $image = "";
            if (!empty($r->image)) {
                $image.= "<img src='" . app_url() . $r->image . "' style='width:100px'/>";
            }
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $image;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function slideradd() {
        $getStates = $this->master_db->getRecords('states', ['status' => 0], 'id,name', 'name asc');
        $this->data['states'] = $getStates;
        $this->load->view('masters/sliders/slideradd', $this->data);
    }
    public function setsliderStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('slider_img', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('slider_img', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('slider_img', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function saveslider() {
        // echo "<pre>";print_r($_FILES);print_r($_POST);exit;
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $stitle = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('stitle', true))));
        $stagline = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('stagline', true))));
        $link = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('link', true))));
        if (!empty($id)) {
            if (!empty($_FILES['sfile']['name'])) {
                $uploadPath = '../assets/sliders/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|png|PNG|JPEG';
                $config['max_width'] = 1903;
                $config['max_height'] = 520;
                $ext = pathinfo($_FILES["sfile"]['name'], PATHINFO_EXTENSION);
                $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('sfile')) {
                    $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                    redirect('slideradd');
                } else {
                    $upload_data = $this->upload->data();
                    $db['image'] = 'assets/sliders/' . $upload_data['file_name'];
                }
            }
            $db['stitle'] = $stitle;
            $db['stagline'] = $stagline;
            $db['sliderlink'] = $link;
            $db['modified_date'] = date('Y-m-d H:i:s');
            $update = $this->master_db->updateRecord('slider_img', $db, ['id' => $id]);
            if ($update > 0) {
                $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
            } else {
                $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                echo json_encode($results);
            }
        } else {
            if (!empty($_FILES['sfile']['name'])) {
                $uploadPath = '../assets/sliders/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|png|PNG|JPEG';
                $config['max_width'] = 1903;
                $config['max_height'] = 520;
                $ext = pathinfo($_FILES["sfile"]['name'], PATHINFO_EXTENSION);
                $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('sfile')) {
                    $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                    redirect(base_url() . 'bannersadd');
                } else {
                    $upload_data = $this->upload->data();
                    $db['image'] = 'assets/sliders/' . $upload_data['file_name'];
                }
            }
            $db['stitle'] = $stitle;
            $db['stagline'] = $stagline;
            $db['sliderlink'] = $link;
            $db['created_at'] = date('Y-m-d H:i:s');
            $in = $this->master_db->insertRecord('slider_img', $db);
            if ($in) {
                $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                echo json_encode($result);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
            } else {
                $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
            }
        }
        redirect(base_url() . 'banners');
    }
    public function editslider() {
        $id = icchaDcrypt($_GET['id']);
        //echo $id;exit;
        $cities = $this->master_db->getRecords('slider_img', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['city'] = $cities;
        $this->load->view('masters/sliders/slideradd', $this->data);
    }
    /****** Area ******/
    public function area() {
        $this->load->view('masters/area/area', $this->data);
    }
    public function getarea() {
        $where = "where a.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (c.cname like '%$val%') ";
            $where.= " or (a.areaname like '%$val%') ";
            $where.= " or (a.created_at like '%$val%') ";
        }
        $order_by_arr[] = "a.areaname";
        $order_by_arr[] = "";
        $order_by_arr[] = "a.id";
        $order_by_def = " order by a.id desc";
        $query = "select a.areaname,a.created_at,a.status,c.cname,a.id from area a left join  cities c on c.id = a.cid  " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editarea?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->cname;
            $sub_array[] = $r->areaname;
            $sub_array[] = $r->id;
            //$sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function areaadd() {
        $getcities = $this->master_db->getRecords('cities', ['status' => 0], 'id,cname', 'cname asc');
        $this->data['cities'] = $getcities;
        $this->data['type'] = "add";
        $this->load->view('masters/area/areaadd', $this->data);
    }
    public function setareaStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('area', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('area', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('area', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function savearea() {
        //echo "<pre>";print_r($_POST);exit;
        $city = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('city', true))));
        $area = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('area', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $getArea = $this->master_db->getRecords('area',['areaname'=>$area],'*');
        if(count($getArea) >0) {
                $results = ['status' => false, 'msg' => 'Area already exists try another', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($results);
        }else {
                     if (!empty($id)) {
                    $db['cid'] = $city;
                    $db['areaname'] = $area;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('area', $db, ['id' => $id]);
                    if ($update) {
                        $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        echo json_encode($results);
                    } else {
                        $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($results);
                    }
                } else {
                    if (!empty($city)) {
                        $db['cid'] = $city;
                        $db['areaname'] = $area;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('area', $db);
                        if ($in) {
                            $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                            echo json_encode($result);
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        } else {
                            $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        }
                    } else {
                        $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                    }
                }  
        }
       
    }
    public function editarea() {
        $id = icchaDcrypt($_GET['id']);
        //echo $id;exit;
        $cities = $this->master_db->getRecords('cities', ['status' => 0], '*');
        $area = $this->master_db->getRecords('area', ['id' => $id], 'id,areaname,cid');
        //echo $this->db->last_query();exit;
        $this->data['cities'] = $cities;
        $this->data['type'] = "edit";
        $this->data['area'] = $area;
        $this->load->view('masters/area/areaadd', $this->data);
    }
    /*** Testimonials *******/
    public function testimonials() {
        $this->load->view('masters/testimonials/testimonials', $this->data);
    }
    public function testimonialsadd() {
        $this->load->view('masters/testimonials/testimonialsadd', $this->data);
    }
    public function testimonialssave() {
        // echo "<pre>";print_r($_POST);exit;
        $name = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('name', true))));
        $location = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('location', true))));
        $msg = trim($this->input->post('msg'));
        $id = $this->input->post('id');
        if (!empty($id)) {
            $getTestimonials = $this->master_db->getRecords('testimonials', ['id' => $id], 'image');
            $images = app_url() . $getTestimonials[0]->image;
            $db['name'] = $name;
            $db['location'] = $location;
            if (!empty($_FILES['file']['name'])) {
                //unlink("$images");
                $uploadPath = '../assets/testimonials/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|png|PNG|JPEG';
                $ext = pathinfo($_FILES["file"]['name'], PATHINFO_EXTENSION);
                $new_name = "sqft9" . rand(11111, 99999) . '.' . $ext;
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('file')) {
                    $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                    redirect('property/myproperty');
                } else {
                    $upload_data = $this->upload->data();
                    $db['image'] = 'assets/testimonials/' . $upload_data['file_name'];
                }
            }
            $db['tdesc'] = $msg;
            $db['modified_at'] = date('Y-m-d H:i:s');
            $update = $this->master_db->updateRecord('testimonials', $db, ['id' => $id]);
            if ($update) {
                $results = ['status' => true, 'msg' => 'Updated successfully'];
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
            }
        } else {
            if (!empty($name) && !empty($location)) {
                $db['name'] = $name;
                $db['location'] = $location;
                if (!empty($_FILES['file']['name'])) {
                    $uploadPath = '../assets/testimonials/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|PNG|JPEG';
                    $ext = pathinfo($_FILES["file"]['name'], PATHINFO_EXTENSION);
                    $new_name = "sqft9" . rand(11111, 99999) . '.' . $ext;
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('file')) {
                        $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                    } else {
                        $upload_data = $this->upload->data();
                        $db['image'] = 'assets/testimonials/' . $upload_data['file_name'];
                    }
                }
                $db['tdesc'] = $msg;
                $db['status'] = 0;
                $db['created_at'] = date('Y-m-d H:i:s');
                $in = $this->master_db->insertRecord('testimonials', $db);
                if ($in) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Required fields are missing</div>');
            }
        }
        redirect(base_url() . 'testimonials');
    }
    public function getTestimonials() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
            $where.= " or (location like '%$val%') ";
            $where.= " or (tdesc like '%$val%') ";
        }
        $order_by_arr[] = "name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from testimonials " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/edittestimonials?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            $image = "<img src='" . app_url() . $r->image . "' style='width:80px'/>";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $image;
            $sub_array[] = $r->name;
            $sub_array[] = $r->location;
            $sub_array[] = $r->tdesc;
            //$sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function edittestimonials() {
        $id = icchaDcrypt($_GET['id']);
        $this->data['category'] = $this->master_db->getRecords('testimonials', ['status !=' => - 1], 'id,name');
        //echo $id;exit;
        $getTestimonials = $this->master_db->getRecords('testimonials', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['testimonials'] = $getTestimonials;
        $this->load->view('masters/testimonials/testimonialsadd', $this->data);
    }
    public function settestimonialStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('testimonials', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('testimonials', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('testimonials', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /*** Pincodes *******/
    public function pincodes() {
        $this->load->view('masters/pincodes/pincodes', $this->data);
    }
    public function pincodeadd() {
        $this->data['city'] = $this->master_db->getRecords('cities', ['status' => 0], 'id,cname');
        $this->load->view('masters/pincodes/pincodesadd', $this->data);
    }
    public function getPincodes() {
        $where = "where p.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (p.pincode like '%$val%') ";
            $where.= " or (c.cname like '%$val%') ";
        }
        $order_by_arr[] = "p.name";
        $order_by_arr[] = "";
        $order_by_arr[] = "p.id";
        $order_by_def = " order by id desc";
        $query = "select p.id,p.pincode,p.amount,p.cid,p.created_at,p.status,c.cname from pincodes p left join cities c on c.id = p.cid " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editpincodes?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->pincode;
            $sub_array[] = ucfirst($r->cname);
             $sub_array[] = $r->amount;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function pincodesave() {
        //echo "<pre>";print_r($_POST);exit;
        $pincode = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('pincode', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $cid = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('cid', true))));
        $amount = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('amount', true))));
        $getPincode = $this->master_db->getRecords('pincodes',['pincode'=>$pincode],'*');
        // if(count($getPincode) >0) {
        //     $results = ['status' => false, 'msg' => 'Pincode already exists try another', 'csrf_token' => $this->security->get_csrf_hash() ];
        //                 echo json_encode($results);
        // }else {
                  if (!empty($id)) {
                    $db['cid'] = $cid;
                    $db['pincode'] = $pincode;
                    $db['amount'] = $amount;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('pincodes', $db, ['id' => $id]);
                    if ($update) {
                        $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        echo json_encode($results);
                    } else {
                        $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($results);
                    }
                } else {
                    if (!empty($pincode)) {
                        $db['cid'] = $cid;
                        $db['pincode'] = $pincode;
                        $db['amount'] = $amount;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('pincodes', $db);
                        if ($in) {
                            $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                            echo json_encode($result);
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        } else {
                            $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        }
                    } else {
                        $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                    }
                }
        //}
    }
    public function editpincodes() {
        $this->load->library('encrypt');
        $id = icchaDcrypt($_GET['id']);
        $this->data['city'] = $this->master_db->getRecords('cities', ['status' => 0], 'id,cname');
        //echo $id;exit;
        $getPackage = $this->master_db->getRecords('pincodes', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['pincodes'] = $getPackage;
        $this->load->view('masters/pincodes/pincodesadd', $this->data);
    }
    public function setpincodesStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('pincodes', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('pincodes', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('pincodes', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /****** FAQ ******/
    public function faq() {
        $this->load->view('masters/faq/faq', $this->data);
    }
    public function getFaq() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (title like '%$val%') ";
            $where.= " or (fdesc like '%$val%') ";
        }
        $order_by_arr[] = "title";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from faq " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/faqedit?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->title;
            $sub_array[] = $r->fdesc;
            //$sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function faqadd() {
        $this->load->view('masters/faq/faqadd', $this->data);
    }
    public function faqsave() {
        //echo "<pre>";print_r($_POST);exit;
        $title = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('title', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $content = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('content', true))));
        if (!empty($id)) {
            $db['title'] = $title;
            $db['fdesc'] = $content;
            $db['modified_at'] = date('Y-m-d H:i:s');
            $update = $this->master_db->updateRecord('faq', $db, ['id' => $id]);
            if ($update) {
                $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                echo json_encode($results);
            } else {
                $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                echo json_encode($results);
            }
        } else {
            if (!empty($title) && !empty($content)) {
                $db['title'] = $title;
                $db['fdesc'] = $content;
                $db['created_at'] = date('Y-m-d H:i:s');
                $in = $this->master_db->insertRecord('faq', $db);
                if ($in) {
                    $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($result);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                } else {
                    $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                }
            } else {
                $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                echo json_encode($result);
            }
        }
    }
    public function faqedit() {
        $id = icchaDcrypt($_GET['id']);
        //echo $id;exit;
        $getPackage = $this->master_db->getRecords('faq', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['faq'] = $getPackage;
        $this->load->view('masters/faq/faqadd', $this->data);
    }
    public function faqstatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('faq', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('faq', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('faq', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /****** colors ******/
    public function colors() {
        $this->load->view('masters/colors/colors', $this->data);
    }
    public function getColors() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
            $where.= " or (status like '%$val%') ";
        }
        $order_by_arr[] = "name";
        $order_by_arr[] = "";
        $order_by_arr[] = "co_id";
        $order_by_def = " order by co_id desc";
        $query = "select * from colors " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/colorsedit/" . icchaEncrypt($r->co_id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->co_id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->co_id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->co_id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->name;
            $sub_array[] = $r->co_id;
            //$sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function colorsadd() {
        $this->load->view('masters/colors/colorsadd', $this->data);
    }
    public function colorssave() {
        //  echo "<pre>";print_r($_POST);exit;
        $title = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('cname', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('cid', true))));
        $ccode = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('ccode', true))));
        $getColor = $this->master_db->getRecords('colors',['name'=>$title],'*');
        // if(count($getColor) >0) {
        //      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Color already exists try another</div>');
        //                 redirect(base_url() . 'colors');
        // }else {
                 if (!empty($id)) {
                    $db['name'] = $title;
                    $db['ccode'] = $ccode;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('colors', $db, ['co_id' => $id]);
                    if ($update > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        redirect(base_url() . 'colors');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                        redirect(base_url() . 'colorsedit');
                    }
                } else {
                    if (!empty($title)) {
                        $db['name'] = $title;
                        $db['ccode'] = $ccode;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('colors', $db);
                        if ($in > 0) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                            redirect(base_url() . 'colors');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                            redirect(base_url() . 'colorsadd');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Required fields is missing</div>');
                        redirect(base_url() . 'colorsadd');
                    }
                }
       // }
    }
    public function colorsedit() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $getPackage = $this->master_db->getRecords('colors', ['co_id' => $id], '*');
        $this->data['color'] = $getPackage;
        $this->load->view('masters/colors/colorsedit', $this->data);
    }
    public function colorsstatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('colors', ['co_id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('colors', $where_data, array('co_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('colors', $where_data, array('co_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /* Coupons  */
    public function coupons() {
        $this->load->view('masters/coupons/coupons', $this->data);
    }
    public function getCouponlist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (type like '%$val%') ";
            $where.= " or (title like '%$val%') ";
            $where.= " or (from_date like '%$val%') ";
            $where.= " or (to_date like '%$val%') ";
            $where.= " or (discount like '%$val%') ";
        }
        $order_by_arr[] = "title";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from vouchers " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $type = "";
            if ($r->type == 0) {
                $type .= "Flat Discount";
            }
            else if($r->type ==1) {
                $type .= "Percentage Discount";
            }
            $action = '<a href=' . base_url() . "master/editcoupon/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";


            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $type;
            $sub_array[] = ucfirst($r->title);
            $sub_array[] = date('d-m-Y',strtotime($r->from_date));
            $sub_array[] = date('d-m-Y',strtotime($r->to_date));
            $sub_array[] = $r->discount;
        
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function couponsadd() {
        $this->load->view('masters/coupons/couponsadd', $this->data);
    }
    public function editcoupon() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['coupons'] = $this->master_db->getRecords('vouchers', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->load->view('masters/coupons/couponsedit', $this->data);
    }
    public function couponsave() {
        //echo "<pre>";print_r($_POST);exit;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('type','Coupon','required',['required'=>'Coupon type is required']);
        $this->form_validation->set_rules('ccode','Coupon Code','required|regex_match[/^([A-Za-z0-9])+$/i]|max_length[10]',['required'=>'Coupon Code is required','regex_match'=>'Only characters and numbers are allowed and spaces are not allowed','max_length'=>'Only 10 digits are allowed']);
        $this->form_validation->set_rules('fdate','From date','required',['required'=>'From date is required']);
        $this->form_validation->set_rules('tdate','To Date','required',['required'=>'To date is required']);
        $this->form_validation->set_rules('discount','Product Title','required|numeric',['required'=>'Coupon discount is required','numberic'=>'Only numbers are allowed']);
         if($this->form_validation->run() ==TRUE) {
            $type = trim($this->input->post('type'));
            $cid = trim($this->input->post('cid'));
            $ccode = trim($this->input->post('ccode'));
            $fdate = date('Y-m-d', strtotime($this->input->post('fdate')));
            $tdate = date('Y-m-d', strtotime($this->input->post('tdate')));
            $discount = trim($this->input->post('discount'));
            if(!empty($cid)) {
                      $db = array(
                        'type'=>$type,
                        'title'=>$ccode,
                        'from_date'=>$fdate,
                        'to_date'=>$tdate,
                        'discount'=>$discount,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'status'=>'0',
                );
                $update = $this->master_db->updateRecord('vouchers',$db,['id'=>$cid]);
                  if($update >0) {
                        $resul = array('status'   => true, 'msg' =>'Updated successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }else {
                     $db = array(
                        'type'=>$type,
                        'title'=>$ccode,
                        'from_date'=>$fdate,
                        'to_date'=>$tdate,
                        'discount'=>$discount,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'status'=>'0',
                );
                $res=$this->master_db->insertRecord('vouchers',$db);
                if($res >0) {
                        $resul = array('status'   => true, 'msg' =>'Inserted successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }
           
         }else {
                $resul = array(
                     'formerror'   => false,
                    'type_error' => form_error('type'),
                    'ccode_error' => form_error('ccode'),
                    'fdate_error' => form_error('fdate'),
                    'tdate_error' => form_error('tdate'),
                    'dicount_error' => form_error('discount'),
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
         }
         echo json_encode($resul);
    }
    public function setcouponStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('vouchers', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('vouchers', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('vouchers', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /****** SIZES ******/
    public function sizes() {
        $this->load->view('masters/sizes/sizes', $this->data);
    }
    public function getSize() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (sname like '%$val%') ";
        }
        $order_by_arr[] = "sname";
        $order_by_arr[] = "";
        $order_by_arr[] = "s_id";
        $order_by_def = " order by s_id desc";
        $query = "select * from sizes " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/sizeedit/" . icchaEncrypt($r->s_id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->s_id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->s_id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->s_id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->sname;
            $sub_array[] = $r->s_id;
            //$sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function sizeadd() {
        $this->load->view('masters/sizes/sizesadd', $this->data);
    }
    public function sizesave() {
        //  echo "<pre>";print_r($_POST);exit;
        $title = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('cname', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('cid', true))));
        $getSize = $this->master_db->getRecords('sizes',['sname'=>$title],'*');
        //echo $this->db->last_query();exit;
        if(count($getSize) >0) {
           $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Size already exists try another</div>');
                        redirect(base_url() . 'sizes'); 
        }else {
                if (!empty($id)) {
                    $db['sname'] = $title;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('sizes', $db, ['s_id' => $id]);
                    if ($update > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        redirect(base_url() . 'sizes');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                        redirect(base_url() . 'sizeedit');
                    }
                } else {
                    if (!empty($title)) {
                        $db['sname'] = $title;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('sizes', $db);
                        if ($in > 0) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                            redirect(base_url() . 'sizes');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                            redirect(base_url() . 'sizesadd');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Required fields is missing</div>');
                        redirect(base_url() . 'sizesadd');
                    }
                }
        }
        
    }
    public function sizeedit() {
        //echo $this->uri->segment(3);exit;
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $getPackage = $this->master_db->getRecords('sizes', ['s_id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['sizes'] = $getPackage;
        $this->load->view('masters/sizes/sizesedit', $this->data);
    }
    public function sizetatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('sizes', ['s_id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('sizes', $where_data, array('s_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('sizes', $where_data, array('s_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    /**** About *******/
    public function about() {
        $this->data['about'] = $this->master_db->getRecords('aboutus', ['id' => 1], '*');
        $this->load->view('homepage/about', $this->data);
    }
    public function aboutussave() {
        $id = 1;
        $about = trim($this->input->post('content'));
        $db['adesc'] = $about;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('aboutus', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('aboutus');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('aboutus');
        }
    }
    /**** Terms *******/
    public function terms() {
        $this->data['terms'] = $this->master_db->getRecords('terms', ['id' => 1], '*');
        $this->load->view('homepage/terms-condition', $this->data);
    }
    public function termssave() {
        $id = 1;
        $about = trim($this->input->post('content'));
        $db['tdesc'] = $about;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('terms', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('terms');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('terms');
        }
    }
    /**** Privacy *******/
    public function privacy() {
        $this->data['privacy'] = $this->master_db->getRecords('privacypolicy', ['id' => 1], '*');
        $this->load->view('homepage/privacy-policy', $this->data);
    }
    public function privacysave() {
        $id = 1;
        $about = trim($this->input->post('content'));
        $db['pdesc'] = $about;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('privacypolicy', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('privacy');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('privacy');
        }
    }
    /**** Cancellation *******/
    public function cancellationpolicy() {
        $this->data['cancellation'] = $this->master_db->getRecords('cancellation', ['id' => 1], '*');
        $this->load->view('homepage/cancellation-policy', $this->data);
    }
    public function cancellationsave() {
        $id = 1;
        $about = trim($this->input->post('content'));
        $db['cdesc'] = $about;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('cancellation', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('cancellationpolicy');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('cancellationpolicy');
        }
    }
    /**** Shipping Policy *******/
    public function shippingpolicy() {
        $this->data['shippingpolicy'] = $this->master_db->getRecords('shippingpolicy', ['id' => 1], '*');
        $this->load->view('homepage/shipping-policy', $this->data);
    }
    public function shippingsave() {
        $id = 1;
        $about = trim($this->input->post('content'));
        $db['shippolicy'] = $about;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('shippingpolicy', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('shippingpolicy');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('shippingpolicy');
        }
    }
    /******** Return policy *******/
    public function returnpolicy() {
        $this->data['return'] = $this->master_db->getRecords('returnpolicy', ['id' => 1], '*');
        $this->load->view('homepage/return-policy', $this->data);
    }
    public function returnpolicysave() {
        $id = 1;
        $about = trim($this->input->post('content'));
        $db['rdesp'] = $about;
        $db['created_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('returnpolicy', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('master/returnpolicy');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('master/returnpolicy');
        }
    }
    /**** Brochure *******/
    public function brochure() {
        $this->data['brochure'] = $this->master_db->getRecords('brochure', ['id' => 1], '*');
        $this->load->view('homepage/brochure', $this->data);
    }
    public function brochuresave() {
        $id = 1;
        if (!empty($_FILES['file']['name'])) {
            //unlink("$images");
            $uploadPath = '../assets/brochure/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $this->session->set_flashdata("message", "<div class='alert alert-danger'>" . $this->upload->display_errors() . "</div>");
                redirect('brochure');
            } else {
                $upload_data = $this->upload->data();
                $db['pdf'] = 'assets/brochure/' . $upload_data['file_name'];
            }
        }
        $update = $this->master_db->updateRecord('brochure', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('brochure');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('brochure');
        }
    }
    /**** Contact us *******/
    public function contactus() {
        $this->data['contact'] = $this->master_db->getRecords('contactus', ['id' => 1], '*');
        $this->load->view('homepage/contact-us', $this->data);
    }
    public function contactsave() {
        $id = 1;
        $email = trim($this->input->post('email'));
        $phone = trim($this->input->post('phone'));
        $address = trim($this->input->post('address'));
        $db['email'] = $email;
        $db['phone'] = $phone;
        $db['address'] = $address;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $update = $this->master_db->updateRecord('contactus', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('contactus');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('contactus');
        }
    }
    /**** Social Links  *******/
    public function sociallinks() {
        $this->data['sociallinks'] = $this->master_db->getRecords('sociallinks', ['id' => 1], '*');
        $this->load->view('homepage/sociallinks', $this->data);
    }
    public function sociallinksave() {
        $id = 1;
        $facebook = trim($this->input->post('facebook'));
        $twitter = trim($this->input->post('twitter'));
        $linkedin = trim($this->input->post('linkedin'));
        $instagram = trim($this->input->post('instagram'));
        $youtube = trim($this->input->post('youtube'));
        $db['facebook'] = $facebook;
        $db['twitter'] = $twitter;
        $db['linkedin'] = $linkedin;
        $db['instagram'] = $instagram;
        $db['modified_at'] = date('Y-m-d H:i:s');
        $db['youtube'] = $youtube;
        $update = $this->master_db->updateRecord('sociallinks', $db, array('id' => $id));
        if ($update) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Updated successfully</div>');
            redirect('sociallinks');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error in updating</div>');
            redirect('sociallinks');
        }
    }
    /****** Newsletter *****/
    public function newsletter() {
        $this->load->view('homepage/newsletter', $this->data);
    }
    public function getNewletter() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (email like '%$val%') ";
        }
        $order_by_arr[] = "email";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from newsletter " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $r->email;
            $sub_array[] = date('d-m-Y', strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    /******* Products ***************/
    public function products() {
      $this->load->view('masters/products/products',$this->data);
    }
     public function productsadd() {
      $this->data['category'] = $this->master_db->getRecords('category',['status'=>0],'id,cname');
      $this->data['subcategory'] = $this->master_db->getRecords('subcategory',['status'=>0],'id,sname');
      $this->data['subsubcategory'] = $this->master_db->getRecords('subsubcategory',['status'=>0],'id,ssname');
      $this->data['brand'] = $this->master_db->getRecords('brand',['status'=>0],'id,name');
      $this->data['sizes'] = $this->master_db->getRecords('sizes',['status'=>0],'s_id as id,sname');
      $this->data['colors'] = $this->master_db->getRecords('colors',['status'=>0],'co_id as id,name');
      $this->load->view('masters/products/productsadd',$this->data);
    }
    public function getProducts() {
         $where = "where p.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (p.ptitle like '%$val%') ";
            $where.= " or (p.pcode like '%$val%') ";
            $where.= " or (ps.stock like '%$val%') ";
        }
        $order_by_arr[] = "p.ptitle";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by p.id desc";
        $query = "select c.cname,p.ptitle as title,p.newarrivals,p.bestselling,p.featured,p.featuredimg,p.id,p.pcode,p.status,pi.p_image as img,ps.stock from products p left join category c on p.cat_id = c.id  left join product_images pi on  p.id =pi.pid left join product_size ps on p.id =ps.pid  ".$where." group by ps.pid";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/productsedit/" . icchaEncrypt($r->id) . "" . '  class="btn btn-primary" title="Edit Details" style="margin-bottom:10px"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';$image ="";
            if(!empty($r->featuredimg)) {
                $image .="<img src='".app_url().$r->featuredimg."' style='width:80px' />";
            }
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' style='margin-bottom:10px'><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' style='margin-bottom:10px' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' style='margin-bottom:10px' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
             $action.= '<a href='.base_url()."master/productViewdetails/".icchaEncrypt($r->id)."".'  class="btn btn-success" style="margin-bottom:10px" title="View product details"><i class="fas fa-eye"></i></a>&nbsp;';
             if ((int)$r->newarrivals == 1) {
                $action.= "<button title='Show in new arrivals' style='margin-bottom:10px;padding-right: 12px;padding-left:12px;' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 3)' >N</button>&nbsp;";
             }else {
                $action.= "<button title='Dont show in new arrivals' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 4)' style='background:#e08e0b!important;color:#fff!important;border-color:#e08e0b!important;padding-right: 12px;padding-left:12px;'>N</button>&nbsp;";
             }
             if ((int)$r->bestselling == 1) {
                $action.= "<button title='Show in best seller' style='margin-bottom:10px;color:#000;padding-right: 12px;padding-left:12px;' class='btn btn-yellow' onclick='updateStatus(" . $r->id . ", 5)'>B</button>&nbsp;";
             }else {
                $action.= "<button title='Dont show in best seller' style='background:#772856!important;color:#fff!important;border-color:#772856!important;padding-right: 12px;padding-left:12px;' class='btn btn-yellow' onclick='updateStatus(" . $r->id . ", 6)'>B</button>&nbsp;";
             }

             if ((int)$r->featured == 1) {
                $action.= "<button title='Show in featured image' style='margin-bottom:10px;color:#000;padding-right: 12px;padding-left:12px;' class='btn btn-red' onclick='updateStatus(" . $r->id . ", 7)'>F</button>&nbsp;";
             }else {
                $action.= "<button title='Dont show in featured image' style='background:#8A4A0B!important;color:#fff!important;border-color:#8A4A0B!important;padding-right: 12px;padding-left:12px;' class='btn btn-yellow' onclick='updateStatus(" . $r->id . ", 8)'>F</button>&nbsp;";
             }
             
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $image;
            $sub_array[] = $r->title;
            $sub_array[] = $r->pcode;
            $sub_array[] = $r->stock;
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function productsedit() {
          $this->data['category'] = $this->master_db->getRecords('category',['status'=>0],'id,cname');
          $this->data['subcategory'] = $this->master_db->getRecords('subcategory',['status'=>0],'id,sname');
          $this->data['subsubcategory'] = $this->master_db->getRecords('subsubcategory',['status'=>0],'id,ssname');
          $this->data['brand'] = $this->master_db->getRecords('brand',['status'=>0],'id,name');
          $this->data['sizes'] = $this->master_db->getRecords('sizes',['status'=>0],'s_id as id,sname');
          $this->data['colors'] = $this->master_db->getRecords('colors',['status'=>0],'co_id as id,name');
          $id =  icchaDcrypt($this->uri->segment(3));
          $this->data['products'] = $this->master_db->getRecords('products',['id'=>$id],'*');
          $this->data['product_img'] = $this->master_db->getRecords('product_images',['pid'=>$id],'*');
          $this->data['product_size'] = $this->master_db->getRecords('product_size',['pid'=>$id],'*');
          $this->load->view('masters/products/productsedit',$this->data);
    }
    public function productseditdata() {
       //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
         $this->load->library('form_validation');
        $this->form_validation->set_rules('category','Category','required',['required'=>'Category is required']);
        $this->form_validation->set_rules('pdesc','Product Description','required',['required'=>'Product description is required']);
        $this->form_validation->set_rules('subcategory','Subcategory','required',['required'=>'Subcategory is required']);
        $this->form_validation->set_rules('ptitle','Product Title','required|regex_match[/^([a-z0-9 ])+$/i]|max_length[100]',['max_length'=>'Only 100 characters are allowed','regex_match'=>'Only characters are allowed','required'=>'Product title is required']);
        $this->form_validation->set_rules('pcode','Product Code','required|regex_match[/^([A-Za-z0-9 ])+$/i]|max_length[30]',['max_length'=>'Only 30 characters are allowed','regex_match'=>'Only characters and numbers are allowed','required'=>'Product code is required']);
        $this->form_validation->set_rules('sell[0]','Upload','required|numeric',['required'=>'Sellprice is required','numeric'=>'Only numbers are allowed']);
        $this->form_validation->set_rules('psize[0]','Upload','required',['required'=>'Please select size']);
        $this->form_validation->set_rules('ylink','Youtube ','valid_url',['valid_url'=>'Please enter valid url']);
        $this->form_validation->set_rules('discount','Discount ','numeric',['numeric'=>'Only numbers are allowed']);
        $this->form_validation->set_rules('tax','Tax ','numeric',['numeric'=>'Only numbers are allowed']);
        $this->form_validation->set_rules('mno','Modal Number','regex_match[/^([A-Za-z0-9])+$/i]|max_length[30]',['max_length'=>'Only 30 characters are allowed','regex_match'=>'Only characters and numbers are allowed and spaces not allowed']);
        $this->form_validation->set_rules('mtitle','Meta Title','regex_match[/^([A-Za-z0-9- ])+$/i]|max_length[60]',['max_length'=>'Only 60 characters are allowed','regex_match'=>'Only characters and numbers and hyphens are allowed']);
        $this->form_validation->set_rules('mdesc','Meta Description','regex_match[/^([A-Za-z0-9- ])+$/i]|max_length[160]',['max_length'=>'Only 160 characters are allowed','regex_match'=>'Only characters and numbers and hyphens are allowed']);
        $this->form_validation->set_rules('mkeywords','Meta Keywords','regex_match[/^([A-Za-z0-9, ])+$/i]|max_length[160]',['max_length'=>'Only 160 characters are allowed','regex_match'=>'Only characters and numbers and comma are allowed']);
        if($this->form_validation->run() ==TRUE) {
            $category = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('category', true))));
            $subcategory = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcategory', true))));
            $subsubcategory = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subsubcategory', true))));
            $brand = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('brand', true))));
            $ptitle = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ptitle', true))));
            $pcode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pcode', true))));
            $discount = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('discount', true))));
            $tax = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('tax', true))));
            $length = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('length', true))));
            $breadth = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('breadth', true))));
            $weight = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('weight', true))));
            $height = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('height', true))));
            $pcode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pcode', true))));
            $youtube = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ylink', true))));
            $mno = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('mno', true))));
            $pdesc = $this->input->post('pdesc');
            $pspec = $this->input->post('pspec');
            $psize = $this->input->post('psize');
            $colors = $this->input->post('colors');
            $sell = $this->input->post('sell');
            $stock = $this->input->post('stock');
            $mtitle = $this->input->post('mtitle');
            $mdesc = $this->input->post('mdesc');
            $mkeywords = $this->input->post('mkeywords');
            $pid = $this->input->post('pid');
            $sizeid = $this->input->post('sizeid');
            $imgid = $this->input->post('imgid');
            $cqa = $this->input->post('cqa');
            $sizeIds = [];$imageIds = [];
            $getSizes = $this->master_db->getRecords('product_size',['pid'=>$pid],'*');
            $getImages = $this->master_db->getRecords('product_images',['pid'=>$pid],'*');
            foreach ($getSizes as $size) {
                $sizeIds[] = $size->pro_size;
            }
            foreach ($getImages as $image) {
                $imageIds[] = $image->id;
            }
            $youtubeid = "";
            $uploaddir = '../assets/products/';
            $arry = array("PNG","jpg","png","JPEG","jpeg","JPG");
            if(!empty($youtube)) {
                $ex = explode("v=", $youtube);
                $youtubeid .= $ex[1];
            }
            if(!empty($category) && !empty($subcategory) && !empty($ptitle) && !empty($pcode)) {
                $update['cat_id'] = $category;
                $update['subcat_id'] = $subcategory;
                $update['sub_sub_id'] = $subsubcategory;
                $update['brand_id'] = $brand;
                $update['ptitle'] = $ptitle;
                $update['page_url'] =$this->master_db->create_unique_slug($ptitle,'products','page_url');
                $update['pcode'] = $pcode;
                $update['overview'] = $pdesc;
                $update['pspec'] = $pspec;
                $update['meta_title'] = $mtitle;
                $update['meta_keywords'] = $mkeywords;
                $update['meta_description'] = $mdesc;
                 if (!empty($_FILES['fimage']['name'])) {
                        $uploadPath = '../assets/products/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $ext = pathinfo($_FILES["fimage"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $config['max_width'] = 200;
                        $config['max_height'] = 240;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('fimage')) {
                            $array1 = ['status'=>false,'msg'=>"Featured Image : ".$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
                            echo json_encode($array1);exit;
                        } else {
                            $upload_data1 = $this->upload->data();
                            $update['featuredimg'] = 'assets/products/' . $upload_data1['file_name'];
                        }
                    }
                    $update['modalno'] = $mno;
                    if (!empty($_FILES['pbrochure']['name'])) {
                        $uploadPath = '../assets/products/';
                        $config12['upload_path'] = $uploadPath;
                        $config12['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config12['max_width'] = 1250;
                        $config12['max_height'] = 800;
                        $ext = pathinfo($_FILES["pbrochure"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config12['file_name'] = $new_name;
                        $this->load->library('upload', $config12);
                        $this->upload->initialize($config12);
                        if (!$this->upload->do_upload('pbrochure')) {
                            $array1 = ['status'=>false,'msg'=>"Product Brochure : ".$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
                            echo json_encode($array1);exit;
                        } else {
                            $upload_data1 = $this->upload->data();
                            $update['pbrochure'] = 'assets/products/' . $upload_data1['file_name'];
                        }
                    }
                    $update['cqa'] = $cqa;
                $update['tax'] = $tax;
                $update['youtubelink'] = $youtubeid;
                $update['discount'] = $discount;
                $update['modified_at'] = date('Y-m-d h:i:s');
                $update['length'] = $length;
                $update['weight'] = $weight;
                $update['breadth'] = $breadth;
                $update['height'] = $height;
                $products = $this->master_db->updateRecord('products',$update,['id'=>$pid]);
                if($products >0) {
                    if(count($sizeid) >0) {
                         foreach($sizeid as $key => $sis) {
                            if(in_array($sis, $sizeIds)) {
                                $db['pid'] = $pid;
                                $db['sid'] = $psize[$key];
                                $db['coid'] = $colors[$key];
                                $db['selling_price'] = $sell[$key];
                                $db['stock'] = $stock[$key];
                                if(!empty($_FILES['cfile']['name'][$key])) {
                                    $arrayImage2=$_FILES['cfile']['name'][$key];
                                    $arrayTemp1=$_FILES['cfile']['tmp_name'][$key];
                                    $dd1 = explode(".", $arrayImage2);
                                    $ext = end($dd1);
                                    if(in_array($ext,$arry)){
                                        $image_name='ICCHA'.rand(12345,99999).'.'.$ext;
                                        $uploadfile = '../assets/products/'.$image_name;
                                        $uploadfileTable1 = "assets/products/".$image_name;
                                        move_uploaded_file($arrayTemp1,$uploadfile);
                                        $db['coimg'] = $uploadfileTable1;
                                    }
                                }
                                $sizeimg = $this->master_db->updateRecord('product_size',$db,['pro_size'=>$sis]);
                            }else {
                                //echo "inserted";
                                $db['pid'] = $pid;
                                $db['sid'] = $psize[$key];
                                $db['coid'] = $colors[$key];
                                $db['selling_price'] = $sell[$key];
                                $db['stock'] = $stock[$key];
                                if(!empty($_FILES['cfile']['name'][$key])) {
                                    $arrayImage2=$_FILES['cfile']['name'][$key];
                                    $arrayTemp1=$_FILES['cfile']['tmp_name'][$key];
                                    $dd1 = explode(".", $arrayImage2);
                                    $ext = end($dd1);
                                    if(in_array($ext,$arry)){
                                        $image_name='ICCHA'.rand(12345,99999).'.'.$ext;
                                        $uploadfile = '../assets/products/'.$image_name;
                                        $uploadfileTable1 = "assets/products/".$image_name;
                                        move_uploaded_file($arrayTemp1,$uploadfile);
                                        $db['coimg'] = $uploadfileTable1;
                                    }
                                }
                                $sizeimg = $this->master_db->insertRecord('product_size',$db);
                            }
                        }
                    }
                    if(count($imgid) >0) {
                        foreach ($imgid as $i => $image) {
                            if(in_array($image, $imageIds)) {
                                 if(!empty($_FILES['pfile']['name'][$i])){  
                                            $_FILES['photo']['name'] = $_FILES['pfile']['name'][$i];  
                                            $_FILES['photo']['type'] = $_FILES['pfile']['type'][$i];  
                                            $_FILES['photo']['tmp_name'] = $_FILES['pfile']['tmp_name'][$i];  
                                            $_FILES['photo']['error'] = $_FILES['pfile']['error'][$i];  
                                            $_FILES['photo']['size'] = $_FILES['pfile']['size'][$i];  
                                            $config['upload_path'] = '../assets/products/';   
                                            $config['allowed_types'] = 'jpg|jpeg|png|JPEG|JPG';  
                                            $config['max_width'] = 800;
                                            $config['max_height'] = 900;
                                            $ext = pathinfo($_FILES["pfile"]['name'][$i], PATHINFO_EXTENSION);
                                            $new_name = "ICCHA".rand(11111,99999).'.'.$ext; 
                                            $config['file_name'] =  $new_name;
                                            $this->load->library('upload',$config);  
                                            $this->upload->initialize($config);  
                                            if(!$this->upload->do_upload('photo')){  
                                                $array1 = ['status'=>false,'msg'=>$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
                                                echo json_encode($array1);exit;
                                            }else {
                                                $uploadData = $this->upload->data();  
                                                $filename = 'assets/products/'.$uploadData['file_name'];
                                                $dbs['pid'] = $pid;
                                                $dbs['p_image'] = $filename;
                                                $this->master_db->updateRecord('product_images',$dbs,['id'=>$image]);
                                            }
                                         } 
                            }else {
                                       if(!empty($_FILES['pfile']['name'][$i])){  
                                            $_FILES['photos']['name'] = $_FILES['pfile']['name'][$i];  
                                            $_FILES['photos']['type'] = $_FILES['pfile']['type'][$i];  
                                            $_FILES['photos']['tmp_name'] = $_FILES['pfile']['tmp_name'][$i];  
                                            $_FILES['photos']['error'] = $_FILES['pfile']['error'][$i];  
                                            $_FILES['photos']['size'] = $_FILES['pfile']['size'][$i];  
                                            $config['upload_path'] = '../assets/products/';   
                                            $config['allowed_types'] = 'jpg|jpeg|png|JPEG|JPG';  
                                            $config['max_width'] = 800;
                                            $config['max_height'] = 900;
                                            $ext = pathinfo($_FILES["pfile"]['name'][$i], PATHINFO_EXTENSION);
                                            $new_name = "ICCHA".rand(11111,99999).'.'.$ext; 
                                            $config['file_name'] =  $new_name;
                                            $this->load->library('upload',$config);  
                                            $this->upload->initialize($config);  
                                            if(!$this->upload->do_upload('photos')){  
                                                $array1 = ['status'=>false,'msg'=>$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
                                                echo json_encode($array1);exit;
                                            }else {
                                                $uploadData = $this->upload->data();  
                                                $filename = 'assets/products/'.$uploadData['file_name'];
                                                $dbs['pid'] =$pid;
                                                $dbs['p_image'] = $filename;
                                                $this->master_db->insertRecord('product_images',$dbs);
                                            }
                                         }    
                            }
                        }
                    }
                    $array = ['status'=>true,'msg'=>'Updated successfully','csrf_token'=> $this->security->get_csrf_hash()];
                }else {
                    $array = ['status'=>false,'msg'=>'Error in inserting','csrf_token'=> $this->security->get_csrf_hash()];
                }
            }else {
                $array = ['status'=>false,'msg'=>'Required fields is missing','csrf_token'=> $this->security->get_csrf_hash()];
            }        }else {
          $array = array(
            'formerror'   => false,
            'cat_error' => form_error('category'),
            'sub_error' => form_error('subcategory'),
            'subsub_error' => form_error('subsubcategory'),
            'pro_error' => form_error('ptitle'),
            'pdesc_error' => form_error('pdesc'),
            'pcode_error' => form_error('pcode'),
            'sell_error' => form_error('sell[0]'),
            'size_error' => form_error('psize[0]'),
            'discount_error' => form_error('discount'),
            'tax_error' => form_error('tax'),
            'ylink_error' => form_error('ylink'),
            'mno_error' => form_error('mno'),
            'mtitle_error' => form_error('mtitle'),
            'mdesc_error' => form_error('mdesc'),
            'mkeywords_error' => form_error('mkeywords'),
            'csrf_token'=> $this->security->get_csrf_hash()
           );
        }
        echo json_encode($array);
    }
    public function deleteSizes() {
        $id = icchaDcrypt($this->input->post('id'));
        $del = $this->master_db->deleterecord('product_size',['pro_size'=>$id]);
         echo json_encode(['status'=>true]);
    }
    public function deleteImages() {
        $id = icchaDcrypt($this->input->post('id'));
        $del = $this->master_db->deleterecord('product_images',['id'=>$id]);
         echo json_encode(['status'=>true]);
    }
    public function productssave() {
      // echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $this->load->library('form_validation');
        if(empty($_FILES['pfile']['name'][0])) {
            $this->form_validation->set_rules('pfile[]','Upload','required',['required'=>'Product image is required']);
        }
        $this->form_validation->set_rules('category','Category','required',['required'=>'Category is required']);
        $this->form_validation->set_rules('pdesc','Product Description','required',['required'=>'Product description is required']);
        $this->form_validation->set_rules('subcategory','Subcategory','required',['required'=>'Subcategory is required']);
        $this->form_validation->set_rules('ptitle','Product Title','required|regex_match[/^([a-z0-9 ])+$/i]|max_length[100]',['max_length'=>'Only 100 characters are allowed','regex_match'=>'Only characters are allowed','required'=>'Product title is required']);
        $this->form_validation->set_rules('pcode','Product Code','required|regex_match[/^([A-Za-z0-9 ])+$/i]|max_length[30]',['max_length'=>'Only 30 characters are allowed','regex_match'=>'Only characters and numbers are allowed','required'=>'Product code is required']);
         $this->form_validation->set_rules('mno','Modal Number','regex_match[/^([A-Za-z0-9])+$/i]|max_length[30]',['max_length'=>'Only 30 characters are allowed','regex_match'=>'Only characters and numbers are allowed and spaces not allowed']);
        $this->form_validation->set_rules('sell[0]','Upload','required|numeric',['required'=>'Sellprice is required','numeric'=>'Only numbers are allowed']);
        $this->form_validation->set_rules('size[0]','Upload','required',['required'=>'Please select size']);
        $this->form_validation->set_rules('ylink','Youtube ','valid_url',['valid_url'=>'Please enter valid url']);
        $this->form_validation->set_rules('discount','Discount ','numberic',['numberic'=>'Only numbers are allowed']);
        $this->form_validation->set_rules('tax','Tax ','numberic',['numberic'=>'Only numbers are allowed']);
        $this->form_validation->set_rules('mtitle','Meta Title','regex_match[/^([A-Za-z0-9- ])+$/i]|max_length[60]',['max_length'=>'Only 60 characters are allowed','regex_match'=>'Only characters and numbers and hyphens are allowed']);
        $this->form_validation->set_rules('mdesc','Meta Description','regex_match[/^([A-Za-z0-9- ])+$/i]|max_length[160]',['max_length'=>'Only 160 characters are allowed','regex_match'=>'Only characters and numbers and hyphens are allowed']);
        $this->form_validation->set_rules('mkeywords','Meta Keywords','regex_match[/^([A-Za-z0-9, ])+$/i]|max_length[160]',['max_length'=>'Only 160 characters are allowed','regex_match'=>'Only characters and numbers and comma are allowed']);
         if(empty($_FILES['fimage']['name'][0])) {
            $this->form_validation->set_rules('fimage','Featured Image ','required',['required'=>'Please upload featured image']);       
        }
        if($this->form_validation->run() ==TRUE) {
            $category = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('category', true))));
            $subcategory = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subcategory', true))));
            $subsubcategory = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('subsubcategory', true))));
            $brand = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('brand', true))));
            $ptitle = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ptitle', true))));
            $pcode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pcode', true))));
            $discount = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('discount', true))));
            $tax = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('tax', true))));
            $length = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('length', true))));
            $breadth = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('breadth', true))));
            $weight = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('weight', true))));
            $height = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('height', true))));
            $pcode = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('pcode', true))));
            $youtube = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('ylink', true))));
            $mno = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('mno', true))));
            $pdesc = $this->input->post('pdesc');
            $pspec = $this->input->post('pspec');
            $size = $this->input->post('size');
            $colors = $this->input->post('colors');
            $sell = $this->input->post('sell');
            $stock = $this->input->post('stock');
            $mtitle = $this->input->post('mtitle');
            $mdesc = $this->input->post('mdesc');
            $mkeywords = $this->input->post('mkeywords');
            $cqa = $this->input->post('cqa');
            $youtubeid = "";
            $uploaddir = '../assets/products/';
            $arry = array("PNG","jpg","png","JPEG","jpeg","JPG");
            if(!empty($youtube)) {
                $ex = explode("v=", $youtube);
                $youtubeid .= $ex[1];
            }
            if(!empty($category) && !empty($subcategory) && !empty($ptitle) && !empty($pcode)) {
            	$getProducts = $this->master_db->getRecords('products',['ptitle'=>$ptitle],'*');
                $getPcode = $this->master_db->getRecords('products',['pcode'=>$pcode],'*');
                $getPmodal = $this->master_db->getRecords('products',['modalno'=>$mno],'*');
            	if(count($getProducts) >0) {
            		$array = ['status'=>false,'msg'=>'Product title already exists try another','csrf_token'=> $this->security->get_csrf_hash()];
            	}
                else if(count($getPcode) >0) {
                    $array = ['status'=>false,'msg'=>'Product code already exists try another','csrf_token'=> $this->security->get_csrf_hash()];
                }
                else if(count($getPmodal) >0) {
                    $array = ['status'=>false,'msg'=>'Product modal number already exists try another','csrf_token'=> $this->security->get_csrf_hash()];
                }
                else {
            		$insert['cat_id'] = $category;
	                $insert['subcat_id'] = $subcategory;
	                $insert['sub_sub_id'] = $subsubcategory;
	                $insert['brand_id'] = $brand;
	                $insert['ptitle'] = $ptitle;
	                $insert['page_url'] =$this->master_db->create_unique_slug($ptitle,'products','page_url');
	                $insert['pcode'] = $pcode;
	                $insert['overview'] = $pdesc;
	                $insert['pspec'] = $pspec;
	                $insert['meta_title'] = $mtitle;
	                $insert['meta_keywords'] = $mkeywords;
	                $insert['meta_description'] = $mdesc;
                    if (!empty($_FILES['fimage']['name'])) {
                        $uploadPath = '../assets/products/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config['max_width'] = 200;
                        $config['max_height'] = 240;
                        $ext = pathinfo($_FILES["fimage"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('fimage')) {
                            $array1 = ['status'=>false,'msg'=>"Featured Image : ".$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
                            echo json_encode($array1);exit;
                        } else {
                            $upload_data1 = $this->upload->data();
                            $insert['featuredimg'] = 'assets/products/' . $upload_data1['file_name'];
                        }
                    }
                    $insert['modalno'] = $mno;
                    if (!empty($_FILES['pbrochure']['name'])) {
                        $uploadPath = '../assets/products/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                        $config['max_width'] = 1250;
                        $config['max_height'] = 800;
                        $ext = pathinfo($_FILES["pbrochure"]['name'], PATHINFO_EXTENSION);
                        $new_name = "ICCHA" . rand(11111, 99999) . '.' . $ext;
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('pbrochure')) {
                            $array1 = ['status'=>false,'msg'=>"Product Brochure : ".$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
                            echo json_encode($array1);exit;
                        } else {
                            $upload_data1 = $this->upload->data();
                            $insert['pbrochure'] = 'assets/products/' . $upload_data1['file_name'];
                        }
                    }
                    $insert['cqa'] = $cqa;
	                $insert['tax'] = $tax;
	                $insert['youtubelink'] = $youtubeid;
	                $insert['discount'] = $discount;
	                $insert['created_at'] = date('Y-m-d h:i:s');
	                $insert['length'] = $length;
	                $insert['weight'] = $weight;
	                $insert['breadth'] = $breadth;
	                $insert['height'] = $height;
	                $products = $this->master_db->insertRecord('products',$insert);
	                if($products >0) {
	                    if(is_array($size)) {
	                        foreach ($size as $key => $si) {
	                            $db['pid'] = $products;
	                            $db['sid'] = $si;
	                            $db['coid'] = $colors[$key];
	                            $db['selling_price'] = $sell[$key];
	                            $db['stock'] = $stock[$key];
	                            if(!empty($_FILES['cfile']['name'][$key])) {
	                                $arrayImage2=$_FILES['cfile']['name'][$key];
	                                $arrayTemp1=$_FILES['cfile']['tmp_name'][$key];
	                                $dd1 = explode(".", $arrayImage2);
	                                $ext = end($dd1);
	                                if(in_array($ext,$arry)){
	                                    $image_name='ICCHA'.rand(12345,99999).'.'.$ext;
	                                    $uploadfile = '../assets/products/'.$image_name;
	                                    $uploadfileTable1 = "assets/products/".$image_name;
	                                    move_uploaded_file($arrayTemp1,$uploadfile);
	                                    $db['coimg'] = $uploadfileTable1;
	                                }
	                            }
	                            $sizeimg = $this->master_db->insertRecord('product_size',$db);
	                        }
	                    }
	                    if(count($_FILES['pfile']['name'])) {
	                        $count = count($_FILES['pfile']['name']);  
	                        for($i=0;$i<$count;$i++){  
	                          if(!empty($_FILES['pfile']['name'][$i])){  
	                            $_FILES['photo']['name'] = $_FILES['pfile']['name'][$i];  
	                            $_FILES['photo']['type'] = $_FILES['pfile']['type'][$i];  
	                            $_FILES['photo']['tmp_name'] = $_FILES['pfile']['tmp_name'][$i];  
	                            $_FILES['photo']['error'] = $_FILES['pfile']['error'][$i];  
	                            $_FILES['photo']['size'] = $_FILES['pfile']['size'][$i];  
	                            $config['upload_path'] = '../assets/products/';   
	                            $config['allowed_types'] = 'jpg|jpeg|png|JPEG|JPG';  
	                            $config['max_width'] = 800;
	                            $config['max_height'] = 900;
	                            $ext = pathinfo($_FILES["pfile"]['name'][$i], PATHINFO_EXTENSION);
	                            $new_name = "ICCHA".rand(11111,99999).'.'.$ext; 
	                            $config['file_name'] =  $new_name;
	                            $this->load->library('upload',$config);  
	                            $this->upload->initialize($config);  
	                            if(!$this->upload->do_upload('photo')){  
	                                $array1 = ['status'=>false,'msg'=>"Product Image :".$this->upload->display_errors(),'csrf_token'=> $this->security->get_csrf_hash()];
	                                echo json_encode($array1);exit;
	                            }else {
	                                $uploadData = $this->upload->data();  
	                                $filename = 'assets/products/'.$uploadData['file_name'];
	                                $dbs['pid'] = $products;
	                                $dbs['p_image'] = $filename;
	                                $this->master_db->insertRecord('product_images',$dbs);
	                            }
	                         }  
	                       }  
	                    }
	                    $array = ['status'=>true,'msg'=>'Product saved successfully','csrf_token'=> $this->security->get_csrf_hash()];
	                }else {
	                    $array = ['status'=>false,'msg'=>'Error in inserting','csrf_token'=> $this->security->get_csrf_hash()];
	                }
            	}
            }else {
                $array = ['status'=>false,'msg'=>'Required fields is missing','csrf_token'=> $this->security->get_csrf_hash()];
            }        }else {
          $array = array(
            'formerror'   => false,
            'cat_error' => form_error('category'),
            'sub_error' => form_error('subcategory'),
            'subsub_error' => form_error('subsubcategory'),
            'pro_error' => form_error('ptitle'),
            'pdesc_error' => form_error('pdesc'),
            'pcode_error' => form_error('pcode'),
            'pimage_error' => form_error('pfile[]'),
            'sell_error' => form_error('sell[0]'),
            'size_error' => form_error('size[0]'),
            'ylink_error' => form_error('ylink'),
            'mno_error' => form_error('mno'),
            'mtitle_error' => form_error('mtitle'),
            'mdesc_error' => form_error('mdesc'),
            'mkeywords_error' => form_error('mkeywords'),
            'discount_error' => form_error('discount'),
            'tax_error' => form_error('tax'),
            'pfeature_error' => form_error('fimage'),
            'csrf_token'=> $this->security->get_csrf_hash()
           );
        }
        echo json_encode($array);
    }
    public function setproductsStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('products', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == -1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status == 3) {
            $where_data = array('newarrivals' => 0);
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status == 4) {
            $where_data = array('newarrivals' => 1);
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
         else if ($status == 5) {
            $where_data = array('bestselling' => 0);
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status == 6) {
            $where_data = array('bestselling' => 1);
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status == 7) {
            $where_data = array('featured' => 0);
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status == 8) {
            $where_data = array('featured' => 1);
            $this->master_db->updateRecord('products', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function productViewdetails() {
        //echo "<pre>";print_r($_POST);exit;
        $id = icchaDcrypt($this->uri->segment(3));
        $query = "select p.id as pid,p.ptitle,p.pcode,p.overview,p.pspec,p.meta_title,p.meta_description,p.meta_keywords,p.tax,p.youtubelink,p.discount,p.length,p.weight,p.breadth,p.height,p.modalno,p.cqa,p.featuredimg,p.pbrochure,c.cname as catname,s.sname,ss.ssname,b.name as bname from products p left join category c on c.id =p.cat_id left join subcategory s on s.id = p.subcat_id left join subsubcategory ss on ss.id =p.sub_sub_id left join brand b on b.id= p.brand_id where p.id = ".$id.""; 
        $arr = $this->master_db->sqlExecute($query);
        $this->data['sizes'] = $this->master_db->sqlExecute('select ps.stock,ps.selling_price as price, ps.coimg,s.sname,co.name as coname from product_size ps left join sizes s on s.s_id = ps.sid left join colors co on co.co_id = ps.coid where ps.pid = '.$id.'');
        $this->data['images'] = $this->master_db->getRecords('product_images',['pid'=>$id],'*');
        $this->data['products'] = $arr;
        $this->load->view('productDetails',$this->data);
    }
    public function getSubcategoryview() {
      $id = trim($this->input->post('catid'));
      $getSubcat = $this->master_db->getRecords('subcategory',['cat_id'=>$id,'status'=>0],'id,sname');
      //echo $this->db->last_query();exit;
      $data ="";
      if(count($getSubcat)>0 ) {
        foreach ($getSubcat as $key => $value) {
            $data .="<option value=".$value->id.">".$value->sname."</option>";
        }
        $res = ['status'=>true,'msg'=>$data,'csrf_token'=> $this->security->get_csrf_hash()];
      }else {
        $res = ['status'=>false,'msg'=>'No data found','csrf_token'=> $this->security->get_csrf_hash()];
      }
      echo json_encode($res);
    }
    public function getSubsubcategoryview() {
      $id = trim($this->input->post('subid'));
      $getSubcat = $this->master_db->getRecords('subsubcategory',['sub_id'=>$id,'status'=>0],'id,ssname');
      //echo $this->db->last_query();exit;
      $data ="";
      if(count($getSubcat)>0 ) {
        foreach ($getSubcat as $key => $value) {
            $data .="<option value=".$value->id.">".$value->ssname."</option>";
        }
        $res = ['status'=>true,'msg'=>$data,'csrf_token'=> $this->security->get_csrf_hash()];
      }else {
        $res = ['status'=>false,'msg'=>'No data found','csrf_token'=> $this->security->get_csrf_hash()];
      }
      echo json_encode($res);
    }
    public function protitlevalidation() {
        //echo "<pre>";print_r($_POST);exit;
        $title = trim($this->input->post('title'));
        $getProducts = $this->master_db->getRecords('products',['ptitle'=>$title],'*');
        if(count($getProducts) >0) {
        	echo json_encode(['status'=>false,'msg'=>'Product title already exists try another','csrf_token'=> $this->security->get_csrf_hash()]);
        }else {
        	echo json_encode(['status'=>true,'csrf_token'=> $this->security->get_csrf_hash()]);
        }
    }
     public function procodevalidation() {
        //echo "<pre>";print_r($_POST);exit;
        $title = trim($this->input->post('title'));
        $getProducts = $this->master_db->getRecords('products',['pcode'=>$title],'*');
        if(count($getProducts) >0) {
        	echo json_encode(['status'=>false,'msg'=>'Product code already exists try another','csrf_token'=> $this->security->get_csrf_hash()]);
        }else {
        	echo json_encode(['status'=>true,'csrf_token'=> $this->security->get_csrf_hash()]);
        }
    }
    public function inventory() {
        $this->data['pcode'] = $this->master_db->getRecords('products',['status'=>0],'id,pcode','pcode asc');
        $this->data['getSize'] = $this->master_db->sqlExecute('select p.ptitle,p.pcode,ps.stock from products p left join product_size ps on p.id  = ps.pid where ps.stock <= 10');
        //echo $this->db->last_query();exit;
        $this->load->view('masters/inventory/inventory',$this->data);
    }
    public function inventoryUpdate() {
        //echo "<pre>";print_r($_POST);exit;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pcode','Pcode','required',['required'=>'Product code is required']);
         if($this->form_validation->run() ==TRUE) {
            $sizeid = $this->input->post('sizeid');
            $stock = $this->input->post('stock');
            if(is_array($sizeid) && !empty($sizeid)) {
                foreach ($sizeid as $key => $value) {
                    $db['stock'] = $stock[$key];
                    $getSize = $this->master_db->updateRecord('product_size',$db,['pro_size'=>$value]);
                }
               $resul = array(
                     'status'   => true,
                    'msg' => 'Updated successfully',
                    'csrf_token'=> $this->security->get_csrf_hash()
                ); 
            }else {
               $resul = array(
                     'status'   => false,
                    'msg' => 'No sizes found',
                    'csrf_token'=> $this->security->get_csrf_hash()
                );  
            }
         }else {
             $resul = array(
                     'formerror'   => false,
                    'pcode_error' => form_error('pcode'),
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
         }
         echo json_encode($resul);
    }
    public function getSizedata() {
       // echo "<pre>";print_r($_POST);exit;
        $pid = icchaDcrypt($this->input->post('pid'));
        $getSize = $this->master_db->sqlExecute('select ps.pro_size as id,s.sname,ps.stock from product_size ps left join sizes s on s.s_id  = ps.sid where ps.pid = '.$pid.'');
        if(count($getSize)>0) {
            $html = "";
            foreach ($getSize as $key => $value) {
                $html .="<input type='hidden' name='sizeid[]' value='".$value->id."' /><p style='float:left;margin-top: 32px;'>Sizes : ".$value->sname."</p><div class='form-group' style='float:left;width:80%;margin-left: 10px;'><label style='width:100%'>Inventory</label><input type='text' name='stock[]' value='".$value->stock."' class='form-control' style='width:90%'/></div>"; 
            }
            $result = ['status'=>true,'msg'=>$html,'csrf_token'=> $this->security->get_csrf_hash()];
        }else {
            $result = ['status'=>false,'msg'=>'No sizes found','csrf_token'=> $this->security->get_csrf_hash()];
        }
        echo json_encode($result);
    }
}
?>