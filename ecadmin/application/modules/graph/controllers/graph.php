<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Graph extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('graph_model');
		$this->load->model('dashboard/user_model');
        parent::__construct();
    }
	

    public function index() {
       
	   redirect();
	   
    }
	
	public function view(){
		$type = get('type');
		$data['type'] = $type;
		
		$data['title'] = 'Graph';
		switch($type){
			case 'member_graph_chart' : 
			$data['title'] = 'Member Graph Chart';
			break;
			case 'project_graph_chart' : 
			$data['title'] = 'Project Graph Chart';
			break;
			case 'finance_graph_chart' : 
			$data['title'] = 'Financial Graph Chart';
			break;
		}
		
		if(!$type){
			show_404();
		}
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		
		$this->layout->view('graph', $lay, $data); 
	}
	
	
}
