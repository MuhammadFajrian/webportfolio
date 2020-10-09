<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/backend/header', $data);
        $this->load->view('templates/backend/sidebar', $data);
        $this->load->view('templates/backend/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/backend/footer');
    }
}
