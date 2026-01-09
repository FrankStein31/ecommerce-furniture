<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
  private $nama_menu  = "Dashboard";     
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Menu_m');
    $this->load->model('Dashboard_m');
    must_login();
  }
  
  public function index()
  {
    $this->Menu_m->role_has_access($this->nama_menu);
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

    $data['dashboard'] = $this->Dashboard_m->get_dashboard();
    $data['content'] = "home/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
}

/* End of file Home.php */
