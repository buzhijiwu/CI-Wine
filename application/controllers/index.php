<?php
class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }
	public function index(){
		$this->load->model('company_model','company');
		$company = array_shift($this->company->select_company(array()));
	    if ($company){
	         $data =array(
	         'companyname' => $company['companyname'],
	         'description' => $company['description'],
	         'url' => $company['url'],
	         'logo' => $company['logo'],
	         );
	     }
	    $this->load->view("header.php");
	    $this->load->view("index",$data);
	
	}
}