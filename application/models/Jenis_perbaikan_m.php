<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_perbaikan_m extends CI_Model {
    
    private $table = 'jenis_perbaikan';
    
    /**
     * Get all jenis perbaikan dengan join kategori
     */
    public function get_all_with_kategori($status = null)
    {
        $this->db->select('jp.*, kp.nama_kategori');
        $this->db->from($this->table.' jp');
        $this->db->join('kategori_jenis_perbaikan kp', 'jp.id_kategori = kp.id', 'left');
        
        if ($status !== null) {
            $this->db->where('jp.status', $status);
        }
        
        $this->db->order_by('kp.nama_kategori', 'ASC');
        $this->db->order_by('jp.urutan', 'ASC');
        $this->db->order_by('jp.nama_jenis_perbaikan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get jenis perbaikan by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    /**
     * Get jenis perbaikan by kategori
     */
    public function get_by_kategori($id_kategori, $status = '1')
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_kategori', $id_kategori);
        
        if ($status !== null) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('nama_jenis_perbaikan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Insert jenis perbaikan baru
     */
    public function insert($data)
    {
        // Tambahkan timestamp
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Update jenis perbaikan
     */
    public function update($id, $data)
    {
        // Update timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete jenis perbaikan
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get total count untuk pagination
     */
    public function get_total($search = '', $id_kategori = null)
    {
        if (!empty($search)) {
            $this->db->like('nama_jenis_perbaikan', $search);
            $this->db->or_like('deskripsi', $search);
        }
        
        if ($id_kategori !== null) {
            $this->db->where('id_kategori', $id_kategori);
        }
        
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get dropdown untuk select option
     */
    public function get_dropdown($id_kategori = null)
    {
        $this->db->select('id, nama_jenis_perbaikan');
        $this->db->from($this->table);
        $this->db->where('status', '1');
        
        if ($id_kategori !== null) {
            $this->db->where('id_kategori', $id_kategori);
        }
        
        $this->db->order_by('nama_jenis_perbaikan', 'ASC');
        
        $query = $this->db->get()->result();
        
        $dropdown = [];
        foreach ($query as $row) {
            $dropdown[$row->id] = $row->nama_jenis_perbaikan;
        }
        
        return $dropdown;
    }
}
