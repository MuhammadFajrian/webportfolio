<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Muhammad Fajrian Resume';
        $data['name'] = 'Muhammad Fajrian';

        $this->load->view('templates/frontend/header', $data);
        $this->load->view('landing/index');
        $this->load->view('templates/frontend/footer', $data);
    }
}
