<?php
/**
 * Created by PhpStorm.
 * User: ivy
 * Date: 2/22/19
 * Time: 10:22 PM
 */

class Case_types_model extends CI_Model
{
    /*
    *	Retrieve all Case Types
    *
    */
    public function all_case_types()
    {
        $query = $this->db->get('case_type');

        return $query;
    }

    /*
    *	Retrieve all parent case types
    *
    */
    public function all_parent_case_types($order = 'case_type_name')
    {
        $this->db->where('case_type_parent = 0');
        $this->db->order_by($order, 'ASC');
        $query = $this->db->get('case_type');

        return $query;
    }
    /*
    *	Retrieve all children case types
    *
    */
    public function all_child_case_types($order = 'case_type_name')
    {
        $this->db->where('case_type_parent > 0');
        $this->db->order_by($order, 'ASC');
        $query = $this->db->get('case_type');

        return $query;
    }

    /*
    *	Retrieve all case types
    *	@param string $table
    * 	@param string $where
    *
    */
    public function get_all_case_types($table, $where, $per_page, $page, $order = 'case_type_name', $order_method = 'ASC')
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
    *	Add a new case type
    *	@param string $image_name
    *
    */
    public function add_case_type()
    {
        $data = array(
            'case_type_name'=>ucwords(strtolower($this->input->post('case_type_name'))),
            'case_type_parent'=>$this->input->post('case_type_parent'),
            'case_type_description'=>$this->input->post('case_type_description'),
            'created'=>date('Y-m-d H:i:s'),
            'created_by'=>$this->session->userdata('personnel_id'),
            'modified_by'=>$this->session->userdata('personnel_id')
        );

        if($this->db->insert('case_type', $data))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /*
    *	Update an existing case type
    *	@param string $image_name
    *	@param int $case_type_id
    *
    */
    public function update_case_type($case_type_id)
    {
        $data = array(
            'case_type_name'=>ucwords(strtolower($this->input->post('case_type_name'))),
            'case_type_parent'=>$this->input->post('case_type_parent'),
            'case_type_description'=>$this->input->post('case_type_description'),
            'modified_by'=>$this->session->userdata('personnel_id')
        );

        $this->db->where('case_type_id', $case_type_id);
        if($this->db->update('case_type', $data))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /*
    *	get a single case type's children
    *	@param int $case_type_id
    *
    */
    public function get_sub_case_types($case_type_id)
    {
        //retrieve all users
        $this->db->from('case_type');
        $this->db->select('*');
        $this->db->where('case_type_parent = '.$case_type_id);
        $query = $this->db->get();

        return $query;
    }

    /*
    *	get a single case_type's details
    *	@param int $case_type_id
    *
    */
    public function get_case_type($case_type_id)
    {
        //retrieve all users
        $this->db->from('case_type');
        $this->db->select('*');
        $this->db->where('case_type_id = '.$case_type_id);
        $query = $this->db->get();

        return $query;
    }

    /*
    *	Delete an existing case type
    *	@param int $case_type_id
    *
    */
    public function delete_case_type($case_type_id)
    {
        //delete children
        if($this->db->delete('case_type', array('case_type_parent' => $case_type_id)))
        {
            //delete parent
            if($this->db->delete('case_type', array('case_type_id' => $case_type_id)))
            {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        else{
            return FALSE;
        }
    }
}
?>