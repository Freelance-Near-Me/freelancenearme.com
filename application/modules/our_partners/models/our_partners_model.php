<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class our_partners_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	
	public function getPartner_info()
	{
		$rs = array();
		$this->db->select('*');
		$rs = $this->db->where('status','Y')->get('partner')->result_array();
		/* get_print($rs); */
		return $rs;
	
	}
	

}
