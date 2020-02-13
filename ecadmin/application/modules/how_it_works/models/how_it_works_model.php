<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  How_it_works_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllhow_it_worksList()
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get('how_it_works');
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'id' => $row->id,
				'title' => $row->title,
				'description' => $row->description,
				'icon_class'=>$row->icon_class,
				'status' => $row->status
			);
		}
		return $data;
	}
	
	public function add($data)
	{
		return $this->db->insert('how_it_works',$data);
		//echo $this->db->last_query();die;
	}
	
	public function updatehow_it_works($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('how_it_works',$data);
	
	}
	

	
	public function deletehow_it_works($id)
	{
		return $this->db->delete('how_it_works', array('id' => $id)); 
	
	}
	public function getAllhow_it_worksListbyId($id)
	{
		$this->db->select('*');
		$rs = $this->db->get_where('how_it_works',array("id"=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'title' => $row->title,
				'description' => $row->description,
				'icon_class'=>$row->icon_class,
				'site_logo'=>$row->site_logo,
				'status' => $row->status
			);
			
		}
		
		return $data;
	}
	
	/* public function getallUser()
	{
		$this->db->select('*');
		$this->db->order_by('user_id','desc');
		$rs = $this->db->get_where('user',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'user_id' => $row->user_id,
				'name' => $row->fname." ".$row->lname
			);
			
		}
		return $data;
	} */

}
