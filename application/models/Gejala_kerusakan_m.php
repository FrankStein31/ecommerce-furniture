<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gejala_kerusakan_m extends CI_Model {

  public function get_all()
  {
    $query = "
      SELECT 
        gk.*,
        GROUP_CONCAT(jp.nama_jenis_perbaikan SEPARATOR ', ') as jenis_perbaikan_list
      FROM gejala_kerusakan gk
      LEFT JOIN gejala_jenis_perbaikan gjp ON gk.id = gjp.id_gejala
      LEFT JOIN jenis_perbaikan jp ON gjp.id_jenis_perbaikan = jp.id
      GROUP BY gk.id
      ORDER BY gk.kode_gejala ASC
    ";
    
    return $this->db->query($query)->result();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('gejala_kerusakan', array('id' => $id))->row();
  }

  public function insert($data)
  {
    $this->db->insert('gejala_kerusakan', $data);
    return $this->db->insert_id();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    return $this->db->update('gejala_kerusakan', $data);
  }

  public function delete($id)
  {
    return $this->db->delete('gejala_kerusakan', array('id' => $id));
  }

  // Relasi dengan jenis perbaikan
  public function insert_relasi($data)
  {
    return $this->db->insert('gejala_jenis_perbaikan', $data);
  }

  public function delete_relasi($id_gejala)
  {
    return $this->db->delete('gejala_jenis_perbaikan', array('id_gejala' => $id_gejala));
  }

  public function get_relasi_jenis($id_gejala)
  {
    $query = $this->db->query("
      SELECT id_jenis_perbaikan 
      FROM gejala_jenis_perbaikan 
      WHERE id_gejala = ?
    ", array($id_gejala));
    
    $result = array();
    foreach ($query->result() as $row) {
      $result[] = $row->id_jenis_perbaikan;
    }
    
    return $result;
  }

  public function get_by_jenis($id_jenis)
  {
    $query = "
      SELECT DISTINCT gk.*
      FROM gejala_kerusakan gk
      INNER JOIN gejala_jenis_perbaikan gjp ON gk.id = gjp.id_gejala
      WHERE gjp.id_jenis_perbaikan = ?
      AND gk.status = '1'
      ORDER BY gk.kode_gejala ASC
    ";
    
    return $this->db->query($query, array($id_jenis))->result();
  }

  public function get_dropdown()
  {
    $query = $this->db->query("
      SELECT id, CONCAT(kode_gejala, ' - ', nama_gejala) as label
      FROM gejala_kerusakan
      WHERE status = '1'
      ORDER BY kode_gejala ASC
    ");
    
    $result = array();
    foreach ($query->result() as $row) {
      $result[$row->id] = $row->label;
    }
    
    return $result;
  }

  // Generate kode gejala otomatis (G01, G02, G03, ...)
  public function generate_kode_gejala()
  {
    // Ambil kode terakhir
    $query = $this->db->query("
      SELECT kode_gejala 
      FROM gejala_kerusakan 
      ORDER BY kode_gejala DESC 
      LIMIT 1
    ");
    
    if ($query->num_rows() > 0) {
      $last_kode = $query->row()->kode_gejala;
      // Extract nomor dari kode (G01 -> 01)
      $number = intval(substr($last_kode, 1));
      $next_number = $number + 1;
    } else {
      $next_number = 1;
    }
    
    // Format: G + zero-padded 2 digit (G01, G02, ... G99)
    return 'G' . str_pad($next_number, 2, '0', STR_PAD_LEFT);
  }
}
