<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_db extends CI_Model{

	    public function rows_by_paginations($query,$order_by,$order_by_arr,$db="default")
    {
        $this->load->database($db);

        if(isset($_POST["order"]))
        {
            $order_by = " order by ".$order_by_arr[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'];
        }
        
        $limit = " ";
        if($_POST["length"] != -1)
        {
            $limit = " limit {$_POST['length']}";
            if($_POST['start'] > 0){
                $limit = " limit {$_POST['start']}, {$_POST['length']}";
            }
        }
        $query = $this->db->query($query.$order_by.$limit);
        
        return $query->result();
    }   
  
    public function run_manual_query_result($query,$db="default")
    {
        $this->load->database($db);
        $query = $this->db->query($query);
        return $query->result();
    }
    
        public function create_unique_slug($string,$table,$field,$key=NULL,$value=NULL)
    {
        $t =& get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;
    
        if($key)$params["$key !="] = $value;
    
        while ($t->db->where($params)->get($table)->num_rows())
        {
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
             
            $params [$field] = $slug;
        }
        return $slug;
    }
	    function getlogin($username){
        //try {
        //$username = $this->db->escape($db['username']);
        $wdb = array("username"=>$username);
        $this->db->select("id, username,password")
                 ->from('admin')
                 ->where($wdb);
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }
    
    public function getPopularproducts() {
        $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,ps.stock,p.page_url,c.page_url as cpage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('category c','c.id = p.cat_id')
                               ->group_by('ps.pid')
                               ->order_by('p.id desc')
                               ->where(['p.newarrivals'=>0,'p.status'=>0])
                               ->limit(10)
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
    }
    public function getBestproducts() {
        $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,ps.stock,p.page_url,c.page_url as cpage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('category c','c.id = p.cat_id')
                               ->group_by('ps.pid')
                               ->order_by('p.id desc')
                               ->where(['p.bestselling'=>0,'p.status'=>0])
                               ->limit(10)
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
    }
    public function getFeatureproducts() {
        $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,ps.stock,p.page_url,c.page_url as cpage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('category c','c.id = p.cat_id')
                               ->group_by('ps.pid')
                               ->order_by('p.id desc')
                               ->where(['p.featured'=>0,'p.status'=>0])
                               ->limit(10)
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
    }
    public function getCategorywiseproducts($catid,$order,$limit) {
        $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,ps.stock,p.page_url,c.ads_image,c.page_url as cpage_url,c.cname')
                               ->from('products p')
                               ->join('category c','c.id = p.cat_id')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->group_by('ps.pid')
                               ->where(['p.cat_id'=>$catid,'p.status'=>0])
                               ->order_by('p.id '.$order.'')
                                ->limit($limit)
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
    }
    public function getProducts($id='',$subid ='',$limit='',$offset='') {
      if(!empty($id)) {
         $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,p.page_url,s.page_url as spage_url,p.page_url,ss.page_url as sspage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('subcategory s','s.id = p.subcat_id','left')
                               ->join('subsubcategory ss','ss.id = p.sub_sub_id','left')
                               ->join('brand b','b.id = p.brand_id','left')
                               ->group_by('ps.pid,p.ptitle')
                               ->order_by('p.id desc')
                               ->where(['p.subcat_id'=>$id,'p.status'=>0])
                               ->limit($limit,$offset)
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
      }else if(!empty($subid)) {
        $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,p.page_url,s.page_url as spage_url,p.page_url,ss.page_url as sspage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('subcategory s','s.id = p.subcat_id','left')
                               ->join('subsubcategory ss','ss.id = p.sub_sub_id','left')
                               ->join('brand b','b.id = p.brand_id','left')
                               ->group_by('ps.pid')
                               ->order_by('p.id desc')
                               ->where(['p.sub_sub_id'=>$subid,'p.status'=>0])
                               ->limit($limit,$offset)
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
      }
    }
       public function getProductcount($id='',$sid='')
  {
  if(!empty($id)) {
         $q = $this->db->select('p.id as pid')
                               ->from('products p')
                               ->order_by('p.id desc')
                               ->where(['p.subcat_id'=>$id,'p.status'=>0])
                               ->get();
                                       return $q->num_rows();

      }else if(!empty($subid)) {
        $q = $this->db->select('p.id as pid')
                               ->from('products p')
                               ->order_by('p.id desc')
                               ->where(['p.sub_sub_id'=>$sid,'p.status'=>0])
                               ->get();
                                       return $q->num_rows();

      }

  }
  public function getProductsize($id='',$sid='') {
    if(!empty($id)) {
       $getSubid = $this->db->select('co.name as coname,co.co_id as cid,s.s_id as sid,s.sname')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('colors co','co.co_id = ps.coid','left')
                               ->join('sizes s','s.s_id = ps.sid','left')
                               // ->join('brand b','b.id = p.brand_id','left')
                               ->group_by('co.name,s.sname')
                               ->order_by('p.id desc')
                               ->where(['p.subcat_id'=>$id,'p.status'=>0])
                               ->get();
        return $getSubid !== FALSE ? $getSubid->result() : array();
    }else if(!empty($sid)) {
       $getSubid = $this->db->select('co.name as coname,co.co_id as cid,s.s_id as sid,s.sname')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('colors co','co.co_id = ps.coid','left')
                               ->join('sizes s','s.s_id = ps.sid','left')
                               ->group_by('co.name,s.sname')
                               ->order_by('p.id desc')
                               ->where(['p.sub_sub_id'=>$sid,'p.status'=>0])
                               ->get();
        return $getSubid !== FALSE ? $getSubid->result() : array();
    }
  }
  public function getProductviewpage($page_url) {
     $getPopular = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,p.page_url,c.cname,s.sname,ss.ssname,b.name as bname,p.pcode,p.overview as pdesc,p.pspec,p.meta_title as mtitle,p.meta_keywords as mkeywords,p.meta_description as mdesc,p.modalno,p.pbrochure,p.cqa,p.tax,p.youtubelink,p.discount,p.brand_id,p.cat_id,p.subcat_id,ps.sid,ps.coid')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('category c','c.id = p.cat_id','left')
                               ->join('subcategory s','s.id = p.subcat_id','left')
                               ->join('subsubcategory ss','ss.id = p.sub_sub_id','left')
                               ->join('brand b','b.id = p.brand_id','left')
                               ->group_by('ps.pid,p.ptitle')
                               ->order_by('p.id desc')
                               ->where(['p.page_url'=>$page_url,'p.status'=>0])
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
  }
  public function getRelatedprod($pid,$subid='') {
    $getRelated = $this->db->select('p.id as pid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,p.page_url,s.page_url as spage_url,p.page_url,ss.page_url as sspage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('subcategory s','s.id = p.subcat_id','left')
                               ->join('subsubcategory ss','ss.id = p.sub_sub_id','left')
                               ->join('brand b','b.id = p.brand_id','left')
                               ->group_by('ps.pid,p.ptitle')
                               ->order_by('p.id desc')
                               ->where(['p.id !='=>$pid,'p.subcat_id'=>$subid,'p.status'=>0])
                               ->get();
        return $getRelated !== FALSE ? $getRelated->result() : array();
  }
  public function viewWishlist($uid) {
    $getPopular = $this->db->select('p.id as pid,w.id as wid,p.featuredimg as image,p.ptitle as title,ps.selling_price as price,ps.stock,p.page_url,p.page_url as ppage_url')
                               ->from('products p')
                               ->join('product_size ps','p.id = ps.pid','left')
                               ->join('category c','c.id = p.cat_id')
                               ->join('wishlist w','w.pid = p.id')
                               ->group_by('ps.pid')
                               ->order_by('p.id desc')
                               ->where(['w.uid'=>$uid,'p.status'=>0])
                               ->get();
        return $getPopular !== FALSE ? $getPopular->result() : array();
  }

  function getratings($id){
    $sql = "select avg(rating) as avgrat from reviews where pid=".$id." and status=0 group by pid";
    $q = $this->db->query($sql);
    if($q->num_rows()>0)
    {
      $res = $q->result();
      return $res[0]->avgrat;
    }
    else
    {
      return '0';
    }
  }
}