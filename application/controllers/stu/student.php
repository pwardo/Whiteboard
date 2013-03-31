<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends CI_Controller
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
            if (!$this->acl->hasPermission('access_student') === TRUE)
            {
                redirect(base_url() . 'logout');
            }
            else
            {
                $this->load->model('modules_model');
                $this->load->model('assignments_model');
                $this->load->model('exams_model');
                $this->load->model('notes_model');
                $this->load->model('users_model');
                $this->load->model('announcements_model');
            }
        }
    }

    /**
     * Overview:        Display a list of modules this student has enrolled to
     * 
     * @used by:        controller/stu/student/index()
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $user_id        The users id taken from session
     * @param           int             $user_id        description
     * @param           int             $module_id      description
     *
     * @return          array           return an array of modules data for specified user
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['my_modules'] = $this->modules_model->my_enrolled_modules_list($user_id);
        $data['home_link'] = base_url() . 'stu';
        $data['title'] = 'Student Section';

        $data['page_name'] = 'module_home';

        $this->load->view('stu/module_header_view', $data);
        $this->load->view('stu/home', $data);
        $this->load->view('footer_view');
    }

    /**
     * Overview:        Display a list of all modules to allow students to choose
     *                  modules they wish to enroll to.
     * 
     * @used by:        nav bar -> find modules
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     *
     * @return          array           return an array of modules data
     */
    public function all_modules()
    {
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['my_modules'] = $this->modules_model->my_enrolled_modules_list($user_id);

        $data['all_modules'] = $this->modules_model->get_all_modules();
        $data['home_link'] = base_url() . 'stu';
        $data['title'] = 'Student Section';

        $data['page_name'] = 'find_modules';

        $this->load->view('stu/module_header_view', $data);
        $this->load->view('stu/all_modules_list', $data);
        $this->load->view('footer_view');
    }

    /**
     * Overview:        view details of a spcific module
     * 
     * @used by:        students home view, selecting a module from the list 
     *                  of enrolled modules
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      The selected modules id
     *
     * @return          array           return an array of modules data for specified user
     */
    public function module_selected($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'stu');
        } 
        
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['module_lecturer'] = $this->modules_model->module_lecturer($module_id);
        $data['module_assignments'] = $this->assignments_model->assignments_list($module_id);
        $data['module_exams'] = $this->exams_model->exams_list($module_id);
        $data['module_notes'] = $this->notes_model->notes_list($module_id);
        $data['module_announcements'] = $this->announcements_model->announcements_list($module_id);

        $data['home_link'] = base_url() . 'stu';
        $data['title'] = 'Student Section';

        $data['page_name'] = 'module_selected';

        $this->load->view('stu/module_header_view', $data);
        $this->load->view('stu/module_view', $data);
        $this->load->view('footer_view');
    }

    /**
     * Overview:        student chooses to enroll to a module
     * 
     * @used by:        find Modules View -> Choose "Enroll" from the list of modules
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      The selected modules id
     * 
     */
    public function module_enroll($module_id)
    {
        $user_id = $this->session->userdata('user_id');

        $this->modules_model->module_enrollment($module_id, $user_id);

        /*
         * After inserting data, redirect user back to previous list.
         */
        $this->all_modules();
    }

    /**
     * Overview:        student chooses to un-enroll to a module
     * 
     * @used by:        find Modules View -> Choose "Un-Enroll" from the list of modules
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      The selected modules id
     * 
     */
    public function module_un_enroll($module_id)
    {
        $user_id = $this->session->userdata('user_id');

        $this->modules_model->module_un_enrollment($module_id, $user_id);

        /*
         * After deleting data, redirect user back to previous list.
         */
        $this->all_modules();
    }

}