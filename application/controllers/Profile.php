<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {

  private $nama_menu  = "Profile";     

  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('M_main');
    must_login();
  }
  
  public function index()
  {
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

    $id_user = $this->session->userdata("auth_id_user");
    $data_user = $this->M_main->get_where('users', 'id', $id_user)->row_array();
    $data['user'] = $data_user;      
    $data['content'] = "profile/index.php";
    $this->parser->parse('sistem/template', $data);
  }

  public function simpan_foto(){
    $id_user = $this->input->post('id_user');
    $cek_user = $this->M_main->get_where('users', 'id', $id_user);                    
    if($cek_user->num_rows()!=0){
      $p_user = $cek_user->row_array();
      $foto_profile = do_upload_file('foto_user', 'upload_foto', 'assets/uploads/user/', 'jpg|png|jpeg');
      $path = $foto_profile['file_name'];

      $data_object = array(
        'foto' => $path, 
      );
      $this->db->where('id', $id_user);
      $this->db->update('users', $data_object);

      $pathFileLama = $p_user['foto'];
      if($pathFileLama!=""){
        if(file_exists($pathFileLama)){
          unlink($pathFileLama);
        } 
      }

      $ses_array = array(
        'auth_foto' => $path,
      );
      $this->session->set_userdata( $ses_array );

      $response['success'] = TRUE;
      $response['message'] = "Foto Berhasil Diperbarui";
    }else{
      $response['success'] = FALSE;
      $response['message'] = "Data Tidak Ditemukan !";
    }
    echo json_encode($response);
  }

  function update_password() {
    $id = $this->input->post('id_user');
    $password = $this->input->post("konfirm_password");
    date_default_timezone_set('Asia/Jakarta');
    $object = array(
      'password' => md5($password), 
    );
    $this->db->where('id', $id);
    $this->db->update('users', $object);
    
    $response['success'] = TRUE;
    $response['message'] = "Password Berhasil Diperbarui!";
    echo json_encode($response);	
  }

  function update_profile() {
    $id = $this->input->post('id_user');
    $nama_user = $this->input->post("nama_user");

    date_default_timezone_set('Asia/Jakarta');
    $object = array( 
      'nama' => $nama_user, 
    );
    $this->db->where('id', $id);
    $this->db->update('users', $object);

    $ses_array = array(
      'auth_nama_user' => $nama_user,
    );
    $this->session->set_userdata( $ses_array );
    
    $response['success'] = TRUE;
    $response['message'] = "Data Profil berhasil Diperbarui!";
    echo json_encode($response);	
  }
}

/* End of file Profile.php */
