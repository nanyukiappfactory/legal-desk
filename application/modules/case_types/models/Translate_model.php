<?php
class Translate_model extends CI_Model
{
    var $api_key = "c706309d61d24b61ab7b92e288e17ee1";
    var $face_base_url = "https://api.cognitive.microsofttranslator.com/translate?api-version=3.0";

    function __construct() {
		parent:: __construct();
    }

    public function translate_text($text,$code)
        
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

    public function save_image($image_url, $path)
    {
        $image_name = md5(date("Y-m-d H:i:s"));
        $content = file_get_contents($image_url);
        file_put_contents($path . '/'.$image_name.'.jpg', $content);

        return $image_name.'.jpg';
    }

    public function send_announcement($title, $message, $employee_image, $sender_phone)
    {
        // URL to fetch
        $CURL_URL = "https://prod-29.westeurope.logic.azure.com:443/workflows/a9fb7ee913dd42b69af8cc6ba3277faf/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=4K3WmoXDwnMGbdlexgFRYt2SA7aJ8MS8ifni6KEwAfs";

        //Data to send
        $request_data = array(
            'image' => $employee_image,
            'title' => $title,
            'message' => $message,
            'phone' => $sender_phone
        );
        $request_json = json_encode($request_data);
        
        // Performing the HTTP request
        $ch = curl_init($CURL_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "[".$request_json."]");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            )
        );
        $response_body = curl_exec($ch);
        curl_close($ch);
        echo $response_body;
    }
}