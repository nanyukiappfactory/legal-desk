<?php
class Laikipiaauth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/auth_model');
        $this->load->model('admin/site_model');
        $this->load->model('merchants/merchants_model');
    }

    public function index()
    {

        if (!$this->auth_model->check_login()) {
            redirect('login');
        } else {
            redirect('reports/transactions');
        }
    }

    /*
     *
     *    Login a user
     *
     */
    public function login_admin()
    {
        // //form validation rules

        //1. form validation rules
        if (($this->input->post('user_email') == 'admin@admin.com') && ($this->input->post('user_password') == '123456')) 
        {
            $this->form_validation->set_rules('user_email', 'Email address', 'required|valid_email');
            $this->form_validation->set_rules('user_password', 'Password', 'required');
        } 
        else 
        {
            $this->form_validation->set_rules('user_email', 'Email address', 'required|valid_email');
            $this->form_validation->set_rules('user_password', 'Password', 'required');
        }

        $this->form_validation->set_rules('user_email', 'Email address', 'required|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required');

        //2. Check if validaion rules pass
        if ($this->form_validation->run()) {
            //     //login hack
            if (($this->input->post('user_email') == 'admin@admin.com') && ($this->input->post('user_password') == '123456'))  {
                $newdata = array(
                    'login_status' => true,
                    'first_name' => 'Admin',
                    'other_names' => 'Admin',
                    'username' => 'laikipia-schools',
                    'personnel_type_id' => '1',
                    'personnel_id' => 0,
                );

                $this->session->set_userdata($newdata);

                $personnel_type_id = $this->session->userdata('personnel_type_id');

                if (!empty($personnel_type_id) && ($personnel_type_id != 1)) 
                {
                    redirect('laikipiaschools/schools');
                    // $l_data['title'] = "Welcome";
                    // $l_data["content"] = "";
                    // $this->load->view("laikipiaschools/layouts/layout", $l_data);
                } 
                else 
                {
                    redirect('laikipiaschools/schools');
                    // $l_data['title'] = "Welcome";
                    // $l_data["content"] = "";
                    // $this->load->view("laikipiaschools/layouts/layout", $l_data);
                }
            } 
            else if ($this->auth_model->validate_personnel()) 
            {
                redirect('laikipiaschools/schools');
                // $l_data['title'] = "Welcome";
                // $l_data["content"] = "";
                // $this->load->view("laikipiaschools/layouts/layout", $l_data);
            }

            else
            {
                $this->session->set_flashdata('error', 'The Email address or password provided is incorrect. Please try again');
            }
        }

        //3. Condition of validation rules failed
        else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_flashdata("error", $validation_errors);
            }

            $V_data['title'] = 'Admin Login';
            $data = array(
                "title" => "Admin Login",
                "content" => $this->load->view("auth/templates/laikipialogin", $V_data, true),
                "login" => true,
            );

            $this->load->view("auth/layouts/login", $data);
        }
        //4. load login view
        // $V_data['title'] = 'Admin Login';
        // $data = array(
        //     "title" => "Admin Login",
        //     "content" => $this->load->view("auth/templates/laikipialogin", $V_data, true),
        //     "login" => true,
        // );

        // $this->load->view("auth/layouts/login", $data);
    }

    public function logout()
    {
        $personnel_id = $this->session->userdata('personnel_id');

        // if($personnel_id > 0)
        // {
        //     $session_log_insert = array(
        //         "personnel_id" => $personnel_id,
        //         "session_name_id" => 2
        //     );
        //     $table = "session";
        //     if($this->db->insert($table, $session_log_insert))
        //     {
        //     }

        //     else
        //     {
        //     }
        // }
        $this->session->sess_destroy();
        redirect('login');
    }

    /*
     *
     *    Dashboard
     *
     */
    public function dashboard()
    {
        if (!$this->auth_model->check_login()) {
            redirect('login');
        } else {
            $this->load->model('hr/personnel_model');
            $personnel_id = $this->session->uesrdata('personnel_id');
            $personnel_roles = $this->personnel_model->get_personnel_roles($personnel_id);

            $data['title'] = $this->site_model->display_page_title();
            $v_data['title'] = $data['title'];

            $data['content'] = $this->load->view('dashboard', $v_data, true);

            $this->load->view('admin/admin/layout/home', $data);
        }
    }

    public function is_logged_in()
    {
        if (!$this->auth_model->check_login()) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function login_merchant()
    {
        //Validation rules
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        // $this->form_validation->set_message("exists_partial", "Phone number does not exist");

        //If validation rules are passed
        if ($this->form_validation->run()) {
            //Get form values
            $merchant_num = $this->input->post('phone');
            $merchant_password = $this->input->post('password');

            //Format merchant phone number
            $phone_number = $this->site_model->format_phone_number($merchant_num);

            //Check if merchant exists
            $result = $this->merchants_model->fetch_merchant($phone_number, $merchant_password);

            if ($result->num_rows() > 0) {
                $merchant_details = $result->row();
                $session_data = array(
                    'merchant_login_status' => true,
                    'phoneNumber' => $phone_number,
                    'cell' => $merchant_details->cell,
                    'firstName' => $merchant_details->firstName,
                    'lastName' => $merchant_details->lastName,
                    'merchantId' => $merchant_details->id,
                );
                $this->session->set_userdata($session_data);

                if ($merchant_password == "123456") {
                    redirect("merchant/change-password");
                } else {
                    redirect("mpesa/profile");
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid phone or password');
            }
        } else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_flashdata('error', $validation_errors);
            }
        }
        $data['title'] = "Merchant Login";

        $this->load->view("auth/templates/login", $data);
    }

    public function logout_merchant()
    {
        $this->session->sess_destroy();
        redirect('merchant/login');
    }

    public function ssh()
    {
        redirect("auth/login_merchant");
    }
}
