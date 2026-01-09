<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gejala_kerusakan extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    must_login();
    $this->load->model('Gejala_kerusakan_m');
    $this->load->model('Jenis_perbaikan_m');
  }

  public function index()
  {
    $data = array(
      'title' => 'Data Gejala Kerusakan',
      'gejala_list' => $this->Gejala_kerusakan_m->get_all(),
      'content' => 'gejala_kerusakan/index.php'
    );
    
    $this->load->view('sistem/template', $data);
  }

  public function create()
  {
    // Generate kode gejala otomatis
    $next_kode = $this->Gejala_kerusakan_m->generate_kode_gejala();
    
    // Validasi form - kode tidak perlu validasi karena auto
    $this->form_validation->set_rules('nama_gejala', 'Nama Gejala', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Tambah Gejala Kerusakan',
        'next_kode' => $next_kode,
        'jenis_list' => $this->Jenis_perbaikan_m->get_dropdown(),
        'content' => 'gejala_kerusakan/create.php'
      );
      
      $this->load->view('sistem/template', $data);
    } else {
      $gejala_data = array(
        'kode_gejala' => $next_kode, // Auto-generated
        'nama_gejala' => $this->input->post('nama_gejala', true),
        'deskripsi_gejala' => $this->input->post('deskripsi', true),
        'pertanyaan' => $this->input->post('pertanyaan', true),
        'status' => $this->input->post('status', true),
        'created_at' => date('Y-m-d H:i:s')
      );
      
      $gejala_id = $this->Gejala_kerusakan_m->insert($gejala_data);
      
      // Insert relasi jenis perbaikan
      $jenis_perbaikan = $this->input->post('jenis_perbaikan');
      if (!empty($jenis_perbaikan) && is_array($jenis_perbaikan)) {
        foreach ($jenis_perbaikan as $jenis_id) {
          $relasi_data = array(
            'id_gejala' => $gejala_id,
            'id_jenis_perbaikan' => $jenis_id,
            'created_at' => date('Y-m-d H:i:s')
          );
          $this->Gejala_kerusakan_m->insert_relasi($relasi_data);
        }
      }
      
      $this->session->set_flashdata('success', 'Data gejala kerusakan berhasil ditambahkan');
      redirect('gejala_kerusakan');
    }
  }

  public function edit($id)
  {
    $gejala = $this->Gejala_kerusakan_m->get_by_id($id);
    
    if (!$gejala) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
      redirect('gejala_kerusakan');
    }
    
    // Validasi form - kode tidak bisa diedit
    $this->form_validation->set_rules('nama_gejala', 'Nama Gejala', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Edit Gejala Kerusakan',
        'gejala' => $gejala,
        'jenis_list' => $this->Jenis_perbaikan_m->get_dropdown(),
        'selected_jenis' => $this->Gejala_kerusakan_m->get_relasi_jenis($id),
        'content' => 'gejala_kerusakan/edit.php'
      );
      
      $this->load->view('sistem/template', $data);
    } else {
      $gejala_data = array(
        // kode_gejala tidak diupdate, tetap sama
        'nama_gejala' => $this->input->post('nama_gejala', true),
        'deskripsi_gejala' => $this->input->post('deskripsi', true),
        'pertanyaan' => $this->input->post('pertanyaan', true),
        'status' => $this->input->post('status', true),
        'updated_at' => date('Y-m-d H:i:s')
      );
      
      $this->Gejala_kerusakan_m->update($id, $gejala_data);
      
      // Update relasi jenis perbaikan - hapus dulu yang lama
      $this->Gejala_kerusakan_m->delete_relasi($id);
      
      // Insert yang baru
      $jenis_perbaikan = $this->input->post('jenis_perbaikan');
      if (!empty($jenis_perbaikan) && is_array($jenis_perbaikan)) {
        foreach ($jenis_perbaikan as $jenis_id) {
          $relasi_data = array(
            'id_gejala' => $id,
            'id_jenis_perbaikan' => $jenis_id,
            'created_at' => date('Y-m-d H:i:s')
          );
          $this->Gejala_kerusakan_m->insert_relasi($relasi_data);
        }
      }
      
      $this->session->set_flashdata('success', 'Data gejala kerusakan berhasil diupdate');
      redirect('gejala_kerusakan');
    }
  }

  public function delete($id)
  {
    $gejala = $this->Gejala_kerusakan_m->get_by_id($id);
    
    if (!$gejala) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
      redirect('gejala_kerusakan');
    }
    
    // Cek apakah gejala ini digunakan di jenis_kerusakan
    $used = $this->db->query("SELECT COUNT(*) as total FROM jenis_kerusakan_gejala WHERE id_gejala = ?", array($id))->row()->total;
    
    if ($used > 0) {
      $this->session->set_flashdata('error', 'Gejala tidak dapat dihapus karena masih digunakan di Jenis Kerusakan');
      redirect('gejala_kerusakan');
    }
    
    // Hapus relasi dulu
    $this->Gejala_kerusakan_m->delete_relasi($id);
    
    // Hapus gejala
    $this->Gejala_kerusakan_m->delete($id);
    
    $this->session->set_flashdata('success', 'Data gejala kerusakan berhasil dihapus');
    redirect('gejala_kerusakan');
  }
}
