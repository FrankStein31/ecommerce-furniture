<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Auth_m extends CI_Model {
      public function check_auth_login($username, $password){
          $query  = $this->db->query("
              SELECT * FROM users 
              WHERE (username = '$username' or email = '$username') AND password = '$password'
              limit 1
          ");
          return $query;
      }
      public function auth_by_id($user_id){
          $query  = $this->db->query("
              SELECT us.*, r.nama as nama_role FROM users us
              LEFT JOIN roles r ON us.id_role = r.id
              WHERE us.id = '$user_id' 
          ");
          return $query;          
      }
    }
?>