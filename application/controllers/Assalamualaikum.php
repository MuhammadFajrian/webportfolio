<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Assalamualaikum extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Login Page';
			$this->load->view('templates/backend/auth_header', $data);
			$this->load->view('assalamualaikum/index');
			$this->load->view('templates/backend/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			if ($user['is_active'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];
					$this->session->set_userdata($data);
					if ($user['role_id'] == 1) {
						redirect('admin');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '
					<div class="alert alert-danger" role="alert">
					Wrong Password!
					</div>');
					redirect('assalamualaikum');
				}
			} else {
				$this->session->set_flashdata('message', '
				<div class="alert alert-danger" role="alert">
				This email has not activated!
				</div>');
				redirect('assalamualaikum');
			}
		} else {
			$this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
              Email is not registered!
			</div>');
			redirect('assalamualaikum');
		}
	}

	public function registration()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
			'is_unique' => 'This email has already registered!'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[repeat_password]', [
			'matches' => 'Password not match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('repeat_password', 'Password', 'required|trim|min_length[3]|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "User Registration";
			$this->load->view('templates/backend/auth_header', $data);
			$this->load->view('assalamualaikum/registration');
			$this->load->view('templates/backend/auth_footer', $data);
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role_id' => 1,
				'is_active' => 1,
				'date_created' => date('Y-m-d H:i:s')
			];
			$this->db->insert('users', $data);
			$this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
              Congratulation, Your Account has been created! Please Login
            </div>');
			redirect('assalamualaikum');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '
		<div class="alert alert-success" role="alert">
		  You have been logged out!
		</div>');
		redirect('assalamualaikum');
	}
}
