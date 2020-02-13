<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('event_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');		$this->load->library('editor');			$this->load->helper('ckeditor');
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'event/page');
    }
    
    

    /////////////// Event Add ///////////////////////////////////////////////
    public function add() {
    	
        $data['data'] = $this->auto_model->leftPannel();
        $lay['left'] = "inc/section_left";		$data['ckeditor'] = $this->editor->geteditor('description','Full');		
        if ($this->input->post()) {
			/* get_print($this->input->post()); */
            			$this->form_validation->set_rules('title', 'title', 'required');
            			 $post_data['event_slug'] = $this->input->post('event_slug');	
            			 $post_data['event_image_alt_title'] = $this->input->post('event_image_alt_title');		
            			
            			 $this->form_validation->set_rules('event_slug', 'blog url', 'required|trim|xss_clean|is_unique[event.event_slug]');
            			$this->form_validation->set_rules('description', 'description', 'required');	
						$this->form_validation->set_rules('meta_keys', 'meta_keys', 'required');	
						$this->form_validation->set_rules('meta_desc', 'meta_desc', 'required');
						$this->form_validation->set_rules('meta_title', 'meta_title', 'required');		
						$post_data['created'] = date('Y-m-d');	
						$post_data['title']  = $this->input->post('title');		
						$post_data['description'] = $this->input->post('description');	
						$post_data['meta_title'] = $this->input->post('meta_title');	
						$post_data['meta_keys'] = $this->input->post('meta_keys');	
						$post_data['meta_desc'] = $this->input->post('meta_desc');	
						$post_data['image'] = $this->input->post('blog_image');	
						$post_data['status'] = $this->input->post('status');		
						/* get_print($post_data); */			
						if ($this->form_validation->run() == FALSE){				
						//redirect(base_url() . 'event/add/');		
						$this->layout->view('add', $lay, $data);	
						} else {
                $insert_event = $this->event_model->add_event($post_data);
                if ($insert_event) {
                    $this->session->set_flashdata('succ_msg', 'Event Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert');
                }
                redirect(base_url() . 'event/');
            }
        } 
        else {
            $this->layout->view('add', $lay, $data);
          }
    }

    //////////////edit state menu////////////////////
   
    
    
    public function edit()
	{
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";		
		if($id)
		{
            $data['all_data'] =  $this->event_model->get_event_by_id($id);
		}	
		$data['ckeditor'] = $this->editor->geteditor('description','Full');
		if($this->input->post())
		{			
		/* get_print($this->input->post()); */
		
		$original_value=$data['all_data']['event_slug'];
		if($this->input->post('event_slug') != $original_value) {
		   $is_unique =  '|is_unique[event.event_slug]';
		} else {
		   $is_unique =  '';
		}
		$this->form_validation->set_rules('event_slug', 'blog url', 'required|trim|xss_clean'.$is_unique);	
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('meta_keys', 'meta_keys', 'required');			
		$this->form_validation->set_rules('meta_desc', 'meta_desc', 'required');			
		$this->form_validation->set_rules('meta_title', 'meta_title', 'required');
		/* $post_data['created'] = date('Y-m-d'); */	
		
		$post_data['event_slug'] = $this->input->post('event_slug');
        $post_data['event_image_alt_title'] = $this->input->post('event_image_alt_title');
            		
		$post_data['title']  = $this->input->post('title');			
		$post_data['description'] = $this->input->post('description');
		$post_data['event_id'] = $id;			
		$post_data['meta_title'] = $this->input->post('meta_title');			
		$post_data['meta_keys'] = $this->input->post('meta_keys');			
		$post_data['meta_desc'] = $this->input->post('meta_desc');			
		$post_data['image'] = $this->input->post('blog_image');				
		$post_data['status'] = $this->input->post('status');			
		/* get_print($post_data); */
		if ($this->form_validation->run() == FALSE){		
		$this->layout->view('edit', $lay, $data);		
			//redirect(base_url() . 'event/edit/'.$id);			
		} else {
		$update = $this->event_model->updateevent($post_data,$id);
		if ($update) {
		$this->session->set_flashdata('succ_msg', 'Event Updated Successfully');
		} else {
		$this->session->set_flashdata('error_msg', 'Unable to Update ');
		}			}
			redirect(base_url() . 'event/edit/'.$id);
		}		
		$this->layout->view('edit', $lay, $data);		
	}	
        ///// Delete menu //////////////////////////////////
    public function delete_event() {
        $id = $this->uri->segment(3);
        $delete = $this->event_model->delete_event($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Event Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete');
        }
        redirect(base_url() . 'event/page');
    }
	public function upload_file2(){
		if($_FILES){
			$res = array();	
			$config['upload_path']          = '../assets/img/event/';
			$config['allowed_types']        = 'jpg|jpeg|png';
			$config['encrypt_name']        = TRUE;
			/* $config['max_width'] = 440;
			$config['max_height'] = 280; */
			
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file')){
				$res['result'] = 0;
				$res['error'] = $this->upload->display_errors();
			}else{
				$file_name = $this->upload->data();
				$res['result'] = 1;
				$res['file_name'] = $file_name['file_name'];
				$res['org_file_name'] = $file_name['orig_name'];
				
				$image = $file_name['file_name'];
				$configs['image_library'] = 'gd2';
				$configs['source_image']	= '../assets/img/event/'.$image;
				$configs['create_thumb'] = TRUE;
				/* $configs['maintain_ratio'] = TRUE; */
				$configs['width']	= 640;
				$configs['height']	= 480;
				$this->load->library('image_lib', $configs); 
				$rsz=$this->image_lib->resize();
				if(!$rsz){
					$res['result'] = 0;
					$res['error'] = $this->upload->display_errors();
				}
				$cmd = post('cmd');
			}
			echo json_encode($res);
		}
	}	
    public function page($limit_from = '') {
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "event/page";
        $config["total_rows"] = $this->event_model->record_count_event();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        // $config['page_query_string'] = TRUE;
        //$config['display_pages'] = TRUE;
        $this->pagination->initialize($config);

        // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }
        $data['data'] = $this->auto_model->leftPannel();
		$config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
        //$data($config['per_page'])=3;
        $data['list'] = $this->event_model->get_blog_list($config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }

    public function change_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->event_model->updateevent($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        redirect(base_url() . 'event/page');
    }

}
