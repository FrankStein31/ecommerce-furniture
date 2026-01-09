<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_order_m extends CI_Model
{
    private $table = 'service_orders';

    public function __construct()
    {
        parent::__construct();
    }

    public function save_order($data)
    {
        // Cek apakah tabel sudah ada, jika belum buat
        if (!$this->db->table_exists($this->table)) {
            $this->create_table();
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_order($order_id)
    {
        if (!$this->db->table_exists($this->table)) {
            return false;
        }

        return $this->db->where('order_id', $order_id)->get($this->table)->row();
    }

    public function get_orders($limit = null, $offset = null)
    {
        if (!$this->db->table_exists($this->table)) {
            return false;
        }

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->order_by('order_date', 'desc')->get($this->table)->result();
    }

    public function get_orders_by_user($user_id)
    {
        if (!$this->db->table_exists($this->table)) {
            return [];
        }

        return $this->db->where('user_id', $user_id)
            ->order_by('order_date', 'desc')
            ->get($this->table)
            ->result();
    }

    public function update_order($order_id, $data)
    {
        if (!$this->db->table_exists($this->table)) {
            return false;
        }

        $this->db->where('order_id', $order_id);
        return $this->db->update($this->table, $data);
    }

    public function update_status($order_id, $status)
    {
        if (!$this->db->table_exists($this->table)) {
            return false;
        }

        $data = array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('order_id', $order_id);
        return $this->db->update($this->table, $data);
    }

    public function get_order_count_by_status($status = null)
    {
        if (!$this->db->table_exists($this->table)) {
            return 0;
        }

        if ($status !== null) {
            $this->db->where('status', $status);
        }

        return $this->db->count_all_results($this->table);
    }

    public function get_order_by_id($id)
    {
        if (!$this->db->table_exists($this->table)) {
            return false;
        }

        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function update_order_by_order_id($order_id, $data)
    {
        if (!$this->db->table_exists($this->table)) {
            return false;
        }

        $this->db->where('order_id', $order_id);
        return $this->db->update($this->table, $data);
    }

    public function get_list_count($search = '')
    {
        if (!$this->db->table_exists($this->table)) {
            return array('jml' => 0);
        }

        if ($search != '') {
            $this->db->group_start();
            $this->db->like('order_id', $search);
            $this->db->or_like('customer_name', $search);
            $this->db->or_like('phone_number', $search);
            $this->db->or_like('service_type', $search);
            $this->db->group_end();
        }

        $count = $this->db->count_all_results($this->table);
        return array('jml' => $count);
    }

    public function get_list_data($search = '', $limit = 10, $offset = 0, $column = 'order_date', $sort = 'desc')
    {
        if (!$this->db->table_exists($this->table)) {
            return [];
        }

        if ($search != '') {
            $this->db->group_start();
            $this->db->like('order_id', $search);
            $this->db->or_like('customer_name', $search);
            $this->db->or_like('phone_number', $search);
            $this->db->or_like('service_type', $search);
            $this->db->group_end();
        }

        $this->db->order_by($column, $sort);
        $this->db->limit($limit, $offset);

        return $this->db->get($this->table)->result();
    }

    private function create_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `order_id` varchar(50) NOT NULL,
            `customer_name` varchar(100) NOT NULL,
            `phone_number` varchar(20) NOT NULL,
            `address` text NOT NULL,
            `service_type` varchar(50) NOT NULL,
            `service_method` varchar(50) NOT NULL,
            `damage_description` text NOT NULL,
            `material_type` varchar(100) DEFAULT NULL,
            `foam_modification` varchar(100) DEFAULT NULL,
            `shape_modification` varchar(100) DEFAULT NULL,
            `service_date` date NOT NULL,
            `service_time` varchar(20) NOT NULL,
            `special_notes` text DEFAULT NULL,
            `estimated_cost` varchar(50) DEFAULT NULL,
            `vehicle_brand` varchar(100) DEFAULT NULL,
            `chair_type` varchar(100) DEFAULT NULL,
            `bed_size` varchar(50) DEFAULT NULL,
            `order_photos` text DEFAULT NULL,
            `order_date` datetime NOT NULL,
            `status` varchar(50) NOT NULL DEFAULT 'pesanan_diterima',
            `admin_notes` text DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `order_id` (`order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $this->db->query($sql);
    }
}

/* End of file Service_order_m.php */
