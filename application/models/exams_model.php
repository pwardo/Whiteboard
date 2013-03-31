<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exams_model extends CI_Model
{
    /*
     * Retrieve a list of assignments associated with this module
     */

    public function exams_list($module_id)
    {
        $this->db->select('*');
        $this->db->from('exams');
        $this->db->where("module_id = '$module_id'");
//        $this->db->limit($per_page, $row);
        $this->db->order_by('date', 'asc');
        $this->db->order_by('start_time', 'asc');
        $this->db->order_by('end_time', 'asc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /**
     * Add exam data to the database so that exam details can be retrieved later.
     * 
     * @author              Patrick Ward
     * @version             0.1
     * 
     * used by:             schedule_exam_form
     * 
     * @param int           $module_id                  The module id that this exam will be associated with
     * @param string        $assessment_title           The title for the exam
     * @param date          $assessment_date            The date for the exam
     * @param time          $exam_start_time            The exam's start time
     * @param time          $exam_end_time              The exam's finish time
     * @param int           $assessment_weighting       An optional description for the exam
     * @param string        $assessment_description     An optional description for the exam
     * @since 0.1
     */
    public function create_new_exam($module_id, $assessment_title, $assessment_date, $exam_start_time, $exam_end_time, $assessment_weighting, $assessment_description)
    {
        $this->db->insert('exams', array(
            'module_id' => $module_id,
            'title' => $assessment_title,
            'date' => $assessment_date,
            'start_time' => $exam_start_time,
            'end_time' => $exam_end_time,
            'assessment_weighting' => $assessment_weighting,
            'description' => $assessment_description
        ));
    }

    /**
     * update exam data in the database.
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             edit_exam_form
     * 
     * @param int           $module_id                  The module id that this exam will be associated with
     * @param string        $assessment_title           The title for the exam
     * @param date          $assessment_date            The date for the exam
     * @param time          $exam_start_time            The exam's start time
     * @param time          $exam_end_time              The exam's finish time
     * @param int           $assessment_weighting       An optional description for the exam
     * @param string        $assessment_description     An optional description for the exam
     */
    public function update_exam($exam_id, $assessment_title, $assessment_date, $exam_start_time, 
            $exam_end_time, $assessment_weighting, $assessment_description)
    {
        $data = array(
            'title' => $assessment_title,
            'date' => $assessment_date,
            'start_time' => $exam_start_time,
            'end_time' => $exam_end_time,
            'assessment_weighting' => $assessment_weighting,
            'description' => $assessment_description
        );

        $this->db->where('id', $exam_id);
        $this->db->update('exams', $data);
    }

    
    
    /**
     * Get the assessment weighting field for each of the exams in specificied module
     * except for the current exam if one is specified.
     * Used by controller to check that continuous assessment does not exceed 100%
     * 
     * @author              Patrick Ward
     * @version             0.1
     *  
     * used by:             lec/check_assessment_weighting
     * 
     * @param int           $module_id                  The module id that this exam is be associated with
     * @param int           $exam_id                    The exam ID
     * 
     * @return array
     */
    public function get_exams_weighting($exam_id, $module_id)
    {
//        echo 'GOT HERE TOO';
        $this->db->select('assessment_weighting');
        $this->db->from('exams');
        $this->db->where('exams.module_id = '. $module_id);
        if(!empty($exam_id))
        {
            $this->db->where('exams.id != '. $exam_id);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
}