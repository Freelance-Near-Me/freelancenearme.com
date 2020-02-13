<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

  /**
  ***    Add event
  */
    public function add_event($data) {
        $title = $data['title'];
		$description = $data['description'];
		unset($data['title']);
		unset($data['description']);
		$event_data = array(
			'image' => $data['image'],
			'event_slug' => $data['event_slug'],
            'event_image_alt_title' => $data['event_image_alt_title'],
			'meta_title' => $data['meta_title'],
			'meta_desc' => $data['meta_desc'],
			'meta_keys' => $data['meta_keys'],
			'created' => $data['created'],
			'status' => $data['status']
		);
		$this->db->insert('event', $event_data);
		$event_id = $this->db->insert_id();
			$title = array(
				'event_id' => $event_id,
				'title' => $title,
				'description' => $description,
				'lang' => 'en'
			);
			$this->db->insert('event_detail', $title);
		
        return true;
    }

    public function update_event($post) {
/*        $data = array(
            'state_name' => $post['state_name'],
            'order_id' => $post['order_id'],
            'country_id' => $post['country_id'],
            'status' => $post['status']);*/
        $this->db->where('event_id', $post['id']);
        return $this->db->update('event', $post);
    }

    
	public function record_count_event() 
	{
        return $this->db->count_all('event');
    }
	
	
	
	
    //// Delete state //////////////////////////////////
    public function delete_event($id) {
        return $this->db->delete('event', array('event_id' => $id));
    }

    /// Get Event list ////////////////////////////
    
    public function get_blog_list($limit='',$start='') {
        $this->db->select('event_id,created,status');
        $this->db->order_by("event_id", "desc");
		$this->db->limit($limit,$start);
        $rs = $this->db->get_where('event', array());
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'event_id' => $row->event_id,
				'created' => $row->created,
                'status' => $row->status			);
        }
        return $data;
    }
	
    /// Get Category list ////////////////////////////

    
	public function get_event_by_id($id)
	{
		$this->db->select('*');
		$rs = $this->db->get_where('event',array('event_id'=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data = array(
				'event_id' => $row->event_id,
				'event_slug' => $row->event_slug,
				'event_image_alt_title' => $row->event_image_alt_title,				
				'image' => $row->image,
				'meta_title' => $row->meta_title,				
				'meta_keys' => $row->meta_keys,				
				'meta_desc' => $row->meta_desc,
				'status' => $row->status
			);			
		}		
		return $data;
	}
    
    
	
	public function updateevent($data,$id)
	{		
		/* $this->db->where('event_id',$id);
		return $this->db->update('event',$data); */
		$title = array(
			'title' => $data['title']
		);
		$this->db->where(array('event_id'=>$id,'lang'=>'en'));
		$this->db->update('event_detail', $title);
		
		$description = array(
			'description' => $data['description']
		);
		$this->db->where(array('event_id'=>$id,'lang'=>'en'));
		$this->db->update('event_detail', $description);
			
		unset($data['title']);
		unset($data['description']);
			
		$this->db->where('event_id', $id);
        return $this->db->update('event', $data);
	}
        /////////Get Category ///////////
        
     public function getEventCategory()
	{
		$this->db->select('*');
		$this->db->order_by('cat_id','desc');
		$rs = $this->db->get_where('category',array('type'=>'E'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'cat_id' => $row->cat_id,
				'cat_name' => $row->cat_name,
				'type' => $row->type,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
        
	public function getAllCategory($type)
	{
		$this->db->select('*');
		$this->db->order_by('cat_id','desc');
		$rs = $this->db->get_where('category',array('type'=>$type));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'cat_id' => $row->cat_id,
				'cat_name' => $row->cat_name,
				'type' => $row->type,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	
	

}
