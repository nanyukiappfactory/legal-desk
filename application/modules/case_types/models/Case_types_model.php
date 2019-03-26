<?php
class Case_types_model extends CI_Model
{
    public function get_case_details($case_type_name)
    {
        //$this->db->select("case_type_description");
        $this->db->where("case_type_id", $case_type_name);
        $query = $this->db->get("case_type");
        if($query->num_rows() > 0 )
        {
            $row = $query->row();
            $case_type_description = $row->case_type_description;
            return $case_type_description;
        }
        else{
            return FALSE;
        }
        // $query_json = json_encode($query->result());
        // echo $query;
        // $query_obj = json_decode($query_json);
        
        // $case_desc = $query["case_type_description"];
        // echo $case_desc;
        //return $query->result();

    }
    public function get_all_case_types()
    {   
        $this->db->order_by('case_type_name', 'ASC');
        $query = $this->db->get("case_type");
        return $query->result();

    }
    public function translate_text($text, $code)
        
    {
        //var_dump($text, $code);die();
        // URL to fetch
		$CURL_URL = $this->face_base_url."&from=en&to=".$code;
		
        //Data to send
        $request_data = array(
            array(
                'Text' => $text
            )
        );
        $request_json = json_encode($request_data);
        // var_dump($request_json); die();
		
        // Performing the HTTP request
        $ch = curl_init($CURL_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Length: '.strlen($request_json),
                'Content-Type: application/json',
                'Ocp-Apim-Subscription-Key: '.$this->api_key
            )
        );
        $response_body = curl_exec($ch);
        curl_close($ch);
        // var_dump($response_body);

        $response_json = json_decode($response_body);
        // var_dump($response_json); die();
        if($response_json != NULL)
        {
            if(isset($response_json->error))
            {
                return FALSE;
            }

            else
            {
                $row = $response_json[0];
                if(isset($row->translations))
                {
                    $translations = $row->translations;
                    $item = $translations[0];
                    //var_dump($item); die();
                    return $item->text;
                }

                else
                {
                    return FALSE;
                }
            }
        }

        else
        {
            return FALSE;
        }
    }
    
}

?>