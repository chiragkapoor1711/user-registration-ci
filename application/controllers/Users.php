<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');

        $this->load->library('session');

        if (!$this->session->userdata('user_id')) {
            redirect('Auth/login');
        }

        $this->load->database();
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->helper('form');
        $user_id = $this->session->userdata('reg_user_id');

        if ($user_id) {
            $data['user'] = $this->User_model->get_user($user_id);
        } else {
            $data['user'] = null;
        }

        $this->load->view('user_form', $data);


    }

    public function add_new()
    {
        $this->session->unset_userdata('reg_user_id');

        $data['user'] = null;

        $this->load->view('user_form', $data);
    }

    public function submit()
    {
        $this->load->library('form_validation');

        // Name: Must contain first and last name
        $this->form_validation->set_rules(
            'name',
            'Name',
            'required|regex_match[/^[A-Za-z]+(\s+[A-Za-z]+)+$/]'
        );

        // Email validation
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email'
        );

        // Mobile validation
        $this->form_validation->set_rules(
            'mobile',
            'Mobile',
            'required|numeric|exact_length[10]'
        );

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user_form');
            return;
        }

        $photo = '';

        $reg_user_id = $this->session->userdata('reg_user_id');

        if ($reg_user_id) {
            $existing_user = $this->User_model->get_user($reg_user_id);

            if (!empty($existing_user->photo)) {
                $photo = $existing_user->photo;
            }
        }

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('photo')) {

            $uploadData = $this->upload->data();
            $photo = $uploadData['file_name'];
        }

        $hobbies = $this->input->post('hobbies');

        $data = array(
            'login_user_id' => $this->session->userdata('user_id'),

            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'country_code' => $this->input->post('country_code'),
            'mobile' => $this->input->post('mobile'),
            'gender' => $this->input->post('gender'),
            'hobbies' => !empty($hobbies) ? implode(',', $hobbies) : '',
            'address' => $this->input->post('address'),
            'photo' => $photo
        );

        $reg_user_id = $this->session->userdata('reg_user_id');

        if ($reg_user_id) {
            $this->User_model->update_user($reg_user_id, $data);
            $user_id = $reg_user_id;
        } else {
            $user_id = $this->User_model->insert_user($data);
            $this->session->set_userdata('reg_user_id', $user_id);
        }

        $action = $this->input->post('action');

        if ($action == 'next') {

            redirect('Users/education');

        } elseif ($action == 'save') {

            $this->session->set_flashdata('success', 'Data saved successfully');
            redirect('Users');

        }

    }
    public function users_list()
    {
        if ($this->session->userdata('role') == 'user') {
            redirect('Users/my_profile');
        }

        $data['role'] = $this->session->userdata('role');
        $data['users'] = $this->User_model->get_all_users(10, 0);
        $data['pagination_links'] = $this->build_pagination(0);

        $this->load->view('users_list', $data);
    }

    public function users_list_ajax($offset = 0)
    {
        $data['role'] = $this->session->userdata('role');
        $data['users'] = $this->User_model->get_all_users(10, $offset);
        $data['pagination_links'] = $this->build_pagination($offset);

        $this->load->view('users_list_table', $data);
    }

    private function build_pagination($offset)
    {
        $this->load->library('pagination');

        $config['base_url'] = site_url('Users/users_list_ajax');
        $config['total_rows'] = $this->User_model->count_all_users();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

    public function delete($id)
    {
        // Get user data
        $user = $this->User_model->get_user($id);

        // Delete image if exists
        if (!empty($user->photo)) {
            $file_path = FCPATH . 'uploads/' . $user->photo;

            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Delete database record
        $this->User_model->delete_user($id);

        redirect('Users/users_list');
    }

    public function edit($id)
    {
        $this->session->set_userdata('edit_user_id', $id);

        redirect('Users/edit_basic');
    }
    public function edit_basic()
    {
        $id = $this->session->userdata('edit_user_id');

        $this->session->set_userdata('reg_user_id', $id);

        $data['user'] = $this->User_model->get_user($id);

        $data['edit_mode'] = true;

        $this->load->view('user_form', $data);
    }

    public function edit_education()
    {

        $id = $this->session->userdata('edit_user_id');

        $data['education'] = $this->User_model->get_education($id);

        $this->load->view('education', $data);


    }

    public function edit_skills()
    {
        $id = $this->session->userdata('edit_user_id');

        $data['skill'] = $this->User_model->get_skill($id);

        $this->load->view('skills', $data);
    }
    public function update($id)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'country_code' => $this->input->post('country_code'),
            'mobile' => $this->input->post('mobile'),
            'gender' => $this->input->post('gender'),
            'address' => $this->input->post('address')
        );

        $this->User_model->update_user($id, $data);

        $education_data = array(
            'qualification' => $this->input->post('qualification'),
            'college' => $this->input->post('college'),
            'passing_year' => $this->input->post('passing_year')
        );

        $this->User_model->update_education($id, $education_data);

        $skill_data = array(
            'skill_name' => $this->input->post('skill_name'),
            'experience' => $this->input->post('experience')
        );

        $this->User_model->update_skill($id, $skill_data);

        redirect('Users/users_list');
    }

    public function education()
    {
        $user_id = $this->session->userdata('edit_user_id')
            ?: $this->session->userdata('reg_user_id');

        $data['education'] = $this->User_model->get_education($user_id);

        // Fetch all qualifications
        $data['qualifications'] = $this->User_model->get_qualifications();

        $this->load->view('education', $data);
    }

    public function save_education()
    {
        $this->load->library('form_validation');

        $qualification_id = $this->input->post('qualification_id');

        // Common rule
        $this->form_validation->set_rules('qualification_id', 'Qualification', 'required|integer');

        // Conditional rules based on qualification type
        // (Assuming you added 'type' column: school / college, as discussed earlier)
        $qualification = $this->User_model->get_qualification_by_id($qualification_id);

        if ($qualification && $qualification->type == 'school') {

            $this->form_validation->set_rules('board', 'Board', 'required');
            $this->form_validation->set_rules('school', 'School', 'required');
            $this->form_validation->set_rules('percentage', 'Percentage', 'required|numeric|greater_than[0]|less_than_equal_to[100]');

        } elseif ($qualification && $qualification->type == 'college') {

            $this->form_validation->set_rules('degree_id', 'Degree', 'required|integer');
            $this->form_validation->set_rules('stream_id', 'Stream', 'required|integer');
            $this->form_validation->set_rules('college', 'College', 'required');
            $this->form_validation->set_rules('passing_year', 'Passing Year', 'required|exact_length[4]|numeric');
            $this->form_validation->set_rules('cgpa', 'CGPA', 'required|numeric|greater_than[0]|less_than_equal_to[10]');
        }

        if ($this->form_validation->run() == FALSE) {

            $user_id = $this->session->userdata('reg_user_id');
            $data['education'] = $this->User_model->get_education($user_id);
            $data['qualifications'] = $this->User_model->get_qualifications();

            $this->load->view('education', $data);
            return;
        }

        $user_id = $this->session->userdata('reg_user_id');

        $data = [
            'qualification_id' => $qualification_id,
            'degree_id' => $this->input->post('degree_id'),
            'stream_id' => $this->input->post('stream_id'),
            'board' => $this->input->post('board'),
            'school' => $this->input->post('school'),
            'percentage' => $this->input->post('percentage'),
            'college' => $this->input->post('college'),
            'passing_year' => $this->input->post('passing_year'),
            'cgpa' => $this->input->post('cgpa')
        ];

        $this->User_model->save_education($user_id, $data);

        redirect('Users/skills');
    }
    public function skills()
    {
        $user_id = $this->session->userdata('edit_user_id')
            ?: $this->session->userdata('reg_user_id');

        $data['location_options'] = $this->User_model->get_location_master();
        $data['employment_options'] = $this->User_model->get_employment_type_master();
        $data['skill_options'] = $this->User_model->get_skill_master();
        $data['proficiency_options'] = $this->User_model->get_proficiency_master();

        $data['selected_locations'] = $this->User_model->get_user_location_ids($user_id);
        $data['selected_employment'] = $this->User_model->get_user_employment_type_ids($user_id);
        $data['selected_skills'] = $this->User_model->get_user_skill_ids($user_id);
        $data['languages'] = $this->User_model->get_languages($user_id);
        $data['resume'] = $this->User_model->get_resume($user_id);

        $this->load->view('skills', $data);
    }

    public function save_skills()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('preferred_locations[]', 'Preferred Locations', 'required');
        $this->form_validation->set_rules('skills[]', 'Skills', 'required');
        $this->form_validation->set_rules('employment_type[]', 'Employment Type', 'required');
        $this->form_validation->set_rules('language_name[]', 'Language Name', 'required');
        $this->form_validation->set_rules('proficiency_id[]', 'Proficiency', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->skills(); // reload form with error
            return;
        }


        $user_id = $this->session->userdata('reg_user_id');

        // Checkbox / multi-select groups (arrays of IDs)
        $this->User_model->save_user_locations($user_id, $this->input->post('preferred_locations'));
        $this->User_model->save_user_skills($user_id, $this->input->post('skills'));
        $this->User_model->save_user_employment_type($user_id, $this->input->post('employment_type'));

        // Languages (dynamic rows)
        $this->User_model->delete_languages($user_id);
        $language_names = $this->input->post('language_name');
        $proficiency_ids = $this->input->post('proficiency_id');

        foreach ($language_names as $key => $lang_name) {
            if (!empty($lang_name) && !empty($proficiency_ids[$key])) {
                $this->User_model->save_language($user_id, $lang_name, $proficiency_ids[$key]);
            }
        }

        // Resume upload
        $existing_resume = $this->User_model->get_resume($user_id);
        $resume_filename = !empty($existing_resume->resume) ? $existing_resume->resume : '';

        if (!empty($_FILES['resume']['name'])) {

            $config['upload_path'] = './uploads/resume/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5120; // KB = 5MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('resume')) {
                $uploadData = $this->upload->data();
                $resume_filename = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('Users/skills_form');
                return;
            }
        }

        if (empty($resume_filename)) {
            $this->session->set_flashdata('error', 'Resume upload is required.');
            redirect('Users/skills_form');
            return;
        }

        $this->User_model->save_resume($user_id, $resume_filename);

        $this->session->unset_userdata('edit_user_id');

        if ($this->session->userdata('role') == 'user') {
            redirect('Users/my_profile');
        } else {
            $this->session->unset_userdata('reg_user_id');
            redirect('Users/users_list');
        }

    }


    public function my_profile()
    {
        $login_user_id = $this->session->userdata('user_id');

        $user = $this->User_model->get_user_by_login_id($login_user_id);

        if ($user) {

            $data['user'] = $user;
            $data['education'] = $this->User_model->get_education($user->id);

            $data['locations'] = $this->User_model->get_user_locations_names($user->id);
            $data['skills'] = $this->User_model->get_user_skills_names($user->id);
            $data['employment'] = $this->User_model->get_user_employment_names($user->id);
            $data['languages'] = $this->User_model->get_languages_with_names($user->id);
            $data['resume'] = $this->User_model->get_resume($user->id);

            $this->load->view('my_profile', $data);

        } else {
            redirect('Users/add_new');
        }
    }


    public function get_degrees()
    {
        $qualification_id = $this->input->post('qualification_id');

        $degrees = $this->User_model->get_degrees($qualification_id);

        echo json_encode($degrees);
    }

    public function get_streams()
    {
        $degree_id = $this->input->post('degree_id');

        $streams = $this->User_model->get_streams($degree_id);

        echo json_encode($streams);
    }


    public function save_skills_form()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('preferred_locations[]', 'Preferred Locations', 'required');
        $this->form_validation->set_rules('skills[]', 'Skills', 'required');
        $this->form_validation->set_rules('employment_type[]', 'Employment Type', 'required');
        $this->form_validation->set_rules('language_name[]', 'Language Name', 'required');
        $this->form_validation->set_rules('proficiency_id[]', 'Proficiency', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->skills();
            return;
        }

        $user_id = $this->session->userdata('reg_user_id');

        $this->User_model->save_user_locations($user_id, $this->input->post('preferred_locations'));
        $this->User_model->save_user_skills($user_id, $this->input->post('skills'));
        $this->User_model->save_user_employment_type($user_id, $this->input->post('employment_type'));

        $this->User_model->delete_languages($user_id);
        $language_names = $this->input->post('language_name');
        $proficiency_ids = $this->input->post('proficiency_id');

        foreach ($language_names as $key => $lang_name) {
            if (!empty($lang_name) && !empty($proficiency_ids[$key])) {
                $this->User_model->save_language($user_id, $lang_name, $proficiency_ids[$key]);
            }
        }

        $existing_resume = $this->User_model->get_resume($user_id);
        $resume_filename = !empty($existing_resume->resume) ? $existing_resume->resume : '';

        if (!empty($_FILES['resume']['name'])) {

            $config['upload_path'] = './uploads/resume/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5120;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('resume')) {
                $uploadData = $this->upload->data();
                $resume_filename = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('Users/skills');
                return;
            }
        }

        if (empty($resume_filename)) {
            $this->session->set_flashdata('error', 'Resume upload is required.');
            redirect('Users/skills');
            return;
        }

        $this->User_model->save_resume($user_id, $resume_filename);

        $this->session->unset_userdata('edit_user_id');

        if ($this->session->userdata('role') == 'user') {
            redirect('Users/my_profile');
        } else {
            $this->session->unset_userdata('reg_user_id');
            redirect('Users/users_list');
        }
    }


    public function verify($id)
    {
        // Sirf admin/manager ye action kar sake
        if (!in_array($this->session->userdata('role'), ['admin', 'manager'])) {
            show_error('Unauthorized access', 403);
        }

        $this->User_model->update_status($id, 'verified');

        $this->session->set_flashdata('success', 'User verified successfully.');
        redirect('Users/users_list');
    }

    public function reject($id)
    {
        if (!in_array($this->session->userdata('role'), ['admin', 'manager'])) {
            show_error('Unauthorized access', 403);
        }

        $this->User_model->update_status($id, 'rejected');

        $this->session->set_flashdata('success', 'User rejected.');
        redirect('Users/users_list');
    }

    public function export_excel()
    {
        if (!in_array($this->session->userdata('role'), ['admin', 'manager'])) {
            show_error('Unauthorized access', 403);
        }

        $users = $this->User_model->get_all_users(); // sab users, bina limit ke

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $headers = ['ID', 'Name', 'Email', 'Mobile', 'Gender', 'Qualification', 'College', 'Passing Year', 'Locations', 'Skills', 'Employment Type', 'Status'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Data rows
        $row = 2;
        foreach ($users as $user) {
            $sheet->fromArray([
                $user->id,
                $user->name,
                $user->email,
                $user->mobile,
                $user->gender,
                $user->qualification,
                $user->college,
                $user->passing_year,
                $user->location_names,
                $user->skill_names,
                $user->employment_names,
                $user->status
            ], NULL, 'A' . $row);
            $row++;
        }

        // Download trigger
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users_list.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}