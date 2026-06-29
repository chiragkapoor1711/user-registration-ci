<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function insert_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }


    public function get_all_users($limit = NULL, $offset = NULL)
    {
        $this->db->select("
        users.*,
        qualification_master.qualification_name AS qualification,
        education.college,
        education.passing_year,
        GROUP_CONCAT(DISTINCT skill_master.skill_name SEPARATOR ', ') AS skill_names,
        GROUP_CONCAT(DISTINCT employment_type_master.type_name SEPARATOR ', ') AS employment_names,
        GROUP_CONCAT(DISTINCT location_master.location_name SEPARATOR ', ') AS location_names
    ");

        $this->db->from('users');
        $this->db->join('education', 'education.user_id = users.id', 'left');
        $this->db->join('qualification_master', 'qualification_master.id = education.qualification_id', 'left');
        $this->db->join('user_skills', 'user_skills.user_id = users.id', 'left');
        $this->db->join('skill_master', 'skill_master.id = user_skills.skill_id', 'left');
        $this->db->join('user_employment_type', 'user_employment_type.user_id = users.id', 'left');
        $this->db->join('employment_type_master', 'employment_type_master.id = user_employment_type.employment_type_id', 'left');
        $this->db->join('user_locations', 'user_locations.user_id = users.id', 'left');
        $this->db->join('location_master', 'location_master.id = user_locations.location_id', 'left');

        $this->db->group_by('users.id');
        $this->db->order_by('users.id', 'DESC');

        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    // Total count ke liye alag method — pagination library ko total records chahiye
    public function count_all_users()
    {
        return $this->db->count_all('users');
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
    public function get_user($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('users')
            ->row();
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function save_education($user_id, $data)
    {
        $education = $this->db
            ->where('user_id', $user_id)
            ->get('education')
            ->row();

        if ($education) {
            $this->db->where('user_id', $user_id);
            return $this->db->update('education', $data);
        } else {
            $data['user_id'] = $user_id;
            return $this->db->insert('education', $data);
        }
    }


    public function get_qualification_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('qualification_master')
            ->row();
    }


    public function get_skill($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->get('skills')
            ->row();
    }

    public function save_skill($user_id, $data)
    {
        $skill = $this->get_skill($user_id);

        if ($skill) {

            $this->db->where('user_id', $user_id);
            return $this->db->update('skills', $data);

        } else {

            $data['user_id'] = $user_id;
            return $this->db->insert('skills', $data);
        }
    }

    public function update_education($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('education', $data);
    }

    public function update_skill($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('skills', $data);
    }

    public function get_education($user_id)
    {
        $this->db->select('
        education.*,
        qualification_master.qualification_name
    ');

        $this->db->from('education');

        $this->db->join(
            'qualification_master',
            'qualification_master.id = education.qualification_id',
            'left'
        );

        $this->db->where('education.user_id', $user_id);

        return $this->db->get()->row();
    }

    public function get_user_by_login_id($login_user_id)
    {
        return $this->db
            ->where('login_user_id', $login_user_id)
            ->get('users')
            ->row();
    }

    public function get_qualifications()
    {
        return $this->db
            ->order_by('qualification_name', 'ASC')
            ->get('qualification_master')
            ->result();
    }


    public function get_degrees($qualification_id)
    {
        return $this->db
            ->where('qualification_id', $qualification_id)
            ->order_by('degree_name', 'ASC')
            ->get('degree_master')
            ->result();
    }

    public function get_streams($degree_id)
    {
        return $this->db
            ->where('degree_id', $degree_id)
            ->order_by('stream_name', 'ASC')
            ->get('stream_master')
            ->result();
    }


    // ===== Master data fetch =====
    public function get_location_master()
    {
        return $this->db->get('location_master')->result();
    }

    public function get_employment_type_master()
    {
        return $this->db->get('employment_type_master')->result();
    }

    public function get_skill_master()
    {
        return $this->db->get('skill_master')->result();
    }

    public function get_proficiency_master()
    {
        return $this->db->get('proficiency_master')->result();
    }

    // ===== User's already selected IDs (for edit mode pre-fill) =====
    public function get_user_location_ids($user_id)
    {
        $rows = $this->db->select('location_id')
            ->where('user_id', $user_id)
            ->get('user_locations')->result();
        return array_column($rows, 'location_id');
    }

    public function get_user_employment_type_ids($user_id)
    {
        $rows = $this->db->select('employment_type_id')
            ->where('user_id', $user_id)
            ->get('user_employment_type')->result();
        return array_column($rows, 'employment_type_id');
    }

    public function get_user_skill_ids($user_id)
    {
        $rows = $this->db->select('skill_id')
            ->where('user_id', $user_id)
            ->get('user_skills')->result();
        return array_column($rows, 'skill_id');
    }

    public function get_languages($user_id)
    {
        return $this->db->where('user_id', $user_id)->get('languages')->result();
    }

    // ===== Save (delete old + insert new — for checkbox/multi-select groups) =====
    public function save_user_locations($user_id, $location_ids)
    {
        $this->db->where('user_id', $user_id)->delete('user_locations');
        foreach ($location_ids as $id) {
            $this->db->insert('user_locations', ['user_id' => $user_id, 'location_id' => $id]);
        }
    }

    public function save_user_employment_type($user_id, $type_ids)
    {
        $this->db->where('user_id', $user_id)->delete('user_employment_type');
        foreach ($type_ids as $id) {
            $this->db->insert('user_employment_type', ['user_id' => $user_id, 'employment_type_id' => $id]);
        }
    }

    public function save_user_skills($user_id, $skill_ids)
    {
        $this->db->where('user_id', $user_id)->delete('user_skills');
        foreach ($skill_ids as $id) {
            $this->db->insert('user_skills', ['user_id' => $user_id, 'skill_id' => $id]);
        }
    }

    public function delete_languages($user_id)
    {
        $this->db->where('user_id', $user_id)->delete('languages');
    }

    public function save_language($user_id, $lang_name, $proficiency_id)
    {
        return $this->db->insert('languages', [
            'user_id' => $user_id,
            'language_name' => $lang_name,
            'proficiency_id' => $proficiency_id
        ]);
    }

    // ===== Resume =====
    public function save_resume($user_id, $resume_filename)
    {
        $exists = $this->db->where('user_id', $user_id)->get('skills')->row();
        if ($exists) {
            $this->db->where('user_id', $user_id)->update('skills', ['resume' => $resume_filename]);
        } else {
            $this->db->insert('skills', ['user_id' => $user_id, 'resume' => $resume_filename]);
        }
    }

    public function get_resume($user_id)
    {
        return $this->db->where('user_id', $user_id)->get('skills')->row();
    }


    public function get_user_locations_names($user_id)
    {
        return $this->db->select('location_master.location_name')
            ->from('user_locations')
            ->join('location_master', 'location_master.id = user_locations.location_id')
            ->where('user_locations.user_id', $user_id)
            ->get()->result();
    }

    public function get_user_skills_names($user_id)
    {
        return $this->db->select('skill_master.skill_name')
            ->from('user_skills')
            ->join('skill_master', 'skill_master.id = user_skills.skill_id')
            ->where('user_skills.user_id', $user_id)
            ->get()->result();
    }

    public function get_user_employment_names($user_id)
    {
        return $this->db->select('employment_type_master.type_name')
            ->from('user_employment_type')
            ->join('employment_type_master', 'employment_type_master.id = user_employment_type.employment_type_id')
            ->where('user_employment_type.user_id', $user_id)
            ->get()->result();
    }

    public function get_languages_with_names($user_id)
    {
        return $this->db->select('languages.language_name, proficiency_master.level_name')
            ->from('languages')
            ->join('proficiency_master', 'proficiency_master.id = languages.proficiency_id')
            ->where('languages.user_id', $user_id)
            ->get()->result();
    }

    public function update_status($user_id, $status)
    {
        $this->db->where('id', $user_id);
        return $this->db->update('users', ['status' => $status]);
    }
}