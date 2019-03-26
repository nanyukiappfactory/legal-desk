<?php

class Personnel_model extends CI_Model 
{	
	/*
	*	Retrieve all personnel
	*
	*/
	public function retrieve_personnel()
	{
		$this->db->where('personnel_status = 1');
		$this->db->order_by('personnel_fname');
		$query = $this->db->get('personnel');
		
		return $query;
	}

	/*
	*	Retrieve all personnel
	*
	*/
	public function all_personnel()
	{
		$this->db->where('personnel_status = 1');
		$query = $this->db->get('personnel');
		
		return $query;
	}
	
	/*
	*	Retrieve all personnel
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_personnel($table, $where, $per_page, $page, $order = 'personnel_name', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new personnel
	*	@param string $image_name
	*
	*/
	public function add_personnel()
	{
		$data = array(
			'personnel_onames'=>ucwords(strtolower($this->input->post('personnel_onames'))),
			'personnel_fname'=>ucwords(strtolower($this->input->post('personnel_fname'))),
			'personnel_phone'=>$this->input->post('personnel_phone'),
			'personnel_password'=> md5($this->input->post('personnel_password'))
		);
		
		if($this->db->insert('personnel', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing personnel
	*	@param string $image_name
	*	@param int $personnel_id
	*
	*/
	public function edit_personnel($personnel_id)
	{
		$data = array(
			'personnel_onames'=>ucwords(strtolower($this->input->post('personnel_onames'))),
			'personnel_fname'=>ucwords(strtolower($this->input->post('personnel_fname'))),
			'personnel_phone'=>$this->input->post('personnel_phone'),
			'personnel_type_id'=>$this->input->post('personnel_type_id')
		);
		
		$this->db->where('personnel_id', $personnel_id);
		if($this->db->update('personnel', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function update_personnel_roles($personnel_id)
	{
		$section_id = $this->input->post('section_id');
		$child_id = $this->input->post('child_id');
		if($child_id > 0)
		{

			$update_section = $child_id;
		}
		else
		{

			$update_section = $section_id;
		}

		
		$this->db->from('personnel_section,section');
		$this->db->select('*');
		$this->db->where('personnel_section.section_id = section.section_id AND personnel_section.section_id = '.$update_section.' AND personnel_section.personnel_id ='.$personnel_id);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$row = $query->row;
			$section_parent = $row->section_parent;

			if($section_parent > 0 AND $section_parent)
			{
				$update_section = $section_parent;
				$data = array(
					'personnel_id'=>$personnel_id,
					'section_id'=>$update_section,
					'created_by'=>$this->session->userdata('personnel_id'),
					'modified_by'=>$this->session->userdata('personnel_id'),
					'created'=>date('Y-m-d H:i:s'),
					'last_modified'=>date('Y-m-d H:i:s'),
				);
			}
			else
			{
				$update_section = $update_section;
				$data = array(
					'personnel_id'=>$personnel_id,
					'section_id'=>$update_section,
					'created_by'=>$this->session->userdata('personnel_id'),
					'modified_by'=>$this->session->userdata('personnel_id'),
					'created'=>date('Y-m-d H:i:s'),
					'last_modified'=>date('Y-m-d H:i:s'),
				);
			}
			$this->db->where('personnel_id', $personnel_id);
			if($this->db->update('personnel_section', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}	
		}
		else
		{
			$data = array(
					'personnel_id'=>$personnel_id,
					'section_id'=>$update_section,
					'created_by'=>$this->session->userdata('personnel_id'),
					'modified_by'=>$this->session->userdata('personnel_id'),
					'created'=>date('Y-m-d H:i:s'),
					'last_modified'=>date('Y-m-d H:i:s'),
			);
			if($this->db->insert('personnel_section', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}	

		}

	}
	
	/*
	*	get a single personnel's details
	*	@param int $personnel_id
	*
	*/
	public function get_personnel($personnel_id)
	{
		//retrieve all users
		$this->db->from('personnel');
		$this->db->select('*');
		$this->db->where('personnel_id = '.$personnel_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing personnel
	*	@param int $personnel_id
	*
	*/
	public function delete_personnel($personnel_id)
	{
		//delete parent
		if($this->db->delete('personnel', array('personnel_id' => $personnel_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing personnel
	*	@param int $personnel_id
	*
	*/
	public function delete_personnel_role($personnel_section_id)
	{
		//delete parent
		if($this->db->delete('personnel_section', array('personnel_section_id' => $personnel_section_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated personnel
	*	@param int $personnel_id
	*
	*/
	public function activate_personnel($personnel_id)
	{
		$data = array(
				'personnel_status' => 1
			);
		$this->db->where('personnel_id', $personnel_id);
		

		if($this->db->update('personnel', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated personnel
	*	@param int $personnel_id
	*
	*/
	public function deactivate_personnel($personnel_id)
	{
		$data = array(
				'personnel_status' => 0
			);
		$this->db->where('personnel_id', $personnel_id);
		
		if($this->db->update('personnel', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single personnel's roles
	*	@param int $personnel_id
	*
	*/
	public function get_personnel_roles($personnel_id)
	{
		//retrieve all users
		$this->db->from('personnel_section, section');
		$this->db->select('personnel_section.*, section.section_name, section.section_position, section.section_parent, section.section_icon');
		$this->db->order_by('section_parent', 'ASC');
		$this->db->order_by('section_position', 'ASC');
		$this->db->where('personnel_section.section_id = section.section_id AND personnel_section.personnel_id = '. $personnel_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Select get personnel types
	*
	*/
	public function get_personnel_types()
	{
		$this->db->select('*');
		$this->db->order_by('personnel_type_name', 'ASC');
		$query = $this->db->get('personnel_type');
		
		return $query;
	}
}
?>