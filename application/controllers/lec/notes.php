<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notes extends CI_Controller
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
                $this->load->model('notes_model');
                $this->load->model('modules_model');
                $this->load->model('users_model');
            }
        }
    }

    /**
     * retrieve a list of all notes associated with this module
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       int         $module_id The id of module
     * @return      array       array of notes data for specified module
     * @since 0.1
     */
    public function index($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'lec');
        }
        
        $user_id = $this->session->userdata('user_id');

        $data['page_name'] = 'notes';

        $data['user_details'] = $this->users_model->get_user_details($user_id);
        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['title'] = 'Lecturer Section';
//        echo 'notes list for module number ' . $module_id;

        $data['module_notes'] = $this->notes_model->notes_list($module_id);
        $data['home_link'] = base_url() . 'lec';

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/notes_view', $data);
        $this->load->view('footer_view');
    }

    /*
     * @todo - add view, download and delete to notes list
     * @todo - upload_notes will option diplayed at bottom of list
     */

    public function view_notes_description()
    {
        echo 'view_notes_description' . $module_id;
    }

    /*
     *  *************
     *  NOTES SECTION
     *  *************
     */

    /**
     * add_notes() and do_upload() are used to upload new notes that
     * will then be added to the list of notes diplayed by index()
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       file     a file of an allowable type to be uploaded
     * @since       0.1
     */
    function add_notes($module_id = NULL)
    {
        if (empty($module_id))
        {
            redirect(base_url() . 'lec');
        }
        
        $user_id = $this->session->userdata('user_id');

        $data['page_name'] = 'notes';

        $data['user_details'] = $this->users_model->get_user_details($user_id);

        $data['module_details'] = $this->modules_model->module_details($module_id);
        $data['home_link'] = base_url() . 'lec';
        $data['title'] = 'Lecturer Section';

        $this->load->view('lec/module_header_view', $data);
        $this->load->view('lec/upload_notes_form', array('error' => ' ', 'module_id' => $module_id));
        $this->load->view('footer_view');
    }

    function do_upload()
    {
        $module_id = (int) $this->uri->segment(4);

        $path = "uploads/module_notes/$module_id";

        if (!is_dir($path)) //create the folder if it's not already exists
        {
            mkdir($path, 0777, TRUE);
        }

        $config['upload_path'] = './' . $path . '/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|odt|ods|odp|odg';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['remove_spaces'] = 'true';
        $config['overwrite'] = 'TRUE';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload())
        {
            
            $error = array('error' => $this->upload->display_errors());

            $data['module_details'] = $this->modules_model->module_details($module_id);
            $data['home_link'] = base_url() . 'lec';

            $this->load->view('header_view', $data);
            $this->load->view('lec/upload_notes_form', $error);
            $this->load->view('footer_view');
        }
        else
        {
            $upload_data = $this->upload->data();
            $this->notes_model->add_notes($module_id, $upload_data);
//            $data = array('upload_data' => $this->upload->data());

            redirect(base_url() . 'lec/notes/index/' . $module_id);
        }
    }

    /*
     * @TODO - delete_notes
     */

    public function delete_notes($module_id)
    {
        echo 'notes for module number ' . $module_id;
    }

}