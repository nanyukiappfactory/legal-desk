<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Payments extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model("admin/payments_model");
	}
    
	/*
	*
	*	Default action is to show all the payments
	*
	*/
	public function index($order = 'mpesalipatransaction.mpesalipatransaction_id', $order_method = 'DESC') 
	{
		$where = 'mpesalipatransaction.mpesalipatransaction_id > 0';
		$table = 'mpesalipatransaction';
		$payments_search = $this->session->userdata('payments_search');
		$search_title = $this->session->userdata('payments_search_title');

		if(!empty($payments_search) && $payments_search != NULL)
		{
			$where .= $payments_search;
		}

		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'administration/update-payments/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->site_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->payments_model->get_all_payments($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Payments';

		if(!empty($search_title) && $search_title != NULL)
		{
			$data['title'] = 'Payments filtered by '.$search_title;
		}
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['transacted_customers'] = $this->payments_model->get_transacted_customers();
		$v_data['result_codes'] = $this->payments_model->get_result_codes();
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('payments/all_payments', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
    }
    
	public function search_payments()
	{
		$result_code = $this->input->post('result_code');
		$customer_phone = $this->input->post('customer_phone');
		$daterange = $this->input->post('daterange');
		$search_title = '';
		
		if(!empty($result_code))
		{
			$search_title .= ' Result Code <strong>'.$result_code.'</strong>';
			$result_code = ' AND mpesalipatransaction.resultCode = \''.$result_code.'\'';
		}
		
		if(!empty($customer_phone))
		{
			$search_title .= ' Customer <strong>'.$customer_phone.'</strong>';
			$customer_phone = ' AND mpesalipatransaction.msisdn = \''.$customer_phone.'\'';
		}
		
		if(!empty($daterange))
		{
			$date_array = explode("-", $daterange);
			if(count($date_array) == 2)
			{
				$start_date = date("Y-m-d", strtotime($date_array[0]));
				$end_date = date("Y-m-d", strtotime($date_array[1]));

				$search_title .= ' Date <strong>'.$daterange.'</strong>';
				$daterange = ' AND (mpesalipatransaction.resultReceived >= \''.$start_date.'\' AND mpesalipatransaction.resultReceived <= \''.$end_date.'\')';
			}
		}
		
		$search = $customer_phone.$daterange.$payment_location.$result_code;
		// var_dump($search_title); die();
		$this->session->set_userdata('payments_search', $search);
		$this->session->set_userdata('payments_search_title', $search_title);
		
		redirect("administration/update-payments");
	}
	
	public function close_search()
	{
		$this->session->unset_userdata('payments_search');
		$this->session->unset_userdata('payments_search_title');
		
		redirect("administration/update-payments");
	}

	public function bulk_actions()
	{
		$this->form_validation->set_rules('action_name', 'Action', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$mpesalipatransaction_id_array = $_POST['mpesalipatransaction_id'];
			$action_name = $this->input->post('action_name');
	
			$total_payments = count($mpesalipatransaction_id_array);

			if($total_payments > 0)
			{
				foreach($mpesalipatransaction_id_array as $key => $value)
				{
					if($action_name == "update")
					{
						$this->payments_model->isp_update_payment($value);
					}
					else
					{
						
					}
				}
				
				$payments = "payments";
				if($total_payments == 1)
				{
					$payments = "payment";
				}
				$this->session->set_userdata('success_message', $action_name." of ".$total_payments." ".$payments."  successfull");
			}
			
			else
			{
				$this->session->set_userdata('error_message', "No payments have been selected");
			}
		}

		else
		{
			$validation_errors = validation_errors();
			if(!empty($validation_errors))
			{
				$this->session->set_userdata("error_message", $validation_errors);
			}
		}

		redirect("administration/update-payments");
	}
}
?>