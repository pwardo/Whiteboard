<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modules_model extends CI_Model
{

    var $logged;

    function __construct()
    {
        parent::__construct();
        $this->logged = 'yes';
    }

    /**
     * Retrieves the data for all modules
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * used by:     controller/stu/student/all_modules()
     * 
     * @return      array       returns an multi-dimensional array of all modules
     */
    public function get_all_modules()
    {
        $this->db->select('
            modules.id          as id,
            modules.title       as title,
            modules.code        as code,
            modules.description as description,
            module_to_lecturer.user_id as user_id,
            user_details.first_name as first_name,
            user_details.last_name as last_name,
            
        ');

        $this->db->from('modules');
        $this->db->join('module_to_lecturer', 'module_to_lecturer.module_id = modules.id', 'left');
        $this->db->join('users', 'module_to_lecturer.user_id = users.id', 'left');
        $this->db->join('user_details', 'user_details.user_id = users.id', 'left');
//        $this->db->limit($per_page, $row);
        $this->db->order_by('modules.code', 'asc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * Retrieves the data for modules associated with this lecturer
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             controller/lec/lecturer/index()
     * 
     * @param int           $user_id          The user_id of the lecturer
     */
    public function my_assigned_modules_list($user_id)
    {
        $this->db->select('*');
        $this->db->from('module_to_lecturer');
        $this->db->join('modules', 'module_to_lecturer.module_id = modules.id', 'left');
        $this->db->where("module_to_lecturer.user_id = '$user_id'");
//        $this->db->limit($per_page, $row);
        $this->db->order_by('modules.code', 'asc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /*
     * **************************************************************************
     *                  ADMIN SPECIFIC FUNCTIONS
     * **************************************************************************
     */

    /**
     * called by controller adm/modules/edit_module
     * Retrieves the lecturer assigned to teach an individual module 
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             adm/modules/index()
     *                      
     * 
     * @param int           $user_id          The user_id of the lecturer
     */
    public function module_lecturer($module_id)
    {
        $this->db->select('
            module_to_lecturer.user_id  as user_id,
            user_details.first_name     as first_name,
            user_details.last_name     as last_name,
        ');
        $this->db->from('module_to_lecturer');
        $this->db->join('user_details', 'module_to_lecturer.user_id = user_details.user_id', 'left');
        $this->db->where("module_to_lecturer.module_id = '$module_id'");

        $query = $this->db->get()->row_array();

        return $query;
    }

    /**
     * called by controller/adm/modules/edit_module
     * Retrieves the details for a single module to populate manage module view
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * @param       int         $module_id      The id of module
     * 
     * @return      array       of data for specified module
     */
    public function module_details($module_id)
    {
        $this->db->select('*');
        $this->db->from('modules');
        $this->db->where("id = '$module_id'");

        $query = $this->db->get()->row_array();

        return $query;
    }

    /**
     * Overview:        updates the details of module
     * 
     * @used by:        controller/adm/modules/edit_module
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      module id
     * @param           string          $title          module title
     * @param           string          $code           module code (M001)
     * @param           string          $description    module description
     * @param           int             $user_id        lecturers user id
     *
     */
    public function module_create($title, $code, $description, $user_id)
    {
        $user_id = (int) $user_id;

        $this->db->trans_start();

        $data = array(
            'code' => $code,
            'title' => $title,
            'description' => $description
        );

        $this->db->insert('modules', $data);

        $module_id = $this->db->insert_id();

        $this->assigned_lecturer_to_module($module_id, $user_id);

        $this->db->trans_complete();
    }

    /**
     * Overview:        updates the details of module
     * 
     * @used by:        controller/adm/modules/edit_module
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      module id
     * @param           string          $title          module title
     * @param           string          $code           module code (M001)
     * @param           string          $description    module description
     * @param           int             $user_id        lecturers user id
     *
     */
    public function module_update($module_id, $title, $code, $description, $user_id)
    {
        $module_id = (int) $module_id;
        $user_id = (int) $user_id;

        $data = array(
            'title' => $title,
            'code' => $code,
            'description' => $description
        );

        $this->db->where('id', $module_id);
        $this->db->update('modules', $data);

        if ($this->module_has_lecturer($module_id) === true)
        {
            $this->update_assigned_lecturer($module_id, $user_id);
        }
        else
        {
            $this->assigned_lecturer_to_module($module_id, $user_id);
        }
    }

    /**
     * Overview:        Assign a lecturer to module
     * 
     * @used by:        $this->module_update()
     * 
     */
    public function assigned_lecturer_to_module($module_id, $user_id)
    {
        $data = array(
            'module_id' => $module_id,
            'user_id' => $user_id
        );
        $this->db->insert('module_to_lecturer', $data);
    }

    /**
     * Overview:        change the lecturer assigned to a module
     * 
     * @used by:        $this->module_update()
     * 
     */
    public function update_assigned_lecturer($module_id, $user_id)
    {
        $module_id = (int) $module_id;
        $user_id = (int) $user_id;

        $query = $this->db->query('
            UPDATE `module_to_lecturer` SET 
                `user_id`=' . $user_id . '
                    WHERE `module_id` = ' . $module_id
        );
    }

    /**
     * Overview:        check if module already has a lecturer 
     * 
     * @used by:        $this->module_update()
     * 
     */
    public function module_has_lecturer($module_id)
    {
        $this->db->where("module_id", $module_id);
        $query = $this->db->get("module_to_lecturer");
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
     * Overview:        checks if the module code entered already exists in database
     * 
     * @used by:        controller/adm/modules/check_module_code()
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      
     * @param           string          $module_code    
     *
     * @return          boolean          
     */
    public function is_code_unique($module_id, $module_code)
    {
        $this->db->where("code", $module_code);
        $this->db->where("id !=", $module_id);
        $query = $this->db->get("modules");
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
     * Overview:        Retrieve a list of all students enrolled for specified module
     * 
     * @used by:        controller/lec/students/index()
     * 
     * @author          Patrick Ward
     * @version         0.1
     * 
     * @param           int             $module_id      description
     * @param           int             $module_id      description
     *
     * @return          array           array of students details
     */
    public function enrolled_students_list($module_id)
    {
        $this->db->select('*');
        $this->db->from('module_to_student');

        $this->db->where("module_to_student.module_id = '$module_id'");
        
        $this->db->join('users', 'users.id = module_to_student.user_id', 'left');
        $this->db->join('user_details', 'user_details.user_id = users.id', 'left');        


        $this->db->order_by('users.id', 'asc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /*
     * **************************************************************************
     *                  STUDENT SPECIFIC FUNCTIONS
     * **************************************************************************
     */

    /**
     * Retrieves the data for modules associated with this student
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * used by:     controller/stu/student/index()
     * 
     * @param       int         $user_id        The user_id of the student
     * 
     * @return      array       returns an multi-dimensional array of modules data associated with student
     */
    public function my_enrolled_modules_list($user_id)
    {
        $this->db->select('
            modules.id          as id,
            modules.title       as title,
            modules.code        as code,
            modules.description as description,
            module_to_lecturer.user_id as user_id,
            user_details.first_name as first_name,
            user_details.last_name as last_name,    
        ');
        $this->db->from('module_to_student');
        $this->db->join('modules', 'module_to_student.module_id = modules.id', 'left');
        $this->db->join('module_to_lecturer', 'module_to_lecturer.module_id = modules.id', 'left');
        $this->db->join('users', 'module_to_lecturer.user_id = users.id', 'left');
        $this->db->join('user_details', 'user_details.user_id = users.id', 'left');
        $this->db->where("module_to_student.user_id = '$user_id'");
//        $this->db->limit($per_page, $row);
        $this->db->order_by('modules.code', 'asc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * Overview:    Creates an association between the student and the module
     *              when the student chooses to enroll to the module
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * used by:     controller/stu/student/module_enroll()
     * 
     * @param       int         $user_id        The user_id of the student, taken from the session
     * @param       int         $module_id      The module to be associated with the student
     * 
     */
    public function module_enrollment($module_id, $user_id)
    {
        $data = array(
            'module_id' => $module_id,
            'user_id' => $user_id
        );
        $this->db->insert('module_to_student', $data);
    }

    /**
     * Overview:    Deletes an association between the student and the module
     *              when the student chooses to Un-Enroll to the module
     * 
     * @author      Patrick Ward
     * @version     0.1
     * 
     * used by:     controller/stu/student/module_un_enroll()
     * 
     * @param       int         $user_id        The user_id of the student, taken from the session
     * @param       int         $module_id      The module to be associated with the student
     * 
     */
    public function module_un_enrollment($module_id, $user_id)
    {
        $this->db->where('module_id', $module_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('module_to_student');
    }

}