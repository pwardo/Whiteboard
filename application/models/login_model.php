<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model
{
    var $logged;

    function __construct()
    {
        parent::__construct();
        $this->logged = 'yes';
    }

    public function get_user($username, $password)
    {   
        // search users table for this username
        $query = $this->db->get_where('users', array('username' => $username));

        // username is found
        if ($query->num_rows() > 0)
        {
            $query = $query->row_array();
            
            // get user id
            $user_id = $query['id'];

            // if user_id not set, then assign it
            if (!$this->session->userdata['user_id'])
            {
                $this->session->set_userdata('user_id', $user_id);
            }

            $user_username = $query['username'];
            $user_password = $query['password'];

            $password = sha1($password . HASH_KEY);
            if ($password != $user_password)
            {
                return false;
            }

            // check if passwords do match, then set session and log the user.
            else if (($password === $user_password))
            {
                $userdata = array('user_id' => $user_id, 'username' => $user_username);
                $this->session->set_userdata($userdata);
                $this->update_users_activity($user_id, $this->logged);

                return true;
            }
        }
        else
        {
            // if usernane is not found
            return false;
        }
    }

    function update_users_activity($user_id, $logged)
    {
        $this->db->where('id', $user_id);
        $this->db->update('users', array('logged_in' => $logged));
    }

    function update_session_start($user_id, $session_id)
    {
        $session_start = now();
        $this->db->where('session_id', $session_id);
        $this->db->update('ci_sessions', array('session_start' => $session_start, 'user_id' => $user_id));
    }

    function update_session_end($user_id, $session_id)
    {
        $session_end = now();
        $this->db->where('session_id', $session_id);
        $this->db->update('ci_sessions', array('session_end' => $session_end, 'user_id' => $user_id));
    }
}