<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class User_m extends CI_Model {
        function list_count($key="", $status="1"){
            $query = $this->db->query("
                    select count(*) as jml from users us
                    left join roles r on us.id_role = r.id
                    where concat(us.nama, us.email, us.username, us.status, r.id, r.nama) like '%$key%'
            ")->row_array();
            return $query;
        }
    
        function list_data($key="",  $limit="", $offset="", $column="", $sort="", $status="1"){
            $query = $this->db->query("
                    select us.*, r.nama as nama_role from users us
                    left join roles r on us.id_role = r.id
                    where concat(us.nama, us.email, us.username, us.status, r.id, r.nama) like '%$key%' 
                    order by $column $sort
                    limit $limit offset $offset
            ");
            return $query;
        }
        
        function detail_user($id){
            $query = $this->db->query("                                    
                    select us.*, r.nama as nama_role from users us
                    left join roles r on us.id_role = r.id
                    where us.id = '$id'
            ");
            return $query;
        }

        function get_all(){
          $query = $this->db->select('id, nama, username, email')
                  ->order_by('nama', 'asc')
                  ->get('users');
          return $query;
        }
    }
    /* End of file User_m.php */    
?>