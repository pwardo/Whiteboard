<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Students extends CI_Controller
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
            $module_id = (int) $this->uri->segment(4);

            if (!$this->acl->hasPermission('access_lecturer') === TRUE)
            {
                redirect(base_url() . 'logout');
            }
            elseif (empty($module_id))
            {
                redirect(base_url() . 'lec');
            }
            else
            {
                $this->load->model('modules_model');
                $this->load->model('users_model');
            }
        }
    }

    /**
     * retrieve a list of all students enrolled with this module
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       int         $module_id The id of module
     * @return      array       array of students data for specified module
     * @since 0.1
     */
    public function index($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'stu');
        }
        
        $user_id = $this->session->userdata('user_id');

        $data['page_name'] = 'students';

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['title'] = 'Lecturer Section';
//        echo 'students list for module number ' . $module_id;

        $data['module_students'] = $this->modules_model->enrolled_students_list($module_id);
        $data['home_link'] = base_url() . 'lec';

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/students_view', $data);
        $this->load->view('footer_view');
    }

    /*
     * @TODO - delete_students
     */

    public function delete_students($module_id)
    {
        echo 'students for module number ' . $module_id;
    }

}