<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Service extends CI_Controller
{
    private $nama_menu  = "Home";
    public function __construct()
    {
        parent::__construct();
        $this->apl = get_apl();
        $this->load->model('Menu_m');
        $this->load->model('Damage_report_m');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('email');
        must_login();
    }

    public function index()
    {
        $data['title'] = "Home | " . $this->apl['nama_sistem'];

        $data['content'] = "service/index.php";
        $this->parser->parse('frontend/template', $data);
    }
}
