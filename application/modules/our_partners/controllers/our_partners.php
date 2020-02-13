<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Our_partners extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('our_partners_model');
		$this->load->library("mailtemplete");
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        parent::__construct();
    }

    public function index() {
		$breadcrumb=array(
							array(
								'title'=>'Our Partners','path'=>''
							)
						);
			$data = array();
			
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Our Partners');
			$head['current_page']='our_partners';
			$head['ad_page']='success_tips';
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$this->layout->set_assest($head);
			$this->autoload_model->getsitemetasetting("meta","pagename","our_partners");
			$lay['client_testimonial']="inc/footerclient_logo";
			
			$page_name = 'our_partners';
			$title = $this->auto_model->getFeild('meta_title','content','pagename',$page_name);
			$meta_desc = $this->auto_model->getFeild('meta_desc','content','pagename',$page_name);
			$meta_keys = $this->auto_model->getFeild('meta_keys','content','pagename',$page_name);
			$meta_all='<title>'.$title.'</title>
			<meta name="description" content="'.$meta_desc.'" />
			<meta name="keywords" content="'.$meta_keys.'" />
			<meta name="application-name" content="'.$title.'" />
			';
			$data['meta_tag']=$meta_all;
			
			$data['our_partners']=$this->our_partners_model->getPartner_info();  
			
			/* get_print($data['our_partners']); */
			
			$this->layout->view('view_our_partners',$lay,$data, 'normal');
    }

    

}
