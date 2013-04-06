<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
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
                $this->load->model('users_model');
                $this->load->model('modules_model');
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
        $data['home_link'] = base_url() . 'adm';
        $data['title'] = 'Admin Section';
        
        $this->load->view('header_view', $data);
        $this->load->view('adm/home', $data);
        $this->load->view('footer_view');
    }
}