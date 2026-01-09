<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_menu extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    must_login();
  }
  
  public function install_master_data_menu()
  {
    // Get current max ID from menu table
    $max_menu = $this->db->query("SELECT MAX(id) as max_id FROM menu")->row();
    $start_id = $max_menu->max_id + 1;
    
    // Check if menu already exists
    $existing = $this->db->query("SELECT * FROM menu WHERE nama = 'Sistem Rekomendasi'")->num_rows();
    
    if ($existing > 0) {
      echo "<script>alert('Menu sudah ada di database!');</script>";
      echo "<script>window.location.href='" . site_url('Dashboard') . "';</script>";
      return;
    }
    
    // Insert main menu
    $menu_data = array(
      array(
        'id' => $start_id,
        'nama' => 'Sistem Rekomendasi',
        'link' => '#',
        'class_icon' => 'fa fa-cogs',
        'is_parent' => '1',
        'id_parent' => NULL,
        'keterangan' => 'Menu Sistem Rekomendasi'
      ),
      array(
        'id' => $start_id + 1,
        'nama' => 'Kategori Perbaikan',
        'link' => 'Kategori_perbaikan',
        'class_icon' => NULL,
        'is_parent' => '2',
        'id_parent' => (string)$start_id,
        'keterangan' => 'Data Master Kategori Perbaikan'
      ),
      array(
        'id' => $start_id + 2,
        'nama' => 'Jenis Perbaikan',
        'link' => 'Jenis_perbaikan',
        'class_icon' => NULL,
        'is_parent' => '2',
        'id_parent' => (string)$start_id,
        'keterangan' => 'Data Master Jenis Perbaikan'
      ),
      array(
        'id' => $start_id + 3,
        'nama' => 'Gejala Kerusakan',
        'link' => 'Gejala_kerusakan',
        'class_icon' => NULL,
        'is_parent' => '2',
        'id_parent' => (string)$start_id,
        'keterangan' => 'Data Master Gejala Kerusakan'
      ),
      array(
        'id' => $start_id + 4,
        'nama' => 'Jenis Kerusakan',
        'link' => 'Jenis_kerusakan',
        'class_icon' => NULL,
        'is_parent' => '2',
        'id_parent' => (string)$start_id,
        'keterangan' => 'Data Master Jenis Kerusakan'
      ),
      array(
        'id' => $start_id + 5,
        'nama' => 'Rekomendasi Perbaikan',
        'link' => 'Rekomendasi_perbaikan',
        'class_icon' => NULL,
        'is_parent' => '2',
        'id_parent' => (string)$start_id,
        'keterangan' => 'Data Master Rekomendasi Perbaikan'
      )
    );
    
    $this->db->insert_batch('menu', $menu_data);
    
    // Get user's role
    $role = $this->session->userdata('auth_id_role');
    
    // Get all available roles from database
    $all_roles = $this->db->query("SELECT DISTINCT id_role FROM menu_user")->result();
    
    // Insert menu_user for all roles (or just current role if you prefer)
    $menu_user_data = array();
    
    foreach ($all_roles as $r) {
      $menu_user_data[] = array(
        'id_menu' => $start_id,
        'id_role' => $r->id_role,
        'posisi' => '1',
        'urutan' => 4,
        'level' => 1,
        'id_parent' => NULL
      );
      $menu_user_data[] = array(
        'id_menu' => $start_id + 1,
        'id_role' => $r->id_role,
        'posisi' => '1',
        'urutan' => 1,
        'level' => 2,
        'id_parent' => $start_id
      );
      $menu_user_data[] = array(
        'id_menu' => $start_id + 2,
        'id_role' => $r->id_role,
        'posisi' => '1',
        'urutan' => 2,
        'level' => 2,
        'id_parent' => $start_id
      );
      $menu_user_data[] = array(
        'id_menu' => $start_id + 3,
        'id_role' => $r->id_role,
        'posisi' => '1',
        'urutan' => 3,
        'level' => 2,
        'id_parent' => $start_id
      );
      $menu_user_data[] = array(
        'id_menu' => $start_id + 4,
        'id_role' => $r->id_role,
        'posisi' => '1',
        'urutan' => 4,
        'level' => 2,
        'id_parent' => $start_id
      );
      $menu_user_data[] = array(
        'id_menu' => $start_id + 5,
        'id_role' => $r->id_role,
        'posisi' => '1',
        'urutan' => 5,
        'level' => 2,
        'id_parent' => $start_id
      );
    }
    
    $this->db->insert_batch('menu_user', $menu_user_data);
    
    $roles_added = array();
    foreach ($all_roles as $r) {
      $roles_added[] = $r->id_role;
    }
    
    echo "<div style='padding: 50px; text-align: center; font-family: Arial;'>";
    echo "<h2 style='color: green;'>✓ Menu Berhasil Ditambahkan!</h2>";
    echo "<p>Menu 'Sistem Rekomendasi' telah ditambahkan untuk semua role:</p>";
    echo "<p><strong>" . implode(', ', $roles_added) . "</strong></p>";
    echo "<p style='color: #666; margin-top: 20px;'>Role Anda saat ini: <strong>" . $role . "</strong></p>";
    echo "<p>Silakan refresh halaman dashboard Anda (tekan Ctrl+F5)</p>";
    echo "<a href='" . site_url('Dashboard') . "' style='display: inline-block; margin-top: 20px; padding: 10px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Dashboard</a>";
    echo "</div>";
  }
}
