<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
    class Laporan_m extends CI_Model {
        // Laporan penjualan 
        function get_count_laporan_penjualan($filter=array()){
          $tgl_awal = $filter['tanggal_awal'];
          $tgl_akhir = $filter['tanggal_akhir'];
          $key = $filter['q'];
  
          $q = "
            SELECT count(*) as jml FROM orders o
            LEFT JOIN order_detail od ON o.id = od.id_order
            LEFT JOIN m_produk pd ON od.id_produk = pd.id
            LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
            LEFT JOIN order_status os ON o.status = os.id
            WHERE concat(o.no_invoice, pd.nama, p.nama) like '%$key%' 
            AND o.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir';
          "; 
        
          $query = $this->db->query($q)->row_array();
          return $query;
        }
  
        function get_laporan_penjualan($filter=array()){
            $with_pagination = $filter['with_pagination'];
            $tgl_awal = $filter['tanggal_awal'];
            $tgl_akhir = $filter['tanggal_akhir'];
            $sortby = $filter['sortby'];
            $sorttype = $filter['sorttype'];
            $offset = $filter['offset'];
            $limit = $filter['limit'];
            $key = $filter['q']; 
          
            $q = "
              select * from (
                SELECT od.*, o.no_invoice, o.tanggal, p.kode AS kode_pelanggan, p.nama AS nama_pelanggan, os.keterangan as nama_status,
                pd.kode AS kode_produk, pd.nama AS nama_produk FROM orders o
                LEFT JOIN order_detail od ON o.id = od.id_order
                LEFT JOIN m_produk pd ON od.id_produk = pd.id
                LEFT JOIN m_pelanggan p ON o.id_pelanggan = p.id
                LEFT JOIN order_status os ON o.status = os.id
                WHERE concat(o.no_invoice, pd.nama, p.nama) like '%$key%'
                AND o.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
              )x
            "; 
  
            if($with_pagination){
              $q .= "
                order by $sortby $sorttype
                limit $limit offset $offset
              ";
            }else{
              $q .= " order by x.tanggal desc ";
            }
          
            $query = $this->db->query($q);
            return $query;
        }

        // Laporan produk terjual
        function get_count_laporan_produk_terjual($filter=array()){
          $tgl_awal = $filter['tanggal_awal'];
          $tgl_akhir = $filter['tanggal_akhir'];
          $key = $filter['q'];
  
          $q = "
              SELECT count(*) as jml FROM m_produk p
                LEFT JOIN (
                  SELECT od.id_produk, SUM(qty) AS jumlah_terjual FROM orders o
                  LEFT JOIN order_detail od ON o.id = od.id_order
                  WHERE o.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
                  GROUP BY od.id_produk 
                )o ON p.id = o.id_produk
                WHERE concat(p.nama) like '%$key%' 
                AND STATUS = '1'
          "; 
        
          $query = $this->db->query($q)->row_array();
          return $query;
        }
  
        function get_laporan_produk_terjual($filter=array()){
            $with_pagination = $filter['with_pagination'];
            $tgl_awal = $filter['tanggal_awal'];
            $tgl_akhir = $filter['tanggal_akhir'];
            $sortby = $filter['sortby'];
            $sorttype = $filter['sorttype'];
            $offset = $filter['offset'];
            $limit = $filter['limit'];
            $key = $filter['q']; 
          
            $q = "
                SELECT p.kode as kode_produk, p.nama as nama_produk, s.nama as satuan, COALESCE(o.jumlah_terjual, 0) AS jumlah_terjual FROM m_produk p
                LEFT JOIN (
                  SELECT od.id_produk, SUM(qty) AS jumlah_terjual FROM orders o
                  LEFT JOIN order_detail od ON o.id = od.id_order
                  WHERE o.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
                  GROUP BY od.id_produk 
                )o ON p.id = o.id_produk
                LEFT JOIN m_satuan s ON p.id_satuan = s.id
                WHERE concat(p.nama) like '%$key%' 
                AND p.status = '1' 
            "; 
  
            if($with_pagination){
              $q .= "
                order by $sortby $sorttype
                limit $limit offset $offset
              ";
            }else{
              $q .= " order by o.jumlah_terjual desc ";
            }
          
            $query = $this->db->query($q);
            return $query;
        }

    }
    /* End of file Laporan_m.php */    
?>