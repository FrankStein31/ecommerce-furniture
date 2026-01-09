<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Produk extends CI_Controller {
  private $nama_menu  = "Produk";     
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Menu_m');
    $this->load->model('M_main');
    $this->load->model('Produk_m');
    $this->load->model('Order_m');
    $this->load->model('User_m');
    $this->load->model('Jenis_produk_m');
    $this->load->model('Kategori_m');
    $this->load->model('Satuan_m');
  }
  //untuk menampilkan halaman produk
  public function index()
  {
    must_login();
    $this->Menu_m->role_has_access($this->nama_menu);
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

    $data['content'] = "produk/index.php";    
    $this->parser->parse('sistem/template', $data);
  }
    //digunakan untuk menampilkan form create produk
  public function create()
  {
    must_login();
    $this->Menu_m->role_has_access($this->nama_menu);
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

    $data['modeform'] = 'ADD';
    $data['kode'] = $this->M_main->get_no_otomatis_v3('m_produk', 'kode', 'P');
    $data['jenis'] = $this->Jenis_produk_m->get_all()->result();
    $data['kategori'] = $this->Kategori_m->get_all()->result();
    $data['satuan'] = $this->Satuan_m->get_all()->result();

    $data['content'] = "produk/form.php";    
    $this->parser->parse('sistem/template', $data);
  }
    //untuk menamapilkan form edit produk
  public function edit($id)
  {
    must_login();
    $this->Menu_m->role_has_access($this->nama_menu);
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];

    $data['modeform'] = 'UPDATE';
    $data['data'] = $this->M_main->get_where('m_produk', 'id', $id)->row_array();
    $data['kode'] = $this->M_main->get_no_otomatis_v3('m_produk', 'kode', 'P');
    $data['jenis'] = $this->Jenis_produk_m->get_all()->result();
    $data['kategori'] = $this->Kategori_m->get_all()->result();
    $data['satuan'] = $this->Satuan_m->get_all()->result();
    $data['content'] = "produk/form.php";    
    $this->parser->parse('sistem/template', $data);
  }
  //untuk menapilkan tabel data
  public function fetch_data(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");

    $filter = array(
      'id_jenis' => "",
      'id_kategori' => "",
    );
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Produk_m->get_list_count($key, $filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Produk_m->get_list_data($key, $limit, $offset, $column, $sort, $filter);

    $this->load->view('sistem/produk/list_data',$data);
  }
//untuk menampilkan gambar produk
  public function load_image(){
    $id = $this->input->post('id_produk');
    $data['foto_produk'] = $this->M_main->get_where('m_produk_image', 'id_produk', $id);
    $this->load->view('sistem/produk/list_image', $data);
  }
//untuk menyimpan tambah produk dan update produk
  public function save(){
      $id = $this->input->post('id');
      $kode = strip_tags(trim($this->input->post('kode')));
      $nama = strip_tags(trim($this->input->post('nama')));
      $id_jenis = strip_tags(trim($this->input->post('id_jenis')));
      $id_kategori = strip_tags(trim($this->input->post('id_kategori')));
      $id_satuan = strip_tags(trim($this->input->post('id_satuan')));
      $deskripsi = strip_tags(trim($this->input->post('deskripsi')));
      $harga = strip_tags(trim($this->input->post('harga')));
      $stok = strip_tags(trim($this->input->post('stok')));
      
      if($id!=""){
          $data_object = array(
              'nama'=>$nama,
              'deskripsi'=>$deskripsi,
              'id_jenis_produk'=>$id_jenis,
              'id_satuan'=>$id_satuan,
              'id_kategori_produk'=>$id_kategori,
              'harga'=>$harga,
              'stok'=>$stok,
              'updated_at'=>date('Y-m-d H:i:s')
          );
      
          $this->db->where('id',$id);
          $this->db->update('m_produk', $data_object);

          $response['success'] = true;
          $response['message'] = "Data Berhasil Diubah !";     
      }else{
          $id = $this->uuid->v4(false);    
          $data_object = array(
              'id'=>$id,
              'kode'=>$kode,
              'nama'=>$nama,
              'deskripsi'=>$deskripsi,
              'id_jenis_produk'=>$id_jenis,
              'id_satuan'=>$id_satuan,
              'id_kategori_produk'=>$id_kategori,
              'harga'=>$harga,
              'stok'=>$stok,
              'status'=>'1',
              'created_at'=>date('Y-m-d H:i:s')
          );
          $this->db->insert('m_produk', $data_object);
          $response['success'] = TRUE;
          $response['message'] = "Data Berhasil Disimpan";
      }
      echo json_encode($response);   
  }
//untuk mengapus data produk
  public function delete($id){
    if($id){
      $object = array(
        'status' => '0',
        'deleted_at' => date('Y-m-d H:i:s'),
      );
      $this->db->where('id', $id);
      $this->db->update('m_produk', $object);
      
      $response['success'] = true;
      $response['message'] = "Data berhasil dihapus !";
    }else{
      $response['success'] = false;
      $response['message'] = "Data tidak ditemukan !";
    }
    echo json_encode($response);
  }
//untuk menambahkan foto produk
  public function upload_foto(){
      $id_produk = $this->input->post('id_produk');
      $foto = do_upload_file('produk', 'file', 'assets/uploads/produk/', 'jpg|jpeg|png');
      $path = $foto['file_name'];

      $data_obj = array(
          'id_produk'   => $id_produk,
          'foto'        => $path,
          'keterangan'  => null,
          'status'      => '1',
          'created_at'  => date('Y-m-d H:i:s'),
      );
      $this->db->insert('m_produk_image', $data_obj);

      $response['success'] = true;
      $response['message'] = "Foto produk berhasil disimpan !";
      echo json_encode($response);
  }

  public function delete_foto($id){
    if($id){
      $foto_produk = $this->M_main->get_where('m_produk_image', 'id', $id)->row_array();
      $file = $foto_produk['foto'];
      // Delete file
      if (file_exists($file)) {
        unlink($file);
      }
      
      $this->db->where('id', $id);
      $this->db->delete('m_produk_image');
      
      $response['success'] = true;
      $response['message'] = "Foto produk berhasil dihapus !";
    }else{
      $response['success'] = false;
      $response['message'] = "Data tidak ditemukan !";
    }
    echo json_encode($response);
  }

  // Ecommerce 
  //untuk menampilkan data di produk di landing page/halaman utama
  public function fetch_data_produk(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");
    $func_name = $this->input->get("func_name");
    $id_jenis = ($this->input->get("id_jenis")!="") ? $this->input->get("id_jenis") : "";
    $id_kategori = ($this->input->get("id_kategori")!="") ? $this->input->get("id_kategori") : "";
    $show_pagination = ($this->input->get("show_pagination")!="") ? $this->input->get("show_pagination") : true;
    
    $filter = array(
      'id_jenis' => $id_jenis,
      'id_kategori' => $id_kategori,
    );

    $page              = array();
    $page['load_func_name'] = $func_name;
    $page['limit']     = $limit;
    $page['count_row'] = $this->Produk_m->get_list_count($key, $filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Produk_m->get_list_data($key, $limit, $offset, $column, $sort, $filter);
    $data['show_pagination'] = $show_pagination;

    $this->load->view('frontend/produk/list_produk', $data);
  }
//untuk menaampilkan detail produk
  public function detail ($id){
    $data['title'] = "Detail Produk | ".$this->apl['nama_sistem'];
    
    $produk = $this->Produk_m->get_by_id($id)->row_array();
    $data['data'] = $produk;
    $data['produk_serupa'] = $this->Produk_m->get_produk_by_kategori($produk['id_kategori_produk'], $id)->result();
    $data['foto_produk'] = $this->M_main->get_where('m_produk_image', 'id_produk', $id)->result();
    $data['content'] = "produk/detail_produk.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }
//untuk menampilkan hasil pencarian produk
  public function search (){
    $data['title'] = "Cari Produk | ".$this->apl['nama_sistem'];
    $q = $this->input->get("keyword");
    $data['keyword'] = $q; 
    $data['jenis'] = $this->Jenis_produk_m->get_all()->result();
    $data['kategori'] = $this->Kategori_m->get_all()->result();
    $data['content'] = "produk/pencarian.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }
  //untuk menampilkan hasil rekomendasi produk untuk user yang sudah login
  public function rekomendasi (){
    $data['title'] = "Rekomendasi Produk | ".$this->apl['nama_sistem'];

    $username = $this->session->userdata('auth_username');
    $is_login = $this->session->userdata('auth_is_login');
    $produk = $this->Order_m->get_rating_produk()->result_array();
    $user = $this->User_m->get_all()->result_array();
    //untuk mengelompokkan data rating dari masing-masing user
    $matrix=array();
    foreach ($produk as $row) {
      $matrix[$row['username']][$row['kode']]=$row['rating'];  
    }

    foreach ($user as $u) {
      if(isset($matrix[$u['username']])){
        // No Action
      }else{
        $matrix[$u['username']] = array();
      }
    }
      //memanggil fungsi sistem rekomendasi lalu memasukkan matrix dan username dari user yang login untuk mendapatkan hasil rekomendasi produk
    $result = array();
    if($is_login){
      $this->load->library('SistemRekomendasi');
      $rec = new $this->sistemrekomendasi;
      $result = $rec->getRecommendation($matrix, $username);
    }
 
    // print_r($rec->getRecommendation($matrix, $username));
      //hasil yang akan ditampilka di view dihalaman rekomendasi produk
    $produk_result = array();
    foreach ($result as $key => $value) {
      $get_produk = $this->Produk_m->get_produk_by_kode($key); 
      if($get_produk->num_rows()>0){
        $pp = $get_produk->row_array();
        $produk_result[]=$pp;
      }
    }

    $data['rekomendasi'] = $produk_result;
    $data['content'] = "produk/rekomendasi.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }
}

/* End of file Produk.php */
