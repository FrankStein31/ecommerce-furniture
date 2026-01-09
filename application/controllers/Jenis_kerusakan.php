<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_kerusakan extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    must_login();
    $this->load->model('Jenis_kerusakan_m');
    $this->load->model('Gejala_kerusakan_m');
    $this->load->helper('upload_helper');
  }

  public function index()
  {
    $data = array(
      'title' => 'Data Jenis Kerusakan',
      'kerusakan_list' => $this->Jenis_kerusakan_m->get_all(),
      'content' => 'jenis_kerusakan/index.php'
    );
    
    $this->load->view('sistem/template', $data);
  }

  public function create()
  {
    // Generate kode kerusakan otomatis
    $next_kode = $this->Jenis_kerusakan_m->generate_kode_kerusakan();
    
    // Validasi form
    $this->form_validation->set_rules('nama_jenis_kerusakan', 'Nama Jenis Kerusakan', 'required|trim');
    $this->form_validation->set_rules('tingkat_kerusakan', 'Tingkat Kerusakan', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Tambah Jenis Kerusakan',
        'next_kode' => $next_kode,
        'gejala_list' => $this->Gejala_kerusakan_m->get_dropdown(),
        'content' => 'jenis_kerusakan/create.php'
      );
      
      $this->load->view('sistem/template', $data);
    } else {
      // Upload gambar jika ada
      $gambar_path = null;
      if (!empty($_FILES['ilustrasi_gambar']['name'])) {
        $upload_result = upload_image('ilustrasi_gambar', 'kerusakan', 2048); // Max 2MB
        if ($upload_result['status']) {
          $gambar_path = $upload_result['file_path'];
        } else {
          $this->session->set_flashdata('error', $upload_result['message']);
          redirect('jenis_kerusakan/create');
          return;
        }
      }
      
      $kerusakan_data = array(
        'kode_kerusakan' => $next_kode,
        'nama_jenis_kerusakan' => $this->input->post('nama_jenis_kerusakan', true),
        'detail_kerusakan' => $this->input->post('detail_kerusakan', true),
        'pertanyaan' => $this->input->post('pertanyaan', true),
        'ilustrasi_gambar' => $gambar_path,
        'tingkat_kerusakan' => $this->input->post('tingkat_kerusakan', true),
        'status' => $this->input->post('status', true),
        'created_at' => date('Y-m-d H:i:s')
      );
      
      $kerusakan_id = $this->Jenis_kerusakan_m->insert($kerusakan_data);
      
      // Insert relasi gejala
      $gejala_list = $this->input->post('gejala_kerusakan');
      if (!empty($gejala_list) && is_array($gejala_list)) {
        foreach ($gejala_list as $gejala_id) {
          $relasi_data = array(
            'id_jenis_kerusakan' => $kerusakan_id,
            'id_gejala' => $gejala_id,
            'created_at' => date('Y-m-d H:i:s')
          );
          $this->Jenis_kerusakan_m->insert_relasi($relasi_data);
        }
      }
      
      $this->session->set_flashdata('success', 'Data jenis kerusakan berhasil ditambahkan');
      redirect('jenis_kerusakan');
    }
  }

  public function edit($id)
  {
    $kerusakan = $this->Jenis_kerusakan_m->get_by_id($id);
    
    if (!$kerusakan) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
      redirect('jenis_kerusakan');
    }
    
    // Validasi form
    $this->form_validation->set_rules('nama_jenis_kerusakan', 'Nama Jenis Kerusakan', 'required|trim');
    $this->form_validation->set_rules('tingkat_kerusakan', 'Tingkat Kerusakan', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Edit Jenis Kerusakan',
        'kerusakan' => $kerusakan,
        'gejala_list' => $this->Gejala_kerusakan_m->get_dropdown(),
        'selected_gejala' => $this->Jenis_kerusakan_m->get_relasi_gejala($id),
        'content' => 'jenis_kerusakan/edit.php'
      );
      
      $this->load->view('sistem/template', $data);
    } else {
      // Upload gambar baru jika ada
      $gambar_path = $kerusakan->ilustrasi_gambar;
      if (!empty($_FILES['ilustrasi_gambar']['name'])) {
        // Hapus gambar lama jika ada
        if (!empty($gambar_path) && file_exists($gambar_path)) {
          unlink($gambar_path);
        }
        
        $upload_result = upload_image('ilustrasi_gambar', 'kerusakan', 2048);
        if ($upload_result['status']) {
          $gambar_path = $upload_result['file_path'];
        } else {
          $this->session->set_flashdata('error', $upload_result['message']);
          redirect('jenis_kerusakan/edit/'.$id);
          return;
        }
      }
      
      $kerusakan_data = array(
        'nama_jenis_kerusakan' => $this->input->post('nama_jenis_kerusakan', true),
        'detail_kerusakan' => $this->input->post('detail_kerusakan', true),
        'pertanyaan' => $this->input->post('pertanyaan', true),
        'ilustrasi_gambar' => $gambar_path,
        'tingkat_kerusakan' => $this->input->post('tingkat_kerusakan', true),
        'status' => $this->input->post('status', true),
        'updated_at' => date('Y-m-d H:i:s')
      );
      
      $this->Jenis_kerusakan_m->update($id, $kerusakan_data);
      
      // Update relasi gejala
      $this->Jenis_kerusakan_m->delete_relasi($id);
      
      $gejala_list = $this->input->post('gejala_kerusakan');
      if (!empty($gejala_list) && is_array($gejala_list)) {
        foreach ($gejala_list as $gejala_id) {
          $relasi_data = array(
            'id_jenis_kerusakan' => $id,
            'id_gejala' => $gejala_id,
            'created_at' => date('Y-m-d H:i:s')
          );
          $this->Jenis_kerusakan_m->insert_relasi($relasi_data);
        }
      }
      
      $this->session->set_flashdata('success', 'Data jenis kerusakan berhasil diupdate');
      redirect('jenis_kerusakan');
    }
  }

  public function delete($id)
  {
    $kerusakan = $this->Jenis_kerusakan_m->get_by_id($id);
    
    if (!$kerusakan) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
      redirect('jenis_kerusakan');
    }
    
    // Cek apakah jenis kerusakan ini digunakan di rekomendasi
    $used = $this->db->query("SELECT COUNT(*) as total FROM relasi_rekomendasi_jenis_kerusakan WHERE id_jenis_kerusakan = ?", array($id))->row()->total;
    
    if ($used > 0) {
      $this->session->set_flashdata('error', 'Jenis kerusakan tidak dapat dihapus karena sudah ada rekomendasi terkait');
      redirect('jenis_kerusakan');
    }
    
    // Hapus gambar jika ada
    if (!empty($kerusakan->ilustrasi_gambar) && file_exists($kerusakan->ilustrasi_gambar)) {
      unlink($kerusakan->ilustrasi_gambar);
    }
    
    // Hapus relasi
    $this->Jenis_kerusakan_m->delete_relasi($id);
    
    // Hapus jenis kerusakan
    $this->Jenis_kerusakan_m->delete($id);
    
    $this->session->set_flashdata('success', 'Data jenis kerusakan berhasil dihapus');
    redirect('jenis_kerusakan');
  }
  
  public function delete_image($id)
  {
    $kerusakan = $this->Jenis_kerusakan_m->get_by_id($id);
    
    if ($kerusakan) {
      // Hapus file gambar dari server
      if (!empty($kerusakan->ilustrasi_gambar) && file_exists($kerusakan->ilustrasi_gambar)) {
        unlink($kerusakan->ilustrasi_gambar);
      }
      
      // Update database: set ilustrasi_gambar = NULL
      $this->db->where('id', $id);
      $this->db->update('jenis_kerusakan', array('ilustrasi_gambar' => NULL));
      
      $this->session->set_flashdata('success', 'Gambar berhasil dihapus');
    } else {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
    }
    
    redirect('jenis_kerusakan/edit/'.$id);
  }
}
