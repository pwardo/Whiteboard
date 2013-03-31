<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modules extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // make sure user has the correct permisson to access this controller
        if (!$this->session->userdata('user_id'))
        {
            //echo "You are not logged in";
            redirect(base_url() . 'login');
        }
        else
        {
            $config['user_id'] = $this->session->userdata['user_id'];
            $this->load->library('acl', $config);
            if (!$this->acl->hasPermission('access_admin') === TRUE)
            {
                redirect(base_url() . 'logout');
            }
            else
            {
                $this->load->model('modules_model');
                $this->load->model('users_model');
            }
        }
    }

    /**
     * Overview:        Display a list of all modules to allow admin
     * 
     * @used by:        nav bar -> find modules
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     *
     * @return          array           return an array of modules data
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        
        $data['user_details'] = $this->users_model->get_user_details($user_id);        
        $data['all_lecturers'] = $this->users_model->get_all_lecturers();

        $data['all_modules'] = $this->modules_model->get_all_modules();
        $data['home_link'] = base_url() . 'adm';
        $data['title'] = 'Admin Section';

        $this->load->view('header_view', $data);
        $this->load->view('adm/all_modules_list', $data);
        $this->load->view('footer_view');
    }

    /**
     * used to edit the title, code and description of a module
     * is used by to ajax form on adm/module_create  
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param string    $module_title           The title of module
     * @param string    $module_code            The code of module
     * @param string    $module_description     The description of module
     * @since 0.1
     */
    public function create_module()
    {
        // field name, error message, validation rules
        $this->form_validation->set_rules('moduleTitle', 'Module Title', 'trim|required|min_length[5]|max_length[55]');
        $this->form_validation->set_rules('moduleCode', 'Module Code', 'trim|required|xss_clean|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|required|xss_clean|min_length[4]|max_length[255]');

        if ($this->form_validation->run() == FALSE)
        {
            print('All fields are required.');
        }
        else
        {
            $module_title = strip_tags($this->input->post('moduleTitle'));
            $module_code = strip_tags($this->input->post('moduleCode'));
            $module_description = strip_tags($this->input->post('moduleDescription'));
            $user_id = $this->input->post('moduleLecturer');

            $this->modules_model->module_create($module_title, $module_code, $module_description, $user_id);

            // send the url back to ajax form for it to use for redirect
            print(base_url() . 'adm/modules/index');
        }
    }
    
    /**
     * used to edit the title, code and description of a module
     * is used by to ajax form on adm/module_edit  
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param int       $module_id              The id of module
     * @param string    $module_title           The title of module
     * @param string    $module_code            The code of module
     * @param string    $module_description     The description of module
     * @since 0.1
     */
    public function edit_module()
    {
        // field name, error message, validation rules
        $this->form_validation->set_rules('moduleTitle', 'Module Title', 'trim|required|min_length[5]|max_length[55]');
        $this->form_validation->set_rules('moduleCode', 'Module Code', 'trim|required|xss_clean|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|required|xss_clean|min_length[4]|max_length[255]');

        if ($this->form_validation->run() == FALSE)
        {
            print('All fields are required.');
        }
        else
        {
            $module_id = strip_tags($this->input->post('moduleID'));
            $module_title = strip_tags($this->input->post('moduleTitle'));
            $module_code = strip_tags($this->input->post('moduleCode'));
            $module_description = strip_tags($this->input->post('moduleDescription'));
            $user_id = $this->input->post('moduleLecturer');

            $this->modules_model->module_update($module_id, $module_title, $module_code, $module_description, $user_id);

            // send the url back to ajax form for it to use for redirect
            print(base_url() . 'adm/modules/index');
        }
    }

    /**
     * used to check module title
     * This function is part of ajax form on adm/module_edit  
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param string $moduleTitle
     * @since 0.1
     */
    function check_module_title()
    {
        $this->form_validation->set_rules('moduleTitle', 'Module Code', 'trim|required|xss_clean|min_length[5]|max_length[55]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Module title must be between 5 and 55 characters.');
        }
    }

    /**
     * used to check module code
     * This function is part of ajax form on amd/module_edit  
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param int $moduleID
     * @param string $moduleCode
     * @since 0.1
     */
    function check_module_code()
    {
        $this->form_validation->set_rules('moduleCode', 'Module Code', 'trim|required|xss_clean|min_length[4]|max_length[4]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Module Code must be between 4 characters long i.e. M001.');
        }
        else
        {
            $module_id = $this->input->post('moduleID');
            $module_code = $this->input->post('moduleCode');

            $result = $this->modules_model->is_code_unique($module_id, $module_code);
            if ($result)
            {
                print('This Module Code is already being used.');
            }
        }
    }

    /**
     * used to check module title
     * This function is part of ajax form on adm/module_edit  
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param string $moduleDescription
     * @since 0.1
     */
    function check_module_description()
    {
        $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|required|xss_clean|min_length[10]|max_length[255]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Module Description is required. <br/>
                And must be between 10 and 255 characters.');
        }
    }

}