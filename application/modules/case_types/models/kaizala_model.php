<?php
class Kaizala_model extends CI_Model
{
   
public function get_accesstoken()
    {
        //connector details(application id and secret)
        //$group_id=
        $application_secret = "6WPLN1IOCQ";
        $application_id = "7930b52c-5c44-4f30-bf86-8eb59185a4b2";
        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNzkzMGI1MmMtNWM0NC00ZjMwLWJmODYtOGViNTkxODVhNGIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcImFsdmFyb0Nvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ODZmZWI1MmMtMTRkNS00YTdkLTk4ZGEtYmEyYWI0NDBmMDhmIiwidmVyIjoiMiIsIm5iZiI6MTUzOTI2NzY1NiwiZXhwIjoxNTcwODAzNjU2LCJpYXQiOjE1MzkyNjc2NTYsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.EUbTW2bHFd_7peTIuuADyxktphK33VMF7KdEOawMwbA";
        $url =  "https://kms.kaiza.la/v1/accessToken";

        $curl = curl_init($url);

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://kms.kaiza.la/v1/accessToken",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "applicationId: $application_id",
            "applicationSecret: $application_secret",
            "cache-control: no-cache",
            "refreshToken:$refresh_token"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        
        $response_json =json_decode($response);
        $access_token = $response_json->accessToken;
        return $access_token;
        //var_dump($access_token);
        // $response_json =
        }
    }
    
    // action card to send when there is no translation details
    public function send_action_card($case_description,$phone)
    {
        //var_dump($case_description);die();

        $group_id = "83827724-3851-4250-9987-c10004140c51";
        $url ="https://kms.kaiza.la/v1/groups/". $group_id."/actions";
        $curl = curl_init($url);
        $accesstoken =$this->get_accesstoken();
        $datastring  = array(
            "id" =>"com.legal.lawyershub.7",
            "sendToAllSubscribers" => false,
            "subscribers" => $phone,
            "actionBody" =>array(
                "properties"=>array(
                    array(
                        "name" => "casedescription",
                        "value" => $case_description,
                        "type"=>"Text"

                    )
                )
            )

        );
        $data_json = json_encode($datastring);

        curl_setopt_array($curl, array(
        //CURLOPT_URL => "https://kms.kaiza.la/v1/groups/0a6e3c2c-93f3-43ed-bd69-b9267b5cf8c6/actions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data_json,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "accessToken: " .$accesstoken,
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        $response_object = json_decode($response);
        echo $response;
        $action_id = $response_object->actionId;
        echo $action_id;
        }
        
    }


    
    
}

?>