<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Rating_m extends CI_Model {
      function get_list_count($id_produk){
          $query = $this->db->query("
              SELECT count(*) as jml FROM produk_rating pr
              LEFT JOIN order_detail od ON pr.id_produk_detail = od.id
              LEFT JOIN users u ON pr.id_user = u.id
              WHERE od.id_produk = '$id_produk'
          ")->row_array();
          return $query;
      }

      function get_list_data($id_produk, $limit="", $offset="", $column="", $sort=""){
          $query = $this->db->query("
              SELECT pr.*, u.nama, u.foto FROM produk_rating pr
              LEFT JOIN order_detail od ON pr.id_produk_detail = od.id
              LEFT JOIN users u ON pr.id_user = u.id
              WHERE od.id_produk = '$id_produk'
              order by $column $sort
              limit $limit offset $offset
          ");
          return $query;
      }
    }
?>