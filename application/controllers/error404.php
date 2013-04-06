<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error404 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_id'))
        {
            //echo "You are not logged in";
            redirect(base_url() . 'login');
        }
        else
        {
            $this->load->model('users_model');
        }
    }

    public function index()
    {
        $config['user_id'] = $this->session->userdata['user_id'];
        $this->load->library('acl', $config);

//        Redirect user deoending on their permissions
        if ($this->acl->hasPermission('access_system') === TRUE)
        {
            $this->system_user_error_page();
        }
        else if ($this->acl->hasPermission('access_admin') === TRUE)
        {
            $this->admin_user_error_page();
        }
        else if ($this->acl->hasPermission('access_lecturer') === TRUE)
        {
            $this->lecturer_user_error_page();
        }
        else if ($this->acl->hasPermission('access_student') === TRUE)
        {
            $this->student_user_error_page();
        }
    }

    public function system_user_error_page()
    {
        
    }

    public function admin_user_error_page()
    {
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['home_link'] = base_url() . 'adm';
        $data['title'] = 'Admin Section';

        $this->load->view('header_view', $data);
        $this->load->view('error404_view', $data);
        $this->load->view('footer_view');
    }

    public function lecturer_user_error_page()
    {
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);

        $data['home_link'] = base_url() . 'lec';
        $data['title'] = 'Lecturer Section';

        $this->load->view('header_view', $data);
        $this->load->view('error404_view', $data);
        $this->load->view('footer_view');
    }

    public function student_user_error_page()
    {
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['home_link'] = base_url() . 'stu';
        $data['title'] = 'Student Section';

        $data['page_name'] = 'module_home';

        $this->load->view('stu/module_header_view', $data);
        $this->load->view('error404_view', $data);
        $this->load->view('footer_view');
    }

}

