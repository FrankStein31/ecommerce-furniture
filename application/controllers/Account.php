<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Account extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('M_main');
    $this->load->model('Order_m');
    $this->load->model('Pelanggan_m');
    $this->load->model('Service_order_m');
  }

  public function index()
  {
    must_login();
    $id_user = $this->session->userdata('auth_id_user');
    $pelanggan = $this->M_main->get_where('m_pelanggan', 'id_user', $id_user)->row_array();
    $data_user = $this->M_main->get_where('users', 'id', $id_user)->row_array();

    $data['title'] = "Account | " . $this->apl['nama_sistem'];
    $data['user'] = $data_user;
    $data['order'] = $this->Order_m->get_pesanan_by_pelanggan($id_user)->result();
    $data['content'] = "account/index.php";
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function get_alamat()
  {
    $id_user = $this->session->userdata('auth_id_user');
    $data['alamat'] = $this->Pelanggan_m->get_pelanggan_alamat($id_user);
    $this->load->view('frontend/account/list-alamat', $data);
  }

  public function load_modal_alamat()
  {
    $id = $this->input->post('id');
    if ($id != "") {
      $data['mode'] = "UPDATE";
      $data['data'] = $this->M_main->get_where('pelanggan_alamat', 'id', $id)->row_array();
    } else {
      $data['mode'] = "ADD";
      $data['kosong'] = "";
    }
    $this->load->view('frontend/account/modal-alamat', $data);
  }

  public function save_alamat()
  {
    $id_user = $this->session->userdata('auth_id_user');
    $pelanggan = $this->M_main->get_where('m_pelanggan', 'id_user', $id_user)->row_array();

    $id = $this->input->post('id_alamat');
    $id_pelanggan = $pelanggan['id'];
    $alamat = $this->input->post('alamat');
    $no_telp = $this->input->post('no_telp');
    $kode_pos = $this->input->post('kode_pos');
    $penerima = strip_tags(trim($this->input->post('penerima')));
    $is_utama = ($this->input->post('is_utama') != "") ? $this->input->post('is_utama') : 0;
    $keterangan = strip_tags(trim($this->input->post('keterangan')));

    if ($id != "") {
      $data_object = array(
        'alamat' => $alamat,
        'kode_pos' => $kode_pos,
        'penerima' => $penerima,
        'no_telp' => $no_telp,
        'is_utama' => $is_utama,
        'keterangan' => $keterangan,
        'updated_at' => date('Y-m-d H:i:s')
      );

      $this->db->where('id', $id);
      $this->db->update('pelanggan_alamat', $data_object);

      $response['success'] = true;
      $response['message'] = "Data Berhasil Diubah !";
    } else {
      $uuid_v4 = $this->uuid->v4(false);
      $data_object = array(
        'id' => $uuid_v4,
        'id_pelanggan' => $id_pelanggan,
        'alamat' => $alamat,
        'kode_pos' => $kode_pos,
        'penerima' => $penerima,
        'no_telp' => $no_telp,
        'is_utama' => $is_utama,
        'keterangan' => $keterangan,
        'status' => '1',
        'created_at' => date('Y-m-d H:i:s')
      );
      $this->db->insert('pelanggan_alamat', $data_object);
      $response['success'] = TRUE;
      $response['message'] = "Data Berhasil Disimpan";
    }
    echo json_encode($response);
  }

  public function delete_alamat($id)
  {
    if ($id) {
      $object = array(
        'status' => '0',
      );
      $this->db->where('id', $id);
      $this->db->update('pelanggan_alamat', $object);

      $response['success'] = true;
      $response['message'] = "Data berhasil dihapus !";
    } else {
      $response['success'] = false;
      $response['message'] = "Data tidak ditemukan !";
    }
    echo json_encode($response);
  }

  public function get_service_orders()
  {
    $id_user = $this->session->userdata('auth_id_user');
    $pelanggan = $this->M_main->get_where('service_orders', 'user_id', $id_user)->row_array();

    if (!$pelanggan) {
      $data['service_orders'] = [];
    } else {
      // Get service orders by phone number (since we don't have user_id in service_orders table)
      $phone = $pelanggan['phone_number'];
      $data['service_orders'] = $this->Service_order_m->get_orders_by_user($id_user);
    }

    $this->load->view('frontend/account/service-orders-list', $data);
  }
}
