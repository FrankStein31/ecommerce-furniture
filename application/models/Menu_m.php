<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
    class Menu_m extends CI_Model {
        private $redirect_default = 'Auth';
        function role_has_access($menu){
            $id_role = $this->session->userdata('auth_id_role');
            $query=$this->db->query("
                select mu.id_menu from menu_user mu
                join menu m on m.id = mu.id_menu
                where mu.id_role = '$id_role' and UPPER(m.nama) = UPPER('$menu')		
            ");
            if($query->num_rows()==0){
                redirect(site_url($this->redirect_default), 'refresh');
            }
        }
    }
    /* End of file Menu_m.php */    
?>