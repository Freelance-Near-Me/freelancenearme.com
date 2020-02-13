<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class News extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('news_model');
        /* $this->load->model('user/user_model');
		$this->load->library("mailtemplete"); */
        $this->load->helper(array('form', 'url'));
        /* $this->load->library('form_validation'); */
		$this->load->library('user_agent');
		$this->load->library("pagination");
        parent::__construct();
		$idiom=$this->session->userdata('lang');
		$this->lang->load('news', $idiom);
    }

    public function index($limit_from = '') {
        //echo 'run';exit;

		$data = array();
		$breadcrumb=array(
                    array(
                            'title'=>__('news','Blog'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('news','Blog'));
		$config = array();
        $config["base_url"] = base_url() . "news/index";
        $config["total_rows"] = $this->news_model->get_record_event();
        $config["per_page"] = 6; 
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }
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
		
		/* $page_slug = 'blog';
		$page_id = $this->autoload_model->getFeild('page_id','banner_page','page_slug',$page_slug);
		if($this->agent->mobile()){
			$m='M';
		}else{
			$m='D';
		}
		$data['banner']=$this->user_model->getBanner($m,$page_id); */
	
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$data['event']=$this->news_model->getevent($config['per_page'], $start);
		//	echo 'run';exit;
		$this->layout->view('view_news',$lay,$data,'normal');
    }
	public function detail($id='',$is_slug=FALSE) {
		$data = array();
		if($is_slug){
			$id=$this->autoload_model->getFeild('event_id','event','event_slug',$id);
		}
		/*$page_slug = 'blog-details';
		$page_id = $this->autoload_model->getFeild('page_id','banner_page','page_slug',$page_slug);
		if($this->agent->mobile()){
			$m='M';
		}else{
			$m='D';
		}
		$data['banner']=$this->user_model->getBanner($m,$page_id);*/
				        		$breadcrumb=array(
                    array(
                            'title'=>__('news_details','Blog details'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('news_details','Blog details'));
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$lay['client_testimonial']="inc/footerclient_logo";
		$data['event']=$this->news_model->get_event_by_id($id);
		$data['comments'] = $this->news_model->getComments($id);
		$data['blog_id'] = $id;
		//print_r($data['event']);
		$title=$data['event']['meta_title'];
		$description=$data['event']['meta_desc'];
		$keywords=$data['event']['meta_keys'];
		$meta_all='<title>'.$title.'</title>
		<meta name="description" content="'.$description.'" />
		<meta name="keywords" content="'.$keywords.'" />
		<meta name="application-name" content="'.$title.'" />
		<meta property="og:title" content="'.$title.'" />
		<meta property="og:description" content="'.$description.'" />
		<meta name="twitter:card" content="'.$title.'">
		<meta name="twitter:title" content="'.$title.'">
		<meta name="twitter:description" content="'.$description.'">
		';
		$image=$data['event']['image'];
		if($image && file_exists(APATH.'assets/img/event/'.$image)){
		$meta_all.=	'<meta property="og:image" content="'.VPATH.'assets/img/event/'.$image.'" />
		<meta name="twitter:image" content="'.VPATH.'assets/img/event/'.$image.'">';
		}
        
        $data['meta_tag']=$meta_all;
		$this->layout->view('details',$lay,$data,'normal');
    }
	
	public function post_comment($event_id=''){
		$json = array();
		$json['status'] = 0;
		$user = $this->session->userdata('user');
		if($user){
			$user_id = $user[0]->user_id;
		}else{
			$user_id = 0;
		}
		if(post() && $this->input->is_ajax_request()){
			if(!$user_id){
				$this->form_validation->set_rules('name', 'name', 'required|max_length[100]');
				$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			}
			$this->form_validation->set_rules('comment', 'comment', 'required');
			if($this->form_validation->run()){
				$post = post();
				$post['datetime'] = date('Y-m-d H:i:s');
				$post['user_id']= $user_id;
				$this->db->insert('comments', $post);
				$comment_id = $this->db->insert_id();
				$this->db->insert('blog_comment', array('event_id' => $event_id, 'comment_id' => $comment_id));
				$json['status'] = 1;
				$json['data']['comment'] = $this->news_model->getCommentById($comment_id);
				
			}else{
				$json['errors'] = validation_errors_array();
			}
		}
		echo json_encode($json);
	}
	
	public function get_comment_ajax($comment_id=''){
		$blog_id = get('blog_id');
		$data['comments'] = $this->news_model->getComments($blog_id, $comment_id);
		$this->load->view('comment_ajax', $data);
	}
	
}
