<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Order_m extends CI_Model {
      function get_list_count($key="", $status="1"){
          $query = $this->db->query("
              SELECT count(*) as jml FROM orders o
              LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
              LEFT JOIN pelanggan_alamat al ON o.id_alamat = al.id
              WHERE concat(o.no_invoice, p.nama) like '%$key%'     
          ")->row_array();
          return $query;
      }

      function get_list_data($key="",  $limit="", $offset="", $column="", $sort="", $status="1"){
          $query = $this->db->query("
              SELECT o.*, p.kode AS kode_pelanggan, p.nama AS nama_pelanggan, al.no_telp, al.alamat, os.keterangan as nama_status FROM orders o
              LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
              LEFT JOIN order_status os ON o.status = os.id
              LEFT JOIN pelanggan_alamat al ON o.id_alamat = al.id
              WHERE concat(o.no_invoice, p.nama) like '%$key%' 
              order by $column $sort
              limit $limit offset $offset
          ");
          return $query;
      }

      function get_pesanan_by_id($id_order){
        $query = $this->db->query("
            SELECT o.*, p.kode AS kode_pelanggan, p.nama AS nama_pelanggan, os.keterangan as nama_status, 
            al.no_telp, al.alamat, al.penerima, al.kode_pos, al.keterangan, sp.penerima AS penerima_pengiriman, 
            sp.tanggal AS tanggal_pengiriman, sp.foto AS foto_pengiriman, sp.keterangan AS keterangan_pengiriman, us.nama as nama_kurir FROM orders o
            LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
            LEFT JOIN order_status os ON o.status = os.id
            LEFT JOIN pelanggan_alamat al ON o.id_alamat = al.id
            LEFT JOIN status_pengiriman sp ON o.id = sp.id_order
            LEFT JOIN users us ON sp.id_user = us.id
            WHERE o.id = '$id_order'
        ");
        return $query;
      }

      function get_list_pesanan_detail($id_order, $id_user=""){
        $q = "
            SELECT od.*, p.nama AS nama_produk, jp.nama AS jenis_produk, kp.nama AS kategori_produk, s.nama AS satuan, 
            r.rating, r.ulasan, r.anonim FROM order_detail od
            LEFT JOIN m_produk p ON od.id_produk = p.id
            LEFT JOIN m_jenis_produk jp ON p.id_jenis_produk = jp.id
            LEFT JOIN m_kategori_produk kp ON p.id_kategori_produk = kp.id
            LEFT JOIN m_satuan s ON p.id_satuan = s.id
            LEFT JOIN (
              SELECT odt.id_produk, pr.rating, pr.ulasan, pr.anonim FROM produk_rating pr
              LEFT JOIN order_detail odt ON odt.id = pr.id_produk_detail
              WHERE odt.id_order = '$id_order'
              AND pr.id_user = '$id_user'
            ) r ON od.id_produk = r.id_produk
            WHERE od.id_order = '$id_order'    
        ";

        $query = $this->db->query($q);
        return $query;
      }

      /**
       * Function Cart
       * 
       *  */ 
      function get_list_cart($id_user){
        $query = $this->db->query("
            SELECT c.*, d.kode, d.nama, d.harga, (
              SELECT foto FROM m_produk_image
              WHERE id_produk = c.id_produk
              ORDER BY created_at asc
              LIMIT 1
            ) AS foto FROM cart c
            LEFT JOIN m_produk d ON c.id_produk = d.id
            WHERE c.id_user = '$id_user'
            AND c.is_checkout = 0        
        ");
        return $query;
      }

      function get_produk_in_cart($id_produk, $id_user){
        $query = $this->db->select('*')
                ->where(array(
                  'id_produk' => $id_produk,
                  'id_user' => $id_user,
                  'is_checkout' => 0
                ))
                ->get('cart');
        return $query;
      }

      /**
       * Function Recommendation
       * 
       */
      //untuk mengambil data rating produk dari masing-masing user
      function get_rating_produk(){
        $query = $this->db->query("
            SELECT p.kode, p.nama AS nama_produk, sum(pr.rating) AS rating, us.username FROM produk_rating pr
            LEFT JOIN order_detail od ON pr.id_produk_detail = od.id
            LEFT JOIN m_produk p ON od.id_produk = p.id
            LEFT JOIN users us ON pr.id_user = us.id
            WHERE p.status = '1'
            GROUP BY p.kode, p.nama, us.username     
            ORDER BY us.username ASC
        ");
        return $query;
      }

      function get_pesanan_by_pelanggan($id_user){
        $query = $this->db->query("
            SELECT o.*, p.kode AS kode_pelanggan, p.nama AS nama_pelanggan, al.no_telp, al.alamat, os.keterangan as nama_status FROM orders o
            LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
            LEFT JOIN order_status os ON o.status = os.id
            LEFT JOIN pelanggan_alamat al ON o.id_alamat = al.id
            WHERE p.id_user = '$id_user'
            order by o.created_at desc
        ");
        return $query;
      }

      function get_status(){
        $query = $this->db->select('id, keterangan')
                ->order_by('id', 'asc')
                ->get('order_status');
        return $query;
      }

      function get_data_pesanan_dikirim(){
          $query = $this->db->query("
              SELECT o.*, p.kode AS kode_pelanggan, p.nama AS nama_pelanggan FROM orders o
              LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
              LEFT JOIN status_pengiriman sp ON o.id = sp.id_order
              WHERE o.STATUS = '3'
              AND sp.tanggal IS NULL
          ");
          return $query;
      }

    }
?>