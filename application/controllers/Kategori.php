<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Kategori extends CI_Controller {
  private $nama_menu  = "Kategori Produk";     
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Menu_m');
    $this->load->model('M_main');
    $this->load->model('Kategori_m');
    must_login();
  }
  //fungsi index digunakan untuk menampilkan halaman view satuan
  public function index()
  {
    $this->Menu_m->role_has_access($this->nama_menu);
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

    $data['content'] = "kategori/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
  //fungsi untuk menamapilkan data ke dalam table
  public function fetch_data(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Kategori_m->get_list_count($key)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Kategori_m->get_list_data($key, $limit, $offset, $column, $sort);
// untuk memanggil halaman view
    $this->load->view('sistem/kategori/list_data',$data);
  }
//load modal fungsi untuk menampilkan form input datanya seperti tambah yg ada di satuan
  public function load_modal(){
    $id = $this->input->post('id');
    if ($id!=""){
        $data['mode'] = "UPDATE";
        $data['data'] = $this->M_main->get_where('m_kategori_produk','id',$id)->row_array();
    }else{
        $data['mode'] = "ADD";
        $data['kosong'] = "";
    }
    $this->load->view('sistem/kategori/form_modal',$data);
  }

  public function save(){
      $id = $this->input->post('id');
      $nama = strip_tags(trim($this->input->post('nama')));
      if($id!=""){
          $data_object = array(
              'nama'=>$nama,
              'updated_at'=>date('Y-m-d H:i:s')
          );
      
          $this->db->where('id',$id);
          $this->db->update('m_kategori_produk', $data_object);

          $response['success'] = true;
          $response['message'] = "Data Berhasil Diubah !";     
      }else{
          $data_object = array(
              'nama'=>$nama,
              'status'=>'1',
              'created_at'=>date('Y-m-d H:i:s')
          );
          $this->db->insert('m_kategori_produk', $data_object);
          $response['success'] = TRUE;
          $response['message'] = "Data Berhasil Disimpan";
      }
      echo json_encode($response);   
  }

  public function delete($id){
    if($id){
      $object = array(
        'status' => '0',
        'deleted_at' => date('Y-m-d H:i:s'),
      );
      $this->db->where('id', $id);
      $this->db->update('m_kategori_produk', $object);
      
      $response['success'] = true;
      $response['message'] = "Data berhasil dihapus !";
    }else{
      $response['success'] = false;
      $response['message'] = "Data tidak ditemukan !";
    }
    echo json_encode($response);
  }
}

/* End of file Kategori.php */
