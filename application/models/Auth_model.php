<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function register_user($data)
    {
        return $this->db->insert('login_users', $data);
    }

    public function check_login($username)
    {
        return $this->db
                    ->where('username', $username)
                    ->get('login_users')
                    ->row();
    }

    // NEW: get all login accounts (for admin's manage-users panel)
    public function get_all_login_users()
    {
        return $this->db->get('login_users')->result();
    }

    // NEW: get one login account by id
    public function get_login_user($id)
    {
        return $this->db
                    ->where('id', $id)
                    ->get('login_users')
                    ->row();
    }

    // NEW: update only the role of a login account
    public function update_role($id, $role)
    {
        $this->db->where('id', $id);
        return $this->db->update('login_users', array('role' => $role));
    }

    // NEW: check if a username already exists (used when admin adds a user)
    public function username_exists($username)
    {
        return $this->db
                    ->where('username', $username)
                    ->get('login_users')
                    ->row();
    }

    // NEW: update password for a given user id
    public function update_password($id, $hashed_password)
    {
        $this->db->where('id', $id);
        return $this->db->update('login_users', array('password' => $hashed_password)); 
    }
}