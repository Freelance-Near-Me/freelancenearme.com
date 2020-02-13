<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forgot_pass extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('forgot_model');
         $this->load->model('membership/membership_model');
		 $idiom=$this->session->userdata('lang');
		 $this->lang->load('forgot_pass',$idiom);
		 
        parent::__construct();
    }

    public function index() {
	
	$breadcrumb=array(
            array(
                    'title'=>__('forgot_password','Forgot Password'),'path'=>''
            )
        );
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('forgot_password','Forgot Password'));
	$head['current_page']='forgot_pass';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	$table='contents';
	$by="cms_unique_title";
	$val='forgot_pass';
	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/
	$this->autoload_model->getsitemetasetting("meta","pagename","Forgot_pass");
	$lay['client_testimonial']="inc/footerclient_logo";
	$this->layout->view('forgot',$lay,$data,'normal');
	
    }
	public function check() {
	$this->auto_model->checkrequestajax();
	
	 if($this->input->post()){
	  $post_data = $this->input->post();
		  $insert = $this->forgot_model->check_email($post_data);
		 
	 }
	
    }
	public function reset_pass($uid='') {
	
	if($uid=='')
	{
		redirect(VPATH);	
	}
	else
	{
		//$data['user_id']=base64_decode($uid);
		$data['user_id']=$uid;
	$breadcrumb=array(
            array(
                    'title'=>'Forgot','path'=>''
            )
        );
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Reset Password');
	$head['current_page']='reset_pass';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	
	$this->autoload_model->getsitemetasetting();
	$lay['client_testimonial']="inc/footerclient_logo";
	$this->layout->view('resetpass',$lay,$data,'normal');
	}
    }
	public function resetpass() {
	$this->auto_model->checkrequestajax();
	
	 if($this->input->post()){
	  $post_data = $this->input->post();
		  $insert = $this->forgot_model->reset_password($post_data);
		 
	 }
	}
	
	public function register_success()
	 {
		$breadcrumb=array(

					array(

						'title'=>'Signup','path'=>''

					)

				);

	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Signup');

	$head['current_page']='signup';
	
	$head['ad_page']='signup';

	$load_extra=array();

	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

	$this->layout->set_assest($head);

	$table='contents';

	$by="cms_unique_title";

	$val='login';
	
	$data['refer']=$this->input->get('refer');

	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

        $data['country']=$this->autoload_model->getCountry();
        
        $data['state']=$this->autoload_model->getCity("NGA");
        
        
	$this->autoload_model->getsitemetasetting("meta","pagename","Signup");

	$lay['client_testimonial']="inc/footerclient_logo";
	   $this->layout->view('register_success',$lay,$data,'normal');
	 }
}
