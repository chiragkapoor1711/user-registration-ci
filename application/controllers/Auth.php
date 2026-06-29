<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Auth_model');
        $this->load->library('session');
    }

    public function signup()
    {
        $this->load->view('signup');
    }

    public function login()
    {
        $this->load->view('login');
    }

    public function register()
    {
        $data = array(
            'username' => $this->input->post('username'),
            'password' => password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            ),
            'role' => 'user' // public signup ALWAYS gets 'user' role — never trust client input for this
        );

        $this->Auth_model->register_user($data);

        redirect('Auth/login');
    }

    public function check_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Auth_model->check_login($username);

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('role', $user->role);

            if ($user->role == 'admin' || $user->role == 'manager') {

                redirect('Users/users_list');

            } elseif ($user->role == 'user') {

                redirect('Users/my_profile');

            } else {

                redirect('Auth/login');

            }
        } else {
            echo "Invalid Username or Password";
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Auth/login');
    }

    // ===================== ADMIN-ONLY: MANAGE LOGIN ACCOUNTS =====================

    private function require_admin()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_error('Access denied. Admins only.', 403);
        }
    }

    // List all login accounts with their current role
    public function manage_users()
    {
        $this->require_admin();

        $data['accounts'] = $this->Auth_model->get_all_login_users();
        $this->load->view('manage_users', $data);
    }

    // Show form to add a brand-new login account (admin sets username/password/role)
    public function add_user()
    {
        $this->require_admin();

        $this->load->view('add_user');
    }

    // Process the add-user form
    public function store_user()
    {
        $this->require_admin();

        $username = $this->input->post('username');

        if ($this->Auth_model->username_exists($username)) {
            echo "Username already taken. <a href='" . site_url('Auth/add_user') . "'>Go back</a>";
            return;
        }

        $data = array(
            'username' => $username,
            'password' => password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            ),
            'role' => $this->input->post('role') // admin chooses: admin / manager / user
        );

        $this->Auth_model->register_user($data);

        redirect('Auth/manage_users');
    }

    // Change role of an EXISTING account (e.g. promote user -> manager)
    public function update_role($id)
    {
        $this->require_admin();

        $role = $this->input->post('role');

        // safety: only allow these 3 values, never trust raw POST blindly
        if (!in_array($role, array('admin', 'manager', 'user'))) {
            show_error('Invalid role.', 400);
        }

        $this->Auth_model->update_role($id, $role);

        redirect('Auth/manage_users');
    }

    // Show change password form
    public function change_password()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('Auth/login');
        }

        $this->load->view('change_password');
    }

    // Process change password form
    public function update_password()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('Auth/login');
        }

        $user_id = $this->session->userdata('user_id');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        // Fetch current user record to verify old password
        $username = $this->session->userdata('username');
        $user = $this->Auth_model->check_login($username);

        if (!$user || !password_verify($old_password, $user->password)) {
            echo "Old password is incorrect. <a href='" . site_url('Auth/change_password') . "'>Go back</a>";
            return;
        }

        if ($new_password !== $confirm_password) {
            echo "New password and confirm password do not match. <a href='" . site_url('Auth/change_password') . "'>Go back</a>";
            return;
        }

        if (strlen($new_password) < 6) {
            echo "New password must be at least 6 characters. <a href='" . site_url('Auth/change_password') . "'>Go back</a>";
            return;
        }

        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $this->Auth_model->update_password($user_id, $hashed);

        // Optional: force re-login after password change for security
        $this->session->sess_destroy();
        redirect('Auth/login');
    }
}