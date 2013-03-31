<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('login_view');
    }

    public function validate()
    {
        // field name, error message, validation rules
        $this->form_validation->set_rules('yourUsername', 'User Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('yourPassword', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            print("All field are required");
        }
        else
        {
            $username = strip_tags($this->input->post('yourUsername'));
            $password = strip_tags($this->input->post('yourPassword'));

            $this->load->model('login_model');

            $valid = $this->login_model->get_user($username, $password);

            if (!$valid)
            {
                print("Invalid Username or password");
            }
            else
            {
                //Valid username and password combination
                //Add user_id to session data
//                $this->session->userdata['user_id'];

                // send messaage back to login page for ajax redirect
                print("Valid");
            }
        }
    }

    // when user has logged in successfully, the ajax function redirects to access control
    public function access_control()
    {
        //         echo "<pre>";
        // print_r($this->session->userdata);
        // get user permissions
        $config['user_id'] = $this->session->userdata['user_id'];
        $this->load->library('acl', $config);

//        Redirect user deoending on their permissions
        if ($this->acl->hasPermission('access_system') === TRUE)
        {
            redirect(base_url() . 'sys/system_admin');
        }
        else if ($this->acl->hasPermission('access_admin') === TRUE)
        {
            redirect(base_url() . 'adm/admin');
        }
        else if ($this->acl->hasPermission('access_lecturer') === TRUE)
        {
            redirect(base_url() . 'lec/lecturer');
        }
        else if ($this->acl->hasPermission('access_student') === TRUE)
        {
            redirect(base_url() . 'stu/student');
        }
    }
}