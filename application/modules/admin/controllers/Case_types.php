<?php
/**
 * Created by PhpStorm.
 * User: ivy
 * Date: 2/22/19
 * Time: 10:20 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Case_types extends MX_Controller
{
    function __construct()
    {
        parent:: __construct();
        $this->load->model('admin/site_model');
        $this->load->model('admin/case_types_model');
    }

    /*
    *
    *	Default action is to show all the case types
    *
    */
    public function index($order = 'case_type_name', $order_method = 'ASC')
    {
        $where = 'case_type_id > 0';
        $table = 'case_type';
        //pagination
        $segment = 5;
        $this->load->library('pagination');
        $config['base_url'] = site_url().'administration/case_types/'.$order.'/'.$order_method;
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
        $query = $this->case_types_model->get_all_case_types($table, $where, $config["per_page"], $page, $order, $order_method);

        //change of order method
        if($order_method == 'DESC')
        {
            $order_method = 'ASC';
        }

        else
        {
            $order_method = 'DESC';
        }

        $data['title'] = 'Case Types';
        $v_data['title'] = $data['title'];

        $v_data['order'] = $order;
        $v_data['order_method'] = $order_method;
        $v_data['query'] = $query;
        $v_data['all_case_types'] = $this->case_types_model->all_case_types();
        $v_data['page'] = $page;
        $data['content'] = $this->load->view('case_types/all_case_types', $v_data, true);

        $this->load->view('admin/layout/home', $data);
    }

    /*
    *
    *	Add a new Case Type
    *
    */
    public function add_case_type()
    {
        //form validation rules
        $this->form_validation->set_rules('case_type_name', 'Case Type Name', 'trim|required');
        $this->form_validation->set_rules('case_type_parent', 'Case Type Parent', 'trim');
        $this->form_validation->set_rules('case_type_description', 'Case Type Description', 'required');

        //if form has been submitted
        if ($this->form_validation->run())
        {
            if($this->case_types_model->add_case_type())
            {
                $this->session->set_userdata('success_message', 'Case Type added successfully');
                redirect('administration/case_types');
            }

            else
            {
                $this->session->set_userdata('error_message', 'Could not add Case Type. Please try again');
            }
        }

        //open the add new Case Type

        $data['title'] = 'Add Case Type';
        $v_data['title'] = $data['title'];
        $v_data['all_case_types'] = $this->case_types_model->all_parent_case_types();
        $data['content'] = $this->load->view('case_types/add_case_type', $v_data, true);
        $this->load->view('admin/layout/home', $data);
    }

    /*
    *
    *	Edit an existing case type
    *	@param int $case_type_id
    *
    */
    public function edit_case_type($case_type_id)
    {
        //form validation rules
        $this->form_validation->set_rules('case_type_name', 'Case Type Name', 'trim|required');
        $this->form_validation->set_rules('case_type_parent', 'Case Type Parent', 'trim');
        $this->form_validation->set_rules('case_type_description', 'Case Type Description', 'required');

        //if form has been submitted
        if ($this->form_validation->run())
        {
            //update case type
            if($this->case_types_model->update_case_type($case_type_id))
            {
                $this->session->set_userdata('success_message', 'Case Type updated successfully');
                redirect('administration/case_types');
            }

            else
            {
                $this->session->set_userdata('error_message', 'Could not update Case Type. Please try again');
            }
        }

        //open the add new Case Type
        $data['title'] = 'Edit Case Type';
        $v_data['title'] = $data['title'];

        //select the Case type from the database
        $query = $this->case_types_nodel->get_case_type($case_type_id);

        if ($query->num_rows() > 0)
        {
            $v_data['case_type'] = $query->result();
            $v_data['all_case_types'] = $this->case_types_model->all_parent_case_types();

            $data['content'] = $this->load->view('case_types/edit_case_type', $v_data, true);
        }

        else
        {
            $data['content'] = 'Case Type does not exist';
        }

        $this->load->view('admin/layout/home', $data);
    }

    /*
    *
    *	Delete an existing Case Type
    *	@param int $case_type_id
    *
    */
    public function delete_case_type($case_type_id)
    {
        if($this->case_types_model->delete_case_type($case_type_id))
        {
            $this->session->set_userdata('success_message', 'Case Type has been deleted');
        }

        else
        {
            $this->session->set_userdata('error_message', 'Case Type could not deleted');
        }
        redirect('administration/case_types');
    }
}
?>