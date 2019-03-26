<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Translate extends MX_Controller
{
    public $csv_path;
    public function __construct()
    {
		parent::__construct();
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400'); // cache for 1 day
		  }
		
		  // Access-Control headers are received during OPTIONS requests
		  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			  header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			  header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		
			exit(0);
		  }
        $this->load->model('translate_model');
        $this->csv_path = realpath(APPPATH . '../assets/csv');

        // if (!$this->auth_model->check_login()) {
        //     redirect('login');
        // }
    }
    
	
	public function translate_item()
	{
		$case_description = "Upon the death of a person intestate, or of one who left a will without appointing executors, or when the executors appointed by the will cannot or will not act, the Probate Division of the High Court of Justice or the local District Probate Registry will appoint an administrator who performs similar duties to an executor";
		$language = "kiswahili";
		if($language == "kiswahili"){
			$code = "sw";
		}
		$translated = $this->translate_model->translate_text($case_description, $code);
		var_dump($translated);die();
		

		
	}

}
