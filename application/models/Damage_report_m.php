<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Damage_report_m extends CI_Model
{

    private $table = 'damage_reports';

    public function __construct()
    {
        parent::__construct();
    }

    public function save_report($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_reports($limit = null, $offset = null, $where = null)
    {
        if ($where) {
            $this->db->where($where);
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('report_date', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get_report_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function update_report($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_report($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }

    public function count_reports($where = null)
    {
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_reports_by_status($status)
    {
        return $this->db->get_where($this->table, array('status' => $status))->result();
    }
}

/* End of file Damage_report_m.php */
