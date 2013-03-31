<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get a single users details
     * 
     * @used by:        controllers/
     *                      adm/admin/index
     *                      lec/lecturer/index
     *                      stu/student/index
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @return          array          details of all lecturers
     */
    public function get_user_details($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_details', 'users.id = user_details.user_id', 'left');
        $this->db->where('users.id =' . $user_id);

        $query = $this->db->get()->row_array();

        return $query;
    }

    /**
     * Get a list of all lecturers
     * 
     * @used by:        controller/adm/Modules/index
     *                  controller/adm/Lecturers/index
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @return          array          details of all lecturers
     */
    public function get_all_lecturers()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_details', 'users.id = user_details.user_id', 'left');
        $this->db->where('users.user_role_id = 2');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * Get a list of all lecturers
     * 
     * @used by:        controller/adm/Students/index
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @return          array          details of all lecturers
     */
    public function get_all_students()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_details', 'users.id = user_details.user_id', 'left');
        $this->db->where('users.user_role_id = 3');
        $this->db->order_by('user_details.student_number', 'asc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * Overview:        updates the details of a user
     * 
     * @used by:        controller/adm/students/edit_student
     *                  controller/adm/lecturers/edit_lecturer
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $user_id      
     * @param           int             $student_number      
     * @param           string          $first_name       
     * @param           string          $last_name       
     * @param           date            $DoB            Date of Birth
     * @param           string          $email
     * @param           string          $username
     * @param           string          $password
     *
     */
    public function user_update($user_id, $student_number, $first_name, $last_name, $DoB, $email, $user_username, $user_pasword)
    {
        $user_id = (int) $user_id;

        $this->db->trans_start();

        $data = array(
            'username' => $user_username,
            'email' => $email,
            'password' => sha1($user_pasword . HASH_KEY),
//            'modified_on' => now()
        );

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);

        $data2 = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'dob' => $DoB,
            'student_number' => $student_number
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('user_details', $data2);

        $this->db->trans_complete();
    }

    /**
     * Overview:        adds a new user
     * 
     * @used by:        controller/adm/students/create_student
     *                  controller/adm/lecturers/create_lecturer
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $student_number      
     * @param           string          $first_name       
     * @param           string          $last_name       
     * @param           date            $DoB            Date of Birth
     * @param           string          $email
     * @param           string          $username
     * @param           string          $password
     */
    public function user_create($student_number, $first_name, $last_name, $DoB, $email, $user_username, $user_pasword, $user_role_id)
    {
        $this->db->trans_start();

        $data = array(
            'username' => $user_username,
            'email' => $email,
            'password' => sha1($user_pasword . HASH_KEY),
            'user_role_id' => $user_role_id,
        );

        $this->db->insert('users', $data);


        $user_id = $this->db->insert_id();

        $data2 = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'dob' => $DoB,
            'student_number' => $student_number,
            'user_id' => $user_id
        );

        $this->db->insert('user_details', $data2);

        $data3 = array(
            'user_id' => $user_id,
            'role_id' => $user_role_id,
        );

        $this->db->insert('acl_user_roles', $data3);

        $this->db->trans_complete();
    }

    /**
     * Overview:        checks if the student number is in already in database
     * 
     * @used by:        controller/
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $user_id
     * @param           int             $student_number
     *
     * @return          boolean
     */
    public function is_student_number_unique($user_id, $student_number)
    {
        $this->db->where("student_number", $student_number);
        $this->db->where("user_id !=", $user_id);
        $query = $this->db->get("user_details");
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Overview:        an overview of function
     * 
     * @used by:        controller/adm/students/check_email
     *                  controller/adm/lecturers/check_email
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      description
     *
     * @return          boolean         
     */
    public function is_user_email_unique($user_id, $user_email)
    {
        $this->db->where("email", $user_email);
        $this->db->where("id !=", $user_id);
        $query = $this->db->get("users");
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Overview:        an overview of function
     * 
     * @used by:        controller/adm/students/check_username
     *                  controller/adm/lecturers/check_username
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      description
     *
     * @return          boolean         
     */
    public function is_username_unique($user_id, $user_username)
    {
        $this->db->where("username", $user_username);
        $this->db->where("id !=", $user_id);
        $query = $this->db->get("users");
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
