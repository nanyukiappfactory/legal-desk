<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Personnel extends Admin 
{
	function __construct()
	{
		parent:: __construct();
	}
    
	/*
	*
	*	Default action is to show all the personnel
	*
	*/
	public function index($order = 'personnel_fname', $order_method = 'ASC') 
	{
		$where = 'personnel.personnel_type_id = personnel_type.personnel_type_id';
		$table = 'personnel, personnel_type';
		$personnel_search = $this->session->userdata('personnel_search');
		
		if(!empty($personnel_search))
		{
			$where .= $personnel_search;
		}
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'administration/users/'.$order.'/'.$order_method;
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
		$query = $this->personnel_model->get_all_personnel($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Personnel';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('personnel/all_personnel', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
	}
    
	/*
	*
	*	Add a new personnel
	*
	*/
	public function add_personnel() 
	{
		//form validation rules
		$this->form_validation->set_rules('personnel_onames', 'Other Names', 'required');
		$this->form_validation->set_rules('personnel_fname', 'First Name', 'required');
		$this->form_validation->set_rules('personnel_phone', 'Phone', 'required');
		$this->form_validation->set_rules('personnel_type_id', 'Personnel type', 'required');
		$this->form_validation->set_rules('personnel_password', 'Password', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$personnel_id = $this->personnel_model->add_personnel();
			if($personnel_id > 0)
			{
				$this->session->set_userdata("success_message", "Personnel added successfully");
				redirect("administration/users");
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not add personnel. Please try again ".$personnel_id);
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
		
		$data['title'] = 'Add personnel';
		$v_data['title'] = $data['title'];
		$v_data['personnel_types'] = $this->personnel_model->get_personnel_types();
		$data['content'] = $this->load->view('personnel/add_personnel', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
	}

	/*
	*
	*	Edit an existing personnel
	*	@param int $personnel_id
	*
	*/
	public function edit_personnel($personnel_id) 
	{
		//open the add new personnel
		$data['title'] = 'Edit Personnel';
		$v_data['title'] = $data['title'];
		$v_data['personnel'] = $this->personnel_model->get_personnel($personnel_id);
		$v_data['personnel_id'] = $personnel_id;
		$v_data['personnel_types'] = $this->personnel_model->get_personnel_types();
		$v_data['parent_sections'] = $this->sections_model->all_parent_sections('section_position');
		$v_data['roles'] = $this->personnel_model->get_personnel_roles($personnel_id);
		// $v_data['parent_sections'] = $this->sections_model->all_parent_sections('section_position');
		$data['content'] = $this->load->view('personnel/edit_personnel', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
	}
	
	public function update_personnel_roles($personnel_id)
	{
		$this->form_validation->set_rules('section_id', 'Section', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->personnel_model->update_personnel_roles($personnel_id))
			{
				$this->session->set_userdata("success_message", "Personnel roles successfully updated");
			}
			
			else
			{
				$this->session->set_userdata("error_message", "Could not update personnel roles. Please try again");
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
		redirect('administration/edit-user/'.$personnel_id);
	}
    
    public function update_personnel_about_details($personnel_id)
    {
    	$this->form_validation->set_rules('personnel_onames', 'Other Names', 'required');
		$this->form_validation->set_rules('personnel_fname', 'First Name', 'required');
		$this->form_validation->set_rules('personnel_phone', 'Phone', 'required');
		$this->form_validation->set_rules('personnel_type_id', 'Personnel_type', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->personnel_model->edit_personnel($personnel_id))
			{
				$this->session->set_userdata('success_message', 'personnel\'s general details updated successfully');
				$this->session->unset_userdata($image_upload_name);
				redirect('administration/edit-user/'.$personnel_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update personnel\'s general details. Please try again');
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
		
		$this->edit_personnel($personnel_id, $this->session->userdata($image_upload_name));
    }

	public function reset_password($personnel_id)
	{
		
    	$data = array(
			"personnel_password" => md5(123456)
		);
		
		$this->db->where('personnel_id', $personnel_id);
		if($this->db->update('personnel', $data))
		{
			$this->session->set_userdata('success_message', 'Password updated successfully');
			redirect('administration/edit-user/'.$personnel_id);
		}
		else{
			$this->session->set_userdata('success_message', 'Password updated successfully');
			redirect('administration/edit-user/'.$personnel_id);
		}
		
	}
    
	/*
	*
	*	Delete an existing personnel
	*	@param int $personnel_id
	*
	*/
	public function delete_personnel($personnel_id)
	{
		if($this->personnel_model->delete_personnel($personnel_id))
		{
			$this->session->set_userdata('success_message', 'Personnel has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Personnel could not deleted');
		}
		redirect('administration/users');
	}
    
	/*
	*
	*	Activate an existing personnel
	*	@param int $personnel_id
	*
	*/
	public function activate_personnel($personnel_id)
	{
		$this->personnel_model->activate_personnel($personnel_id);
		$this->session->set_userdata('success_message', 'Personnel activated successfully');
		redirect('administration/users');
	}
    
	/*
	*
	*	Deactivate an existing personnel
	*	@param int $personnel_id
	*
	*/
	public function deactivate_personnel($personnel_id)
	{
		$this->personnel_model->deactivate_personnel($personnel_id);
		$this->session->set_userdata('success_message', 'Personnel disabled successfully');
		redirect('administration/users');
	}

	public function delete_personnel_role($personnel_section_id, $personnel_id)
    {
		if($this->personnel_model->delete_personnel_role($personnel_section_id))
		{
			$this->session->set_userdata("success_message", "Role deleted successfully");
		}
		
		else
		{
			$this->session->set_userdata("error_message","Could not delete role. Please try again");
		}
		redirect('administration/edit-user/'.$personnel_id);
	}
	
	public function search_personnel()
	{
		$personnel_number = $this->input->post('personnel_number');
		$branch_id = $this->input->post('branch_id');
		$search_title = '';
		
		/*if(!empty($personnel_number))
		{
			$search_title .= ' member number <strong>'.$personnel_number.'</strong>';
			$personnel_number = ' AND personnel.personnel_number LIKE \'%'.$personnel_number.'%\'';
		}*/
		if(!empty($personnel_number))
		{
			$search_title .= ' personnel number <strong>'.$personnel_number.'</strong>';
			$personnel_number = ' AND personnel.personnel_number = \''.$personnel_number.'\'';
		}
		
		if(!empty($branch_id))
		{
			$search_title .= ' branch id <strong>'.$branch_id.'</strong>';
			$branch_id = ' AND personnel.branch_id = \''.$branch_id.'\' ';
		}
		
		//search surname
		if(!empty($_POST['personnel_fname']))
		{
			$search_title .= ' first name <strong>'.$_POST['personnel_fname'].'</strong>';
			$surnames = explode(" ",$_POST['personnel_fname']);
			$total = count($surnames);
			
			$count = 1;
			$surname = ' AND (';
			for($r = 0; $r < $total; $r++)
			{
				if($count == $total)
				{
					$surname .= ' personnel.personnel_fname LIKE \'%'.mysql_real_escape_string($surnames[$r]).'%\'';
				}
				
				else
				{
					$surname .= ' personnel.personnel_fname LIKE \'%'.mysql_real_escape_string($surnames[$r]).'%\' AND ';
				}
				$count++;
			}
			$surname .= ') ';
		}
		
		else
		{
			$surname = '';
		}
		
		//search other_names
		if(!empty($_POST['personnel_onames']))
		{
			$search_title .= ' other names <strong>'.$_POST['personnel_onames'].'</strong>';
			$other_names = explode(" ",$_POST['personnel_onames']);
			$total = count($other_names);
			
			$count = 1;
			$other_name = ' AND (';
			for($r = 0; $r < $total; $r++)
			{
				if($count == $total)
				{
					$other_name .= ' personnel.personnel_onames LIKE \'%'.mysql_real_escape_string($other_names[$r]).'%\'';
				}
				
				else
				{
					$other_name .= ' personnel.personnel_onames LIKE \'%'.mysql_real_escape_string($other_names[$r]).'%\' AND ';
				}
				$count++;
			}
			$other_name .= ') ';
		}
		
		else
		{
			$other_name = '';
		}
		
		$search = $personnel_number.$branch_id.$surname.$other_name;
		$this->session->set_userdata('personnel_search2', $search);
		$this->session->set_userdata('personnel_search_title2', $search_title);
		
		$this->index();
	}
	
	public function close_search()
	{
		$this->session->unset_userdata('personnel_search2', $search);
		$this->session->unset_userdata('personnel_search_title2', $search_title);
		
		redirect('administration/users');
	}

	public function download_personnel() 
	{
		if($this->personnel_model->personnel_export())
		{
			$this->session->set_userdata("success_message","Personnel downloaded successfully");
		}
		else
		{
			$this->session->set_userdata("error_message","Could not download the personnel. Please try again ");
		}
			redirect('administration/users');
	}

	public function get_section_children($section_id)
	{
		$sub_sections = $this->sections_model->get_sub_sections($section_id);
		
		$children = '';
		
		if($sub_sections->num_rows() > 0)
		{
			$children = '<option value="0" >--Select a sub section--</option>';
			foreach($sub_sections->result() as $res)
			{
				$section_id = $res->section_id;
				$section_name = $res->section_name;
				
				$children .= '<option value="'.$section_id.'" >'.$section_name.'</option>';
			}
		}
		
		else
		{
			$children = '<option value="" >--No sub sections--</option>';
		}
		
		echo $children;
	}
}
?>