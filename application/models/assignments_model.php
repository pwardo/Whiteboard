<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assignments_model extends CI_Model
{
    /*
     * Retrieve a list of assignments associated with this module
     */

    public function assignments_list($module_id)
    {
        $this->db->select('
            assignments.id              as id,
            assignments.module_id       as module_id,
            assignments.title           as title,
            assignments.description     as description,
            assignments.date            as date,
            assignments.created_on       as created_on,
            assignments.assessment_weighting        as assessment_weighting,
            assignment_docs.file_name               as file_name,
            assignment_docs.file_path               as file_path,

        ');
        $this->db->from('assignments');
        $this->db->join('assignment_docs', 'assignments.id = assignment_docs.assignment_id', 'left');
        $this->db->where("assignments.module_id = '$module_id'");
        $this->db->order_by('id', 'desc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    public function add_assignment_document($assignment_id, $upload_data)
    {
        $this->db->insert('assignment_docs', array(
            'file_name' => $upload_data['file_name'],
            'file_path' => $upload_data['file_path'],
            'assignment_id' => $assignment_id
        ));
    }

    /**
     * Add assignment data to the database so that assignment details can be retrieved later.
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             add_assignment_form
     * 
     * @param int           $module_id                  The module id that this assignment will be associated with
     * @param string        $assessment_title           The title for the assignment
     * @param date          $assessment_date            The date for the assignment
     * @param int           $assessment_weighting       Allocation of Continuous Assessment Weighting
     * @param string        $assessment_description     An optional description for the assignment
     */
    public function create_new_assignment($module_id, $assessment_title, $assessment_date, $assessment_weighting, $assessment_description)
    {
        $this->db->insert('assignments', array(
            'module_id' => $module_id,
            'title' => $assessment_title,
            'date' => $assessment_date,
            'assessment_weighting' => $assessment_weighting,
            'description' => $assessment_description
        ));
    }

    /**
     * update assignment data in the database.
     * 
     * @author     Patrick Ward
     * @version    0.1
     * 
     * used by:             edit_assignment_form
     *  
     * @param int           $module_id                  The module id that this assignment will be associated with
     * @param string        $assessment_title           The title for the assignment
     * @param date          $assessment_date            The date for the assignment
     * @param int           $assessment_weighting       Allocation of Continuous Assessment Weighting
     * @param string        $assessment_description     An optional description for the assignment
     * @since 0.1
     */
    public function update_assignment($assignment_id, $assessment_title, $assessment_date, $assessment_weighting, $assessment_description)
    {
        $data = array(
            'title' => $assessment_title,
            'date' => $assessment_date,
            'assessment_weighting' => $assessment_weighting,
            'description' => $assessment_description
        );

        $this->db->where('id', $assignment_id);
        $this->db->update('assignments', $data);
    }

    /**
     * Get the assessment weighting field for each of the assignments in specificied module
     * except for the current assignment if one is specified.
     * Used by controller to check that continuous assessment does not exceed 100%
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             lec/check_assessment_weighting
     * 
     * @param int           $module_id                  The module id that this assignment is be associated with
     * @param int           $assignment_id              The assignment ID
     * 
     * @return array
     */
    public function get_assignments_weighting($assignment_id, $module_id)
    {
        $this->db->select('assessment_weighting');
        $this->db->from('assignments');
        $this->db->where('assignments.module_id = ' . $module_id);
        if (!empty($assignment_id))
        {
            $this->db->where('assignments.id != ' . $assignment_id);
        }

        $query = $this->db->get();
        return $query->result();
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
    public function assignment_details($assignment_id)
    {
        $this->db->select('*');
        $this->db->from('assignments');
        $this->db->where("id = '$assignment_id'");

        $query = $this->db->get()->row_array();

        return $query;
    }

}