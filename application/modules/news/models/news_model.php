<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function getevent($limit = '', $start = '')
	{
	   return $this->db->select('*')->from('event')->where('status','Y')->order_by('event_id','desc')->limit($limit, $start)->get()->result_array();
	}
	
	public function get_record_event(){
		$this->db->where('status','Y');
		return $this->db->count_all_results('event');
	}
	public function get_event_by_id($id){
		return $this->db->select('*')->from('event')->where('event_id',$id)->get()->row_array();
	}
	
	public function getComments($event_id='', $parent=0){
		$this->db->select('c.*,u.fname,u.lname,u.logo,u.user_id')
			->from('comments c')
			->join('blog_comment b_c', 'b_c.comment_id=c.comment_id', 'INNER')
			->join('user u', 'u.user_id=c.user_id', 'LEFT');
		
		$this->db->where('b_c.event_id', $event_id);
		$this->db->where('c.parent_id', $parent);
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	public function getCommentById($id=''){
		$this->db->select('c.*,u.fname,u.lname,u.logo,u.user_id')
			->from('comments c')
			->join('blog_comment b_c', 'b_c.comment_id=c.comment_id', 'INNER')
			->join('user u', 'u.user_id=c.user_id', 'LEFT');
		
		$this->db->where('b_c.comment_id', $id);
		$result = $this->db->get()->row_array();
		if($result['logo']){
			$result['user_logo'] = ASSETS.'uploaded/'.$result['logo'];
		}else{
			$result['user_logo'] = null;
		}
		if($result['datetime']){
			$result['display_date'] = date('d M, Y', strtotime($result['datetime']));
		}
		return $result;
	}
}
