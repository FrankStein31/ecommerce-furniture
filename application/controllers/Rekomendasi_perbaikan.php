<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekomendasi_perbaikan extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    must_login();
    $this->load->model('Rekomendasi_perbaikan_m');
    $this->load->model('Jenis_kerusakan_m');
  }

  public function index()
  {
    $data = array(
      'title' => 'Data Rekomendasi Perbaikan',
      'rekomendasi_list' => $this->Rekomendasi_perbaikan_m->get_all(),
      'content' => 'rekomendasi_perbaikan/index.php'
    );
    
    $this->load->view('sistem/template', $data);
  }

  public function create()
  {
    // Generate kode rekomendasi otomatis
    $next_kode = $this->Rekomendasi_perbaikan_m->generate_kode_rekomendasi();
    
    // Validasi form
    $this->form_validation->set_rules('nama_rekomendasi', 'Nama Rekomendasi', 'required|trim');
    $this->form_validation->set_rules('mb_value', 'MB (Measure of Belief)', 'required|decimal|callback_validate_mb_md');
    $this->form_validation->set_rules('md_value', 'MD (Measure of Disbelief)', 'required|decimal');
    $this->form_validation->set_rules('biaya_estimasi', 'Biaya Estimasi', 'numeric');
    $this->form_validation->set_rules('durasi_perbaikan', 'Durasi Perbaikan', 'numeric');
    $this->form_validation->set_rules('status', 'Status', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Tambah Rekomendasi Perbaikan',
        'next_kode' => $next_kode,
        'kerusakan_list' => $this->Jenis_kerusakan_m->get_dropdown(),
        'content' => 'rekomendasi_perbaikan/create.php'
      );
      
      $this->load->view('sistem/template', $data);
    } else {
      // Insert data rekomendasi
      $data_rekomendasi = array(
        'kode_rekomendasi' => $next_kode,
        'nama_rekomendasi' => $this->input->post('nama_rekomendasi'),
        'deskripsi_rekomendasi' => $this->input->post('deskripsi_rekomendasi'),
        'mb_value' => $this->input->post('mb_value'),
        'md_value' => $this->input->post('md_value'),
        'cf_value' => $this->input->post('mb_value') - $this->input->post('md_value'), // CF = MB - MD
        'solusi_perbaikan' => $this->input->post('solusi_perbaikan'),
        'biaya_estimasi' => $this->input->post('biaya_estimasi') ?: 0,
        'durasi_perbaikan' => $this->input->post('durasi_perbaikan') ?: 0,
        'tingkat_prioritas' => $this->input->post('tingkat_prioritas'),
        'status' => $this->input->post('status'),
        'created_at' => date('Y-m-d H:i:s')
      );
      
      $id_rekomendasi = $this->Rekomendasi_perbaikan_m->insert($data_rekomendasi);
      
      // Insert relasi dengan jenis kerusakan
      $jenis_kerusakan = $this->input->post('jenis_kerusakan');
      if (!empty($jenis_kerusakan) && is_array($jenis_kerusakan)) {
        foreach ($jenis_kerusakan as $id_kerusakan) {
          $data_relasi = array(
            'id_rekomendasi_perbaikan' => $id_rekomendasi,
            'id_jenis_kerusakan' => $id_kerusakan
          );
          $this->Rekomendasi_perbaikan_m->insert_relasi($data_relasi);
        }
      }
      
      $this->session->set_flashdata('success', 'Data rekomendasi perbaikan berhasil ditambahkan');
      redirect('rekomendasi_perbaikan');
    }
  }

  public function edit($id)
  {
    $rekomendasi = $this->Rekomendasi_perbaikan_m->get_by_id($id);
    
    if (!$rekomendasi) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
      redirect('rekomendasi_perbaikan');
    }
    
    // Validasi form
    $this->form_validation->set_rules('nama_rekomendasi', 'Nama Rekomendasi', 'required|trim');
    $this->form_validation->set_rules('mb_value', 'MB (Measure of Belief)', 'required|decimal|callback_validate_mb_md');
    $this->form_validation->set_rules('md_value', 'MD (Measure of Disbelief)', 'required|decimal');
    $this->form_validation->set_rules('biaya_estimasi', 'Biaya Estimasi', 'numeric');
    $this->form_validation->set_rules('durasi_perbaikan', 'Durasi Perbaikan', 'numeric');
    $this->form_validation->set_rules('status', 'Status', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $data = array(
        'title' => 'Edit Rekomendasi Perbaikan',
        'rekomendasi' => $rekomendasi,
        'kerusakan_list' => $this->Jenis_kerusakan_m->get_dropdown(),
        'selected_kerusakan' => $this->Rekomendasi_perbaikan_m->get_relasi_kerusakan($id),
        'content' => 'rekomendasi_perbaikan/edit.php'
      );
      
      $this->load->view('sistem/template', $data);
    } else {
      // Update data rekomendasi
      $data_rekomendasi = array(
        'nama_rekomendasi' => $this->input->post('nama_rekomendasi'),
        'deskripsi_rekomendasi' => $this->input->post('deskripsi_rekomendasi'),
        'mb_value' => $this->input->post('mb_value'),
        'md_value' => $this->input->post('md_value'),
        'cf_value' => $this->input->post('mb_value') - $this->input->post('md_value'), // CF = MB - MD
        'solusi_perbaikan' => $this->input->post('solusi_perbaikan'),
        'biaya_estimasi' => $this->input->post('biaya_estimasi') ?: 0,
        'durasi_perbaikan' => $this->input->post('durasi_perbaikan') ?: 0,
        'tingkat_prioritas' => $this->input->post('tingkat_prioritas'),
        'status' => $this->input->post('status'),
        'updated_at' => date('Y-m-d H:i:s')
      );
      
      $this->Rekomendasi_perbaikan_m->update($id, $data_rekomendasi);
      
      // Update relasi dengan jenis kerusakan
      $this->Rekomendasi_perbaikan_m->delete_relasi($id);
      
      $jenis_kerusakan = $this->input->post('jenis_kerusakan');
      if (!empty($jenis_kerusakan) && is_array($jenis_kerusakan)) {
        foreach ($jenis_kerusakan as $id_kerusakan) {
          $data_relasi = array(
            'id_rekomendasi_perbaikan' => $id,
            'id_jenis_kerusakan' => $id_kerusakan
          );
          $this->Rekomendasi_perbaikan_m->insert_relasi($data_relasi);
        }
      }
      
      $this->session->set_flashdata('success', 'Data rekomendasi perbaikan berhasil diupdate');
      redirect('rekomendasi_perbaikan');
    }
  }

  public function delete($id)
  {
    $rekomendasi = $this->Rekomendasi_perbaikan_m->get_by_id($id);
    
    if (!$rekomendasi) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan');
      redirect('rekomendasi_perbaikan');
    }
    
    // Hapus relasi
    $this->Rekomendasi_perbaikan_m->delete_relasi($id);
    
    // Hapus rekomendasi
    $this->Rekomendasi_perbaikan_m->delete($id);
    
    $this->session->set_flashdata('success', 'Data rekomendasi perbaikan berhasil dihapus');
    redirect('rekomendasi_perbaikan');
  }

  // Custom validation: MB + MD harus <= 1.00
  public function validate_mb_md($mb_value)
  {
    $md_value = $this->input->post('md_value');
    $total = $mb_value + $md_value;
    
    if ($total > 1.00) {
      $this->form_validation->set_message('validate_mb_md', 'Total MB + MD tidak boleh lebih dari 1.00 (saat ini: ' . number_format($total, 2) . ')');
      return FALSE;
    }
    
    if ($mb_value < 0 || $mb_value > 1) {
      $this->form_validation->set_message('validate_mb_md', 'MB harus antara 0.00 sampai 1.00');
      return FALSE;
    }
    
    if ($md_value < 0 || $md_value > 1) {
      $this->form_validation->set_message('validate_mb_md', 'MD harus antara 0.00 sampai 1.00');
      return FALSE;
    }
    
    return TRUE;
  }
}
