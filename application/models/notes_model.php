<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notes_model extends CI_Model
{
    /*
     * Retrieve a list of notes associated with this module
     */

    public function notes_list($module_id)
    {
        $this->db->select('*');
        $this->db->from('notes');
        $this->db->where("module_id = '$module_id'");
//        $this->db->limit($per_page, $row);
        $this->db->order_by('id', 'desc');

        $query = $this->db->get()->result_array();

        return $query;
    }

    /*
     *  @TODO
     *  Add notes data to the database so tha notes can be retrieved later.
     */

    public function add_notes($module_id, $upload_data)
    {
        $this->db->insert('notes', array(
            'file_name' => $upload_data['file_name'],
            'file_path' => $upload_data['file_path'],
            'module_id' => $module_id
        ));
    }
}