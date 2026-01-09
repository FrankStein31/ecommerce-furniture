<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Dashboard_m extends CI_Model {
      function get_dashboard(){
          $produk = $this->db->query(" SELECT COUNT(*) AS jml FROM m_produk WHERE STATUS = '1'")->row_array();
          $pelanggan = $this->db->query(" SELECT COUNT(*) AS jml FROM m_pelanggan WHERE STATUS = '1'")->row_array();
          $order = $this->db->query(" SELECT COUNT(*) AS jml FROM orders")->row_array();
          $order_selesai = $this->db->query(" SELECT COUNT(*) AS jml FROM orders WHERE status = '4'")->row_array();
          $data = array(
              'total_produk' => $produk['jml'],
              'total_pelanggan' => $pelanggan['jml'],
              'total_pesanan' => $order['jml'],
              'pesanan_selesai' => $order_selesai['jml'],
          );
          
          return $data;
      }
    }
?>