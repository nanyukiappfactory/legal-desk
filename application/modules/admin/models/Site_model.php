<?php

class Site_model extends CI_Model 
{
	public function display_page_title()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$name = $this->site_model->decode_web_name($page[$last]);
		
		if(is_numeric($name))
		{
			$last = $last - 1;
			$name = $this->site_model->decode_web_name($page[$last]);
		}
		$page_url = ucwords(strtolower($name));
		
		return $page_url;
	}
	
	public function get_footer_navigation()
	{
		$page = explode("/",uri_string());
		$total = count($page);

            
		$navigation = 
		'
			<li><a href="'.base_url().'home">Home</a></li>
            <li><a href="'.base_url().'about">About Us</a></li>
            <li><a href="'.base_url().'faqs">FAQs</a></li>
            <li><a href="'.base_url().'utu-app">Utu App</a></li>
            <li><a href="'.base_url().'blog">Blog</a></li>
            <li><a href="'.base_url().'contact">Contact Us</a></li>
		';

		return $navigation;
	}
	
	public function display_image($base_path = NULL, $location = NULL, $image_name = NULL)
	{
		if($base_path == NULL || $location == NULL)
		{
			$base_path = realpath(APPPATH . '../assets/uploads');
			$location = base_url()."assets/uploads/";
		}
		$default_image = 'http://placehold.it/300x300&text=Image';
		$file_path = $base_path.'/'.$image_name;
		//echo $file_path.'<br/>';
		
		//Check if image was passed
		if($image_name != NULL)
		{
			if(!empty($image_name))
			{
				if((file_exists($file_path)) && ($file_path != $base_path.'\\'))
				{
					return $location.$image_name;
				}
				
				else
				{
					return $default_image;
				}
			}
			
			else
			{
				return $default_image;
			}
		}
		
		else
		{
			return $default_image;
		}
	}
	
	public function get_contacts()
	{
  		$table = "contacts";
		
		$query = $this->db->get($table);
		$contacts = array();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$contacts['email'] = $row->email;
			$contacts['phone'] = $row->phone;
			$contacts['facebook'] = $row->facebook;
			$contacts['twitter'] = $row->twitter;
			$contacts['linkedin'] = $row->pintrest;
			$contacts['company_name'] = $row->company_name;
			$contacts['logo'] = $row->logo;
			$contacts['address'] = $row->address;
			$contacts['city'] = $row->city;
			$contacts['post_code'] = $row->post_code;
			$contacts['building'] = $row->building;
			$contacts['floor'] = $row->floor;
			$contacts['location'] = $row->location;
			$contacts['working_weekend'] = $row->working_weekend;
			$contacts['working_weekday'] = $row->working_weekday;
			$contacts['mission'] = $row->mission;
			$contacts['vision'] = $row->vision;
			$contacts['motto'] = $row->motto;
			$contacts['about'] = $row->about;
			$contacts['objectives'] = $row->objectives;
			$contacts['core_values'] = $row->core_values;
			$contacts['corporate_values'] = '';
		}

		return $contacts;
	}
	
	public function get_breadcrumbs()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$crumbs = '<li><a href="'.site_url().'admin">Dashboard</a></li>';
		
		for($r = 0; $r < $total; $r++)
		{
			$name = $this->decode_web_name($page[$r]);
			if($r == $last)
			{
				$crumbs .= '<li class="active"><a href="#"><span>'.$name.'</span></a></li>';
			}
			else
			{
				$link = site_url();
				for($s = 0; $s <= $r; $s++)
				{
					$link_name = $this->create_web_name($page[$s]);
					$link .= $link_name.'/';
				}
				$crumbs .= '<li><a href="#"><span>'.$name.'</span></a></li>';
			}
		}
		
		return $crumbs;
	}
	
	public function valid_url($url)
	{
		$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
		//$pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
        if (!preg_match($pattern, $url))
		{
            return FALSE;
        }
 
        return TRUE;
	}
	
	public function get_days($date)
	{
		$now = time(); // or your date as well
		$your_date = strtotime($date);
		$datediff = $now - $your_date;
		return floor($datediff/(60*60*24));
	}
	
	public function limit_text($text, $limit) 
	{
		$pieces = explode(" ", strip_tags($text));
		$total_words = count($pieces);
		
		if ($total_words > $limit) 
		{
			$return = "";
			$count = 0;
			for($r = 0; $r < $total_words; $r++)
			{
				$count++;
				if(($count%$limit) == 0)
				{
					$return .= $pieces[$r]."<br/>";
				}
				else{
					$return .= $pieces[$r]." ";
				}
			}
		}
		
		else{
			$return = "<i>".$text;
		}
		return $return.'</i><br/>';
    }
	
	public function get_tweets()
	{
		$this->load->library('twitteroauth');
		$consumer = 'fZvEA9Mw24i2jT3VIn1sIz92y';
		$consumer_secret = 'NW3rzs0jEv39JdSmNeurZvKL577vxPVLuV95vedROczQtQIbDp';
		$access_token = '588425913-dHNleDnlFPdfHGYjZpUnph7MEhKTXqULJ6OaP6IP';
		$access_token_secret = 'iMmuv0bADX4CbG3i0T1vDvGo1uRYlAWfb5khB9Qfm7v3m';
		
		//Create an instance
		$connection = $this->twitteroauth->create($consumer, $consumer_secret, $access_token, $access_token_secret);
	
		//Verify your authentication details
		$content = $connection->get('account/verify_credentials');
	}
	
	public function get_last_uri()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$name = strtolower($page[$last]);
		
		$title = ucwords($this->decode_web_name($name));
		
		return $title;
	}
	
	public function highlight_text($text, $replace)
	{
		//As sent
		$text = str_replace($replace, "<mark>".$replace."</mark>", $text);
		
		//Capitalized
		$replace = ucwords($replace);
		$text = str_replace($replace, "<mark>".$replace."</mark>", $text);
		
		//Lower case
		$replace = strtolower($replace);
		$text = str_replace($replace, "<mark>".$replace."</mark>", $text);
		
		//Upper case
		$replace = strtoupper($replace);
		$text = str_replace($replace, "<mark>".$replace."</mark>", $text);
		return $text;
	}

	public function load_page($data)
	{
		$this->load->view('admin/templates/home', $data);
	}

	public function get_resources_location()
	{
		return base_url()."assets/themes/";
	}

	public function create_web_name($field_name)
	{
		$web_name = str_replace(" ", "-", $field_name);
		
		return $web_name;
	}
	
	public function decode_web_name($web_name)
	{
		$field_name = str_replace("-", " ", $web_name);
		
		return $field_name;
	}

	public function format_phone_number($merchant_num)
	{
		//Remove spaces
		$merchant_num = preg_replace('/\s/', '', $merchant_num);

		//Remove +254
		if ($merchant_num[1] == 2 && $merchant_num[2] == 5 && $merchant_num[3] == 4)
		{
			$phone_number = substr($merchant_num, 4, 9);
		}
		
		//Remove 254 & OR 0
		else 
		{
			$phone_number = $merchant_num[0] == 0 ? substr($merchant_num, 1, 9) : ($merchant_num[0] == 2 && $merchant_num[1] == 5 && $merchant_num[2] == 4 ? substr($merchant_num, 3, 9) : $merchant_num);
		}

		return $phone_number;
	}

	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all administrators
	*
	*/
	public function get_active_users()
	{
		$this->db->from('personnel');
		$this->db->select('*');
		$query = $this->db->get();
		
		return $query;
	}

	public function export_results($table, $where, $order, $order_method, $title)
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get();

		$delimiter = ",";
        $newline = "\r\n";
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		$res = force_download(date("Y-m-d H:i:s").$title.'.csv', $data);
		if($res)
		{
			return TRUE;
		}

		else
		{
			return FALSE;
		}
	}

	public function exports_data($data, $title)
	{
		// header("Content-Description: File Export"); 
		// header("Content-Type: application/csv");
		header('Content-type: application/x-csv');
		// header("Content-Disposition: attachment; filename=\"".$title.".csv\"");
		header('Content-disposition:filename="'.$title.'.csv"');
		header('Access-Control-Expose-Headers');
        header("Pragma: no-cache");
		header("Expires: 0");
		
		// echo json_encode($data); die();
		


		$handle = fopen('php://output', 'w');

		foreach ($data as $row) {
			fputcsv($handle, $row);
		}
		fclose($handle);
		exit;

		//load our new PHPExcel library
        // $this->load->library('excel');
        // //activate worksheet number 1
		// $this->excel->setActiveSheetIndex(0);
		
		// $this->excel->getProperties()->setTitle("export")->setDescription("none");
 
		// $this->excel->setActiveSheetIndex(0);
		
        // $col = 0;
        // foreach ($data[0] as $field)
        // {
        //     $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
        //     $col++;
        // }
 
        // // Fetching the table data
        // $row = 2;
        // foreach($data[1] as $db_data)
        // {
        //     $col = 0;
        //     foreach ($data[0] as $key => $field)
        //     {
        //         $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $db_data);
        //         $col++;
        //     }
 
        //     $row++;
        // }
 
        // $this->excel->setActiveSheetIndex(0);
 
        // // Sending headers to force the user to download the file
        // header('Content-Type: text/csv');
        // header('Content-Disposition: attachment;filename="'.$title.'.csv"');
		// header('Cache-Control: max-age=0');

		// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');
		
 
        // $objWriter->save('php://output');
		// exit;
	}
}

?>