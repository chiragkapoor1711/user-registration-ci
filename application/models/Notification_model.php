<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    public function add($user_id, $type, $message)
    {
        $data = array(
            'user_id' => $user_id,
            'type' => $type,
            'message' => $message
        );
        return $this->db->insert('notifications', $data);
    }

    public function get_recent($limit = 10)
    {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get('notifications')->result();
    }

    public function count_unread()
    {
        return $this->db
            ->where('is_read', 0)
            ->count_all_results('notifications');
    }

    public function mark_all_read()
    {
        $this->db->where('is_read', 0);
        return $this->db->update('notifications', ['is_read' => 1]);
    }
}