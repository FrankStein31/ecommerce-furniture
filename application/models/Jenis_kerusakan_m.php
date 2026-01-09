<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_kerusakan_m extends CI_Model {

  public function get_all()
  {
    $query = "
      SELECT 
        jk.*,
        GROUP_CONCAT(gk.nama_gejala SEPARATOR ', ') as gejala_list,
        COUNT(DISTINCT jkg.id_gejala) as jumlah_gejala
      FROM jenis_kerusakan jk
      LEFT JOIN jenis_kerusakan_gejala jkg ON jk.id = jkg.id_jenis_kerusakan
      LEFT JOIN gejala_kerusakan gk ON jkg.id_gejala = gk.id
      GROUP BY jk.id
      ORDER BY jk.kode_kerusakan ASC
    ";
    
    return $this->db->query($query)->result();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('jenis_kerusakan', array('id' => $id))->row();
  }

  public function insert($data)
  {
    $this->db->insert('jenis_kerusakan', $data);
    return $this->db->insert_id();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    return $this->db->update('jenis_kerusakan', $data);
  }

  public function delete($id)
  {
    return $this->db->delete('jenis_kerusakan', array('id' => $id));
  }

  // Relasi dengan gejala
  public function insert_relasi($data)
  {
    return $this->db->insert('jenis_kerusakan_gejala', $data);
  }

  public function delete_relasi($id_jenis_kerusakan)
  {
    return $this->db->delete('jenis_kerusakan_gejala', array('id_jenis_kerusakan' => $id_jenis_kerusakan));
  }

  public function get_relasi_gejala($id_jenis_kerusakan)
  {
    $query = $this->db->query("
      SELECT id_gejala 
      FROM jenis_kerusakan_gejala 
      WHERE id_jenis_kerusakan = ?
    ", array($id_jenis_kerusakan));
    
    $result = array();
    foreach ($query->result() as $row) {
      $result[] = $row->id_gejala;
    }
    
    return $result;
  }

  public function get_by_tingkat($tingkat)
  {
    return $this->db->get_where('jenis_kerusakan', array(
      'tingkat_kerusakan' => $tingkat,
      'status' => '1'
    ))->result();
  }

  public function get_dropdown()
  {
    $query = $this->db->query("
      SELECT id, CONCAT(kode_kerusakan, ' - ', nama_jenis_kerusakan) as label
      FROM jenis_kerusakan
      WHERE status = '1'
      ORDER BY kode_kerusakan ASC
    ");
    
    $result = array();
    foreach ($query->result() as $row) {
      $result[$row->id] = $row->label;
    }
    
    return $result;
  }

  // Generate kode kerusakan otomatis (JK001, JK002, ...)
  public function generate_kode_kerusakan()
  {
    $query = $this->db->query("
      SELECT kode_kerusakan 
      FROM jenis_kerusakan 
      ORDER BY kode_kerusakan DESC 
      LIMIT 1
    ");
    
    if ($query->num_rows() > 0) {
      $last_kode = $query->row()->kode_kerusakan;
      // Extract nomor dari kode (JK001 -> 001)
      $number = intval(substr($last_kode, 2));
      $next_number = $number + 1;
    } else {
      $next_number = 1;
    }
    
    // Format: JK + zero-padded 3 digit (JK001, JK002, ... JK999)
    return 'JK' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
  }
}
