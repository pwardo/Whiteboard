<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lecturer extends CI_Controller
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
            if (!$this->acl->hasPermission('access_lecturer') === TRUE)
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
     * Display a list of modules assigned to this lecturer
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param int       $user_id    The users id taken from session
     * 
     * @return array    return an array of modules data for specified user
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        
        $data['user_details'] = $this->users_model->get_user_details($user_id);  
               
        $data['my_modules'] = $this->modules_model->my_assigned_modules_list($user_id);
        $data['home_link'] = base_url() . 'lec';
        $data['title'] = 'Lecturer Section';
        
        $this->load->view('header_view', $data);
        $this->load->view('lec/home', $data);
        $this->load->view('footer_view');
    }

    /**
     * used to gather data associated with a module and display it to lec/module_edit 
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * @param int $module_id The id of module
     * @return array return an array of data for specidied module
     */
    public function manage_module($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'lec');
        }
        $user_id = $this->session->userdata('user_id');
        
        $data['user_details'] = $this->users_model->get_user_details($user_id);  
        $data['page_name'] = 'manage_module';
        
        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['home_link'] = base_url() . 'lec';
        $data['title'] = 'Lecturer Section';

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/module_edit', $data);
        $this->load->view('footer_view');
    }
}