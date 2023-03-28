<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_db extends CI_Model{
	public function getCartproducts($id) {
		$getPro = $this->db->select('p.id as pid,p.ptitle,p.pcode,p.featuredimg as image,p.page_url,c.page_url as cpage_url,s.page_url as spage_url,ss.page_url as sspage_url,b.name as bname,p.discount,ps.selling_price as price,ps.stock,ps.sid,ps.coid,p.tax')
						   ->from('products p')
						   ->join('category c','c.id= p.cat_id','left')
						   ->join('subcategory s','s.id= p.subcat_id','left')
						   ->join('subsubcategory ss','ss.id= p.sub_sub_id','left')
						   ->join('product_size ps','ps.pid= p.id','left')
						   ->join('brand b','b.id= p.brand_id','left')
						   ->group_by('ps.pid')
						   ->order_by('p.id desc')
						   ->where(['p.id'=>$id])
						   ->get();
		return $getPro !== FALSE ? $getPro->result() : array();
	}
	function generateOrderNo($oid){
		$sql = "SELECT CONCAT(  'ICC', INSERT( LPAD( oid, 5,  '0' ) , 0, 3,  'ICCH' ) ) AS OrderNo FROM orders WHERE oid=$oid";
		$q=$this->db->query($sql);
		if($q->num_rows()>0){
			$res = $q->result();
			return $res[0]->OrderNo;
		}
		else
			return 'GGARBHA000001';
	}
}