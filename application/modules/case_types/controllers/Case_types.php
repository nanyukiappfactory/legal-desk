<?php
class Case_types extends MX_controller
{
    public function __Construct()
    {
        parent:: __Construct();
        // Allow from any origin
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
        $this->load->model("case_types_model");
        $this->load->model("kaizala_model");
        $this->load->model("translate_model");
    }
    public function get_all_case_types()
    {
        $case_types = $this->case_types_model->get_all_case_types();
        echo json_encode($case_types);
    }
    public function get_case_types()
    {
        //get json
        $json_string = file_get_contents("php://input");
        //decode json
        $json_object = json_decode($json_string);

        if (is_array($json_object) && (count($json_object)> 0)) {
            $row = $json_object[0];
            $case_type_name = $row->casetypename;
            $language = $row->language;
            $phone = $row->phone_number;

            //request to submit
            $case_description = $this->case_types_model->get_case_details($case_type_name);
            // var_dump($case_description);
            // var_dump($language);die();
            if($language == "english"){
              $send_actioncard = $this->kaizala_model->send_action_card($case_description,$phone);
            }
            else{
              $translated_case_description = $this->translate_item($case_description,$language);
              //var_dump($translated_case_description);die();
              $send_actioncard = $this->kaizala_model->send_action_card($translated_case_description,$phone);
            }
           
            //var_dump($case_type_name);die();
            
            return $send_actioncard;
                
          
        }
    

    }
    public function get_specific_data(){
      $case_description = $this->case_types_model->get_case_details();
    }
    // public function get_translation(){
    //   $case_description = "hello";
    //   $language = "kiswahili";
    //   $translated_case_description =$this->translate_item();

    // }
    public function translate_item($case_description,$language)
	{
    //var_dump($case_description);die();
		if($language == "kiswahili"){
			$code = "sw";
		}
    $translated = $this->translate_model->translate_text($case_description, $code);
    return $translated;
	}

    

    
}

?>