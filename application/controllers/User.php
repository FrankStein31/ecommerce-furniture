<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    private $nama_menu  = "User";     

    public function __construct()
    {
        parent::__construct();
        $this->apl = get_apl();
        $this->load->model('Menu_m');
        $this->load->model('M_main');
        $this->load->model('User_m');
        must_login();
    }
    
    public function index()
    {
        $this->Menu_m->role_has_access($this->nama_menu);

        $data['app'] = $this->apl;
        $data['nama_menu'] = $this->nama_menu;
        $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

        // Breadcrumbs
        $this->mybreadcrumb->add('Beranda', site_url('Beranda'));
        $this->mybreadcrumb->add($this->nama_menu, site_url('User'));
        $data['breadcrumbs'] = $this->mybreadcrumb->render();
        // End Breadcrumbs
 
        $data['content'] = "user/index.php";
        $this->parser->parse('sistem/template', $data);
    }    

    public function fetch_data(){
      $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
      $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
      $limit	= $this->input->get("limit");
      $offset = ($limit*$pg)-$limit;
      $column = $this->input->get("sortby");
      $sort   = $this->input->get("sorttype");

      $page              = array();
      $page['limit']     = $limit;
      $page['count_row'] = $this->User_m->list_count($key)['jml'];
      $page['current']   = $pg;
      $page['list']      = gen_paging($page);
      $data['paging']    = $page;
      $data['list']      = $this->User_m->list_data($key, $limit, $offset, $column, $sort);

		  $this->load->view('sistem/user/list_data',$data);
    }

    public function load_modal(){
        $id = $this->input->post('id');
        $data['list_role'] = $this->M_main->get_all('roles')->result();
        if ($id!=""){
            $data['mode'] = "UPDATE";
            $data['data_user'] =  $this->M_main->get_where('users','id',$id)->row_array();
        }else{
            $data['mode'] = "ADD";
            $data['kosong'] = "";
        }
        $this->load->view('sistem/user/form_modal',$data);
    }

    public function save(){
        $modeform = $this->input->post('modeform');
        $nama = strip_tags(trim($this->input->post('nama_user')));
        $username = strip_tags(trim($this->input->post('username')));
        $email = strip_tags(trim($this->input->post('email')));
        $password = strip_tags($this->input->post('password'));
        $hak_akses = strip_tags(trim($this->input->post('hak_akses')));
        $id_user = strip_tags(trim($this->input->post('id')));

        if($id_user == ""){
            $get_username = $this->M_main->get_where('users','username',$username)->num_rows();   
            $get_email = $this->M_main->get_where('users','email',$email)->num_rows();

            if($get_username!=0){
              $response['success'] = FALSE;
              $response['message'] = "Maaf, Username Sudah Terdaftar, Harap gunakan username lain !";
            }else if($get_email!=0){
              $response['success'] = FALSE;
              $response['message'] = "Maaf, Email Sudah Terdaftar !"; 
            }else{
              $id = $this->uuid->v4(false);
              date_default_timezone_set('Asia/Jakarta');
              $data_object = array(
                  'id' => $id, 
                  'nama'=>$nama,
                  'username'=>$username,
                  'email'=>$email,
                  'password'=>md5($password),
                  'created_at'=>date('Y-m-d H:i:s'),
                  'status'=>'1',
                  'id_role'=>$hak_akses,
              );
              $this->db->insert('users', $data_object);

              $response['success'] = TRUE;
              $response['message'] = "Data User Berhasil Disimpan";
            }
        }else{
            date_default_timezone_set('Asia/Jakarta');
            if($password==""){
              $us =  $this->M_main->get_where('users', 'id', $id_user)->row_array();
              $password = $us['password'];
            }else{
              $password = md5($password);
            }
            
            $data_object = array(  
                'nama'=>$nama,
                'username'=>$username,
                'email'=>$email,
                'password'=>$password,
                'id_role'=>$hak_akses,
                'updated_at'=>date('Y-m-d H:i:s'),
            );
				
            $this->db->where('id',$id_user);
            $this->db->update('users', $data_object);

            $response['success'] = true;
            $response['message'] = "Data User Berhasil Diperbarui !";
        }
        echo json_encode($response);   
    }

    public function delete($id){
      if($id){
        $this->db->where('id', $id);
        $this->db->delete('users');

        $response['success'] = true;
        $response['message'] = "Data berhasil dihapus !";
      }else{
        $response['success'] = false;
        $response['message'] = "Data tidak ditemukan !";
      }
      echo json_encode($response);
    }
}

/* End of file User.php */
