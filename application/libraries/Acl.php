<?php
/*
 * Simple ACL Class for CodeIgniter
 * http://www.tastybytes.net/blog/simple-acl-class-for-codeigniter
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class acl {

    var $perms = array();  //Array : Stores the permissions for the user
    var $user_id;   //Integer : Stores the ID of the current user
    var $user_roles = array(); //Array : Stores the roles of the current user
    var $ci;

    function __construct($config = array()) {
        $this->ci = &get_instance();

        $this->user_id = floatval($config['user_id']);
        $this->user_roles = $this->getUserRoles();
        $this->buildACL();
    }

    function buildACL() {
        //first, get the rules for the user's role
        if (count($this->user_roles) > 0) {
            $this->perms = array_merge($this->perms, $this->getRolePerms($this->user_roles));
        }
        //then, get the individual user permissions
        $this->perms = array_merge($this->perms, $this->getUserPerms($this->user_id));
    }

    function getPermKeyFromID($perm_id) {
        //$strSQL = "SELECT `perm_key` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($perm_id) . " LIMIT 1";
        $this->ci->db->select('perm_key');
        $this->ci->db->where('id', floatval($perm_id));
        $sql = $this->ci->db->get('acl_perm', 1);
        $data = $sql->result();
        return $data[0]->perm_key;
    }

    function getPermNameFromID($perm_id) {
        //$strSQL = "SELECT `perm_name` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($perm_id) . " LIMIT 1";
        $this->ci->db->select('perm_name');
        $this->ci->db->where('id', floatval($perm_id));
        $sql = $this->ci->db->get('acl_perm', 1);
        $data = $sql->result();
        return $data[0]->perm_name;
    }

    function getRoleNameFromID($role_id) {
        //$strSQL = "SELECT `role_name` FROM `".DB_PREFIX."roles` WHERE `ID` = " . floatval($role_id) . " LIMIT 1";
        $this->ci->db->select('role_name');
        $this->ci->db->where('id', floatval($role_id), 1);
        $sql = $this->ci->db->get('acl_role');
        $data = $sql->result();
        return $data[0]->role_name;
    }

    function getUserRoles() {
        //$strSQL = "SELECT * FROM `".DB_PREFIX."acl_user_roles` WHERE `user_id` = " . floatval($this->user_id) . " ORDER BY `add_date` ASC";

        $this->ci->db->where(array('user_id' => floatval($this->user_id)));
        $this->ci->db->order_by('add_date', 'asc');
        $sql = $this->ci->db->get('acl_user_roles');
        $data = $sql->result();

        $resp = array();
        foreach ($data as $row) {
            $resp[] = $row->role_id;
        }
        return $resp;
    }

    function getAllRoles($format = 'ids') {
        $format = strtolower($format);
        //$strSQL = "SELECT * FROM `".DB_PREFIX."roles` ORDER BY `role_name` ASC";
        $this->ci->db->order_by('role_name', 'asc');
        $sql = $this->ci->db->get('acl_role');
        $data = $sql->result();

        $resp = array();
        foreach ($data as $row) {
            if ($format == 'full') {
                $resp[] = array("id" => $row->ID, "name" => $row->role_name);
            } else {
                $resp[] = $row->ID;
            }
        }
        return $resp;
    }

    function getAllPerms($format = 'ids') {
        $format = strtolower($format);
        //$strSQL = "SELECT * FROM `".DB_PREFIX."permissions` ORDER BY `perm_key` ASC";

        $this->ci->db->order_by('perm_key', 'asc');
        $sql = $this->ci->db->get('acl_perm');
        $data = $sql->result();

        $resp = array();
        foreach ($data as $row) {
            if ($format == 'full') {
                $resp[$row->perm_key] = array('id' => $row->ID, 'name' => $row->perm_name, 'key' => $row->perm_key);
            } else {
                $resp[] = $row->ID;
            }
        }
        return $resp;
    }

    function getRolePerms($role) {
        if (is_array($role)) {
            //$roleSQL = "SELECT * FROM `".DB_PREFIX."acl_role_perms` WHERE `role_id` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
            $this->ci->db->where_in('role_id', $role);
        } else {
            //$roleSQL = "SELECT * FROM `".DB_PREFIX."acl_role_perms` WHERE `role_id` = " . floatval($role) . " ORDER BY `ID` ASC";
            $this->ci->db->where(array('role_id' => floatval($role)));
        }
        $this->ci->db->order_by('id', 'asc');
        $sql = $this->ci->db->get('acl_role_perms'); //$this->db->select($roleSQL);
        $data = $sql->result();
        $perms = array();
        foreach ($data as $row) {
            $pK = strtolower($this->getPermKeyFromID($row->perm_id));
            if ($pK == '') {
                continue;
            }
            if ($row->value === '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK, 'inheritted' => true, 'value' => $hP, 'name' => $this->getPermNameFromID($row->perm_id), 'id' => $row->perm_id);
        }
        return $perms;
    }

    function getUserPerms($user_id) {
        //$strSQL = "SELECT * FROM `".DB_PREFIX."acl_user_perms` WHERE `user_id` = " . floatval($user_id) . " ORDER BY `add_date` ASC";

        $this->ci->db->where('user_id', floatval($user_id));
        $this->ci->db->order_by('add_date', 'asc');
        $sql = $this->ci->db->get('acl_user_perms');
        $data = $sql->result();

        $perms = array();
        foreach ($data as $row) {
            $pK = strtolower($this->getPermKeyFromID($row->perm_id));
            if ($pK == '') {
                continue;
            }
            if ($row->value == '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK, 'inheritted' => false, 'value' => $hP, 'name' => $this->getPermNameFromID($row->perm_id), 'id' => $row->perm_id);
        }
        return $perms;
    }

    function hasRole($role_id) {
        foreach ($this->user_roles as $k => $v) {
            if (floatval($v) === floatval($role_id)) {
                return true;
            }
        }
        return false;
    }

    function hasPermission($perm_key) {
        $perm_key = strtolower($perm_key);
        if (array_key_exists($perm_key, $this->perms)) {
            if ($this->perms[$perm_key]['value'] === '1' || $this->perms[$perm_key]['value'] === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}