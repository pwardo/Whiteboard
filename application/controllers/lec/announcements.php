<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Announcements extends CI_Controller
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
                $this->load->model('announcements_model');
                $this->load->model('modules_model');
                $this->load->model('users_model');
            }
        }
    }

    /**
     * retrieve a list of all announcments associated with this module
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       int         $module_id The id of module
     * @return      array       array of announcements data for specified module
     * @since 0.1
     */
    public function index($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'lec');
        }
        
        $user_id = $this->session->userdata('user_id');

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['title'] = 'Lecturer Section';

//        $data['page_name'] = 'announcements';

        $data['module_announcements'] = $this->announcements_model->announcements_list($module_id);
        $data['home_link'] = base_url() . 'lec';

        $data['page_name'] = 'announcements';

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/announcements_view', $data);
        $this->load->view('footer_view');
    }

    // --------------- Make an Announcement ---------------------------------------
    /**
     * used by the "make_announcement" button on lec/announcements_view.
     * If all fields pass validation then the form data is submitted to the announcements model
     * to be inserted into the database
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             make_announcement_form
     * 
     * @param int           $module_id                  The module id that this announcement will be associated with
     * @param string        $announcement_title         The title for the announcement
     * @param string        $announcement_content     
     */
    public function add_announcement()
    {
        $module_id = $this->input->post('moduleID');
        $announcement_title = strip_tags($this->input->post('announcementTitle'));
        $announcement_content = strip_tags($this->input->post('announcementContent'));

        if ($this->check_announcement_title($announcement_title)
                && $this->check_announcement_content($announcement_content))
        {
            //if all check are ok, then send data to the model
            $this->announcements_model->create_new_announcement($module_id, $announcement_title, $announcement_content);
            echo 'everything is good to go';
        }
        else
        {
            echo '<br/> Error: Form was not submitted.';
        }
    }

    /**
     * used by the "edit" button shown under each announcement on lec/announcements.
     * If all fields pass validation then the form data is submitted to the announcement model
     * to update that specific announcement
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             edit_announcement_form
     * 
     * @param int           $announcement_id            The id of the announcement to be edited
     * @param int           $module_id                  The module id that this announcement will be associated with
     * @param string        $announcement_title         The title for the announcement
     * @param string        $announcement_content
     */
    public function edit_announcement()
    {
        $announcement_id = $this->input->post('announcementID');
        $announcement_title = strip_tags($this->input->post('announcementTitle'));
        $announcement_content = strip_tags($this->input->post('announcementContent'));
        $module_id = $this->input->post('moduleID');

        if ($this->check_announcement_title($announcement_title)
                && $this->check_announcement_content($announcement_content))
        {
            //if all check are ok, then send data to the model
            $this->announcements_model->update_announcement($announcement_id, $announcement_title, $announcement_content);

            echo 'everything is good to go';
        }
        else
        {
            echo '</br>Error: Form was not submitted.';
        }
    }

    // --------------- ajax form feild checks for announcements ---------------------------------------
    /**
     * used to check announcement title
     * This function is part of ajax forms on lec/announcements_view  
     * 
     * @author     Patrick Ward
     * @version    0.1
     *  
     * used by:             add_announcement_form,
     *                      edit_announcement_form
     * 
     * @param string        $announcementTitle
     * 
     * @return boolean      True or error message
     */
    public function check_announcement_title()
    {
        $this->form_validation->set_rules('announcementTitle', 'Announcement Title', 'trim|required|xss_clean|min_length[5]|max_length[55]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Title must be between 5 and 55 characters.');
        }
        else
        {
            return true;
        }
    }

    /**
     * used to check announcementContent lenght < 255
     * This function is part of ajax forms on lec/announcements_view  
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             add_announcement_form,
     *                      edit_announcement_form
     *  
     * @param string        $announcementContent
     * 
     * @return boolean      True or error message
     */
    public function check_announcement_content()
    {
        $this->form_validation->set_rules('announcementContent', 'Announcement Content', 'min_length[5]|required|trim|xss_clean|max_length[500]');

        if ($this->form_validation->run() == FALSE)
        {
            print('Content is required and must be less than 500 characters.');
        }
        else
        {
            return TRUE;
        }
    }

}