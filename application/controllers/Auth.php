<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {     

  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('M_main');
		$this->load->model('Auth_m');
  }
  
  public function index()
	{
		$this->load->view('auth/login');
  }
  
  public function register()
	{
		$this->load->view('auth/register');
  }

  public function login()
  {
      $this->form_validation->set_rules('username', 'username', 'trim|required');
      $this->form_validation->set_rules('password', 'password', 'trim|required');
      if ($this->form_validation->run() == FALSE){
        $response['success'] = false;
        $response['message'] = "Username atau Password tidak boleh kosong !";
      }else{
        $username = strip_tags($this->input->post('username'));
        $password = md5(strip_tags($this->input->post('password')));
        
        $cek_status = $this->Auth_m->check_auth_login($username, $password);
        if($cek_status->num_rows()!=0){
          $users = $cek_status->row_array();
          $status = $users['status'];
          $email = $users['email'];
          //cek status (aktif, terblokir)
          if($status=="3"){
            $response['success'] = false;
            $response['message'] = "Akun Anda diblokir oleh sistem, hubungi pusat bantuan untuk memulihkannya !";
          }elseif($status=="2"){
            $response['success'] = false;
            $response['message'] = "Anda belum memverifikasi Email yang telah kami kirimkan ke $email !";
          }elseif($status=="1"){
            $cek_login = $this->Auth_m->auth_by_id($users['id']);
            if($cek_login->num_rows()!=0){
              //user ditemukan
              $data_login=$cek_login->result();
              $ses_array = array(
                'auth_id_user' => $data_login[0]->id, 
                'auth_nama_user' => $data_login[0]->nama,
                'auth_username' => $data_login[0]->username,
                'auth_email' => $data_login[0]->email,
                'auth_id_role' => $data_login[0]->id_role, 
                'auth_nama_role' => $data_login[0]->nama_role,
                'auth_foto' => $data_login[0]->foto,
                'auth_is_login' => TRUE,
              );
              $this->session->set_userdata( $ses_array );
          
              $response['success'] = true;
              $response['message'] = "Selamat Datang ".$data_login[0]->nama." !";
              $response['page'] = ($data_login[0]->id_role=='PELANGGAN') ? '/' : '/Dashboard';
            }else{
              //Akun Anda user salah
              $response['success'] = false;
              $response['message'] = "Akun Anda Tidak Ditemukan !";
            }
          }else{
            $response['success'] = false;
            $response['message'] = "Akun Anda dinonaktifkan !";
          }
        }else{
          //Akun Anda user salah
          $response['success'] = false;
          $response['message'] = "Username atau password salah !";
        }
      }
      echo json_response($response);
  }

  // Function untuk registrasi akun
  public function daftar_akun()
  {
      $this->form_validation->set_rules('username', 'username', 'trim|required');
      $this->form_validation->set_rules('password', 'password', 'trim|required');
      if ($this->form_validation->run() == FALSE){
        $response['success'] = false;
        $response['message'] = "Harap lengkapi bidang yang kosong !";
      }else{
        $nama = strip_tags($this->input->post('nama'));
        $email = strip_tags($this->input->post('email'));
        $alamat = strip_tags($this->input->post('alamat'));
        $no_telp = strip_tags($this->input->post('no_telp'));
        $username = strip_tags($this->input->post('username'));
        $password = md5(strip_tags($this->input->post('password')));

        $get_email = $this->M_main->get_where('users', 'email', $email)->num_rows();
        $get_username = $this->M_main->get_where('users', 'username', $username)->num_rows();
        if($get_email!=0){
          $response['success'] = FALSE;
          $response['message'] = "Maaf, Email sudah terdaftar !"; 
        }else if($get_username!=0){
          $response['success'] = FALSE;
          $response['message'] = "Maaf, Username sudah terdaftar !"; 
        }else{
          // Insert User
          $id_user = $this->uuid->v4(false);    
          $data_object = array(
            'id'=>$id_user,
            'nama'=>$nama,
            'username'=>$username,
            'email'=>$email,
            'password'=>$password,
            'id_role'=>'PELANGGAN',
            'status'=>'2',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
          );
          $this->db->insert('users', $data_object);

          // Insert Pelanggan
          $id = $this->uuid->v4(false);    
          $kode = $this->M_main->get_kode_master_v3('CS', 'kode', 'm_pelanggan');
          $data_object = array(
            'id'=>$id,
            'kode'=>$kode,
            'nama'=>$nama,
            'no_telp'=>$no_telp,
            'email'=>$email,
            'alamat'=>$alamat,
            'status'=>'1',
            'id_user'=>$id_user,
            'created_at'=>date('Y-m-d H:i:s')
          );
          
          $this->db->insert('m_pelanggan', $data_object);
          // Message
          $this->session->set_flashdata('success', 'Registrasi berhasil, Silahkan cek email Anda untuk verifikasi pendaftaran akun !');

          // Kirim email verifikasi tempatnya di sistem_helper nama function api_register
          $response['success'] = TRUE;
          $response['message_email'] = api_register($id_user, $nama, $email);		    
          $response['message'] = "Registrasi berhasil, Silahkan cek email Anda untuk verifikasi pendaftaran akun !";
        }
      }
      echo json_response($response);
  }

  function logout(){
		$this->session->sess_destroy();
		$data['success'] = TRUE;
		$data['message'] = "Anda Berhasil Logout !";
		$data['page'] = "Auth";
		echo json_response($data);
	}

  /**
   * Function Registrasi
   * 
   */

  public function verifikasi($id_user=NULL){
		if($id_user==NULL){
			$data['success'] == FALSE;
			redirect(site_url());
		}else{
			$data_user = $this->M_main->get_where('users','id',$id_user);
			if($data_user->num_rows()==0){
				$data['success'] == FALSE;
				redirect(site_url());
			}else{
        date_default_timezone_set('Asia/Jakarta');
				$user = $data_user->row_array();
				if($user['status']=='2'){
					$object_update = array(
            'status'=>'1',
            'email_verified_at'=>date('Y-m-d H:i:s'),
					);
					$this->db->where('id',$id_user);
          $this->db->update('users',$object_update);
          
					$data['aplikasi'] = $this->apl;
					$data['title'] = "Berhasil Registrasi Akun | ".$this->apl['nama_sistem'];
					$data['user'] = $user;
					$this->parser->parse('auth/success-verifikasi', $data);
				}else{
					$data['success'] == FALSE;
					redirect(site_url());
				}
			}
		}
  }
}