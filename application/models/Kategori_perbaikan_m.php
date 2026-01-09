<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_perbaikan_m extends CI_Model {
    
    private $table = 'kategori_jenis_perbaikan';
    
    /**
     * Get all kategori
     */
    public function get_all($status = null)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        
        if ($status !== null) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('nama_kategori', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get kategori by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    /**
     * Insert kategori baru
     */
    public function insert($data)
    {
        // Tambahkan timestamp
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Update kategori
     */
    public function update($id, $data)
    {
        // Update timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete kategori
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get total count untuk pagination
     */
    public function get_total($search = '')
    {
        if (!empty($search)) {
            $this->db->like('nama_kategori', $search);
            $this->db->or_like('deskripsi', $search);
        }
        
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get kategori dengan pagination
     */
    public function get_paginated($limit, $offset, $search = '')
    {
        $this->db->select('*');
        $this->db->from($this->table);
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_kategori', $search);
            $this->db->or_like('deskripsi', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('nama_kategori', 'ASC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get()->result();
    }
    
    /**
     * Get active kategori untuk dropdown
     */
    public function get_dropdown()
    {
        $this->db->select('id, nama_kategori');
        $this->db->from($this->table);
        $this->db->where('status', '1');
        $this->db->order_by('urutan', 'ASC');
        
        $query = $this->db->get()->result();
        
        $dropdown = [];
        foreach ($query as $row) {
            $dropdown[$row->id] = $row->nama_kategori;
        }
        
        return $dropdown;
    }
}
