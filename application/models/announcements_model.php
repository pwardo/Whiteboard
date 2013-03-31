<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Announcements_model extends CI_Model
{
    /*
     * Retrieve a list of notes associated with this module
     */

    public function announcements_list($module_id)
    {
        $this->db->select('*');
        $this->db->from('announcements');
        $this->db->where("module_id = '$module_id'");
        $this->db->order_by('id', 'desc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    public function create_new_announcement($module_id, $announcement_title, $announcement_content)
    {
        $data = array(
            'module_id' => $module_id,
            'title' => $announcement_title,
            'content' => $announcement_content
        );

        $this->db->insert('announcements', $data);
    }

    public function update_announcement($announcement_id, $announcement_title, $assessment_content)
    {
        $data = array(
            'title' => $announcement_title,
            'content' => $assessment_content,
            );
        
        $this->db->where('id', $announcement_id);
        $this->db->update('announcements', $data);
    }

}