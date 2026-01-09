<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Master_data extends CI_Controller {
  private $nama_menu = "Master Data";
  private $api_base_url = "http://localhost:8000/kode";
  
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Menu_m');
    must_login();
  }
  
  // Jenis Perbaikan
  public function jenis_perbaikan()
  {
    // $this->Menu_m->role_has_access("Jenis Perbaikan");
    $data['title'] = "Jenis Perbaikan | " . $this->apl['nama_sistem'];
    $data['content'] = "master_data/jenis_perbaikan/index.php";
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_jenis_perbaikan()
  {
    $url = $this->api_base_url . '/jenis-perbaikan';
    $result = $this->fetch_from_api($url);
    
    if ($result['success']) {
      $data = json_decode($result['data'], true);
      $response = array(
        'success' => true,
        'total' => isset($data['total']) ? $data['total'] : 0,
        'data' => isset($data['data']) ? $data['data'] : []
      );
    } else {
      $response = array(
        'success' => false,
        'message' => $result['message'],
        'data' => []
      );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  
  // Gejala Kerusakan
  public function gejala_kerusakan()
  {
    // $this->Menu_m->role_has_access("Gejala Kerusakan");
    $data['title'] = "Gejala Kerusakan | " . $this->apl['nama_sistem'];
    $data['content'] = "master_data/gejala_kerusakan/index.php";
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_gejala_kerusakan()
  {
    $url = $this->api_base_url . '/gejala-kerusakan';
    $result = $this->fetch_from_api($url);
    
    if ($result['success']) {
      $data = json_decode($result['data'], true);
      $response = array(
        'success' => true,
        'total' => isset($data['total']) ? $data['total'] : 0,
        'data' => isset($data['data']) ? $data['data'] : []
      );
    } else {
      $response = array(
        'success' => false,
        'message' => $result['message'],
        'data' => []
      );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  
  // Jenis Kerusakan
  public function jenis_kerusakan()
  {
    // $this->Menu_m->role_has_access("Jenis Kerusakan");
    $data['title'] = "Jenis Kerusakan | " . $this->apl['nama_sistem'];
    $data['content'] = "master_data/jenis_kerusakan/index.php";
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_jenis_kerusakan()
  {
    $url = $this->api_base_url . '/jenis-kerusakan';
    $result = $this->fetch_from_api($url);
    
    if ($result['success']) {
      $data = json_decode($result['data'], true);
      $response = array(
        'success' => true,
        'total' => isset($data['total']) ? $data['total'] : 0,
        'data' => isset($data['data']) ? $data['data'] : []
      );
    } else {
      $response = array(
        'success' => false,
        'message' => $result['message'],
        'data' => []
      );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  
  // Rekomendasi Perbaikan
  public function rekomendasi_perbaikan()
  {
    // $this->Menu_m->role_has_access("Rekomendasi Perbaikan");
    $data['title'] = "Rekomendasi Perbaikan | " . $this->apl['nama_sistem'];
    $data['content'] = "master_data/rekomendasi_perbaikan/index.php";
    $this->parser->parse('sistem/template', $data);
  }
  
  public function fetch_rekomendasi_perbaikan()
  {
    $url = $this->api_base_url . '/rekomendasi';
    $result = $this->fetch_from_api($url);
    
    if ($result['success']) {
      $data = json_decode($result['data'], true);
      $response = array(
        'success' => true,
        'total' => isset($data['total']) ? $data['total'] : 0,
        'data' => isset($data['data']) ? $data['data'] : []
      );
    } else {
      $response = array(
        'success' => false,
        'message' => $result['message'],
        'data' => []
      );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  
  // Helper function to fetch from API
  private function fetch_from_api($url)
  {
    $options = array(
      'http' => array(
        'header'  => "Accept: application/json\r\n",
        'method'  => 'GET',
        'ignore_errors' => true
      )
    );
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
      return array(
        'success' => false,
        'message' => 'Gagal mengambil data dari server'
      );
    }
    
    return array(
      'success' => true,
      'data' => $result
    );
  }
}
