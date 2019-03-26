<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MX_Controller 
{
	function __construct()
	{
		parent:: __construct();
		
		$this->load->model('admin/admin_model');
		$this->load->model('auth/auth_model');
		$this->load->model('admin/sections_model');
		$this->load->model('hr/personnel_model');
		$this->load->model('admin/site_model');
		
		if(!$this->auth_model->check_login())
		{
			redirect('login');
		}
	}
    
	/*
	*
	*	Index
	*
	*/
	public function index() 
	{
		redirect("reports/transactions");
	}
    
	/*
	*
	*	Dashboard
	*
	*/
	public function dashboard() 
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('profile_page', $v_data, true);
		
		$this->site_model->load_page($data);
	}
}
?>