<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekomendasi_perbaikan_m extends CI_Model {

  public function get_all()
  {
    $query = "
      SELECT 
        rp.*,
        GROUP_CONCAT(DISTINCT CONCAT(jk.kode_kerusakan, ' - ', jk.nama_jenis_kerusakan) SEPARATOR ', ') as kerusakan_list,
        COUNT(DISTINCT rrjk.id_jenis_kerusakan) as jumlah_kerusakan
      FROM rekomendasi_perbaikan rp
      LEFT JOIN relasi_rekomendasi_jenis_kerusakan rrjk ON rp.id = rrjk.id_rekomendasi_perbaikan
      LEFT JOIN jenis_kerusakan jk ON rrjk.id_jenis_kerusakan = jk.id
      GROUP BY rp.id
      ORDER BY rp.kode_rekomendasi ASC
    ";
    
    return $this->db->query($query)->result();
  }

  public function get_by_id($id)
  {
    return $this->db->get_where('rekomendasi_perbaikan', array('id' => $id))->row();
  }

  public function insert($data)
  {
    $this->db->insert('rekomendasi_perbaikan', $data);
    return $this->db->insert_id();
  }

  public function update($id, $data)
  {
    $this->db->where('id', $id);
    return $this->db->update('rekomendasi_perbaikan', $data);
  }

  public function delete($id)
  {
    return $this->db->delete('rekomendasi_perbaikan', array('id' => $id));
  }

  // Relasi dengan jenis kerusakan
  public function insert_relasi($data)
  {
    return $this->db->insert('relasi_rekomendasi_jenis_kerusakan', $data);
  }

  public function delete_relasi($id_rekomendasi)
  {
    return $this->db->delete('relasi_rekomendasi_jenis_kerusakan', array('id_rekomendasi_perbaikan' => $id_rekomendasi));
  }

  public function get_relasi_kerusakan($id_rekomendasi)
  {
    $query = $this->db->query("
      SELECT id_jenis_kerusakan 
      FROM relasi_rekomendasi_jenis_kerusakan 
      WHERE id_rekomendasi_perbaikan = ?
    ", array($id_rekomendasi));
    
    $result = array();
    foreach ($query->result() as $row) {
      $result[] = $row->id_jenis_kerusakan;
    }
    
    return $result;
  }

  public function get_by_prioritas($prioritas)
  {
    return $this->db->get_where('rekomendasi_perbaikan', array(
      'tingkat_prioritas' => $prioritas,
      'status' => '1'
    ))->result();
  }

  public function get_dropdown()
  {
    $query = $this->db->query("
      SELECT id, CONCAT(kode_rekomendasi, ' - ', nama_rekomendasi) as label
      FROM rekomendasi_perbaikan
      WHERE status = '1'
      ORDER BY kode_rekomendasi ASC
    ");
    
    $result = array();
    foreach ($query->result() as $row) {
      $result[$row->id] = $row->label;
    }
    
    return $result;
  }

  // Generate kode rekomendasi otomatis (R01, R02, ...)
  public function generate_kode_rekomendasi()
  {
    $query = $this->db->query("
      SELECT kode_rekomendasi 
      FROM rekomendasi_perbaikan 
      ORDER BY kode_rekomendasi DESC 
      LIMIT 1
    ");
    
    if ($query->num_rows() > 0) {
      $last_kode = $query->row()->kode_rekomendasi;
      // Extract nomor dari kode (R01 -> 01)
      $number = intval(substr($last_kode, 1));
      $next_number = $number + 1;
    } else {
      $next_number = 1;
    }
    
    // Format: R + zero-padded 2 digit (R01, R02, ... R99)
    return 'R' . str_pad($next_number, 2, '0', STR_PAD_LEFT);
  }

  // Get rekomendasi dengan CF terbesar
  public function get_top_recommendations($limit = 5)
  {
    $this->db->select('*');
    $this->db->from('rekomendasi_perbaikan');
    $this->db->where('status', '1');
    $this->db->order_by('cf_value', 'DESC');
    $this->db->limit($limit);
    
    return $this->db->get()->result();
  }
}
