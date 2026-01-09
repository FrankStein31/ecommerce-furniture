<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
  private $nama_menu  = "Home";     
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Order_m');
    $this->load->model('Pelanggan_m');
    $this->load->model('M_main');
    $this->load->model('Menu_m');
  }

  /**
   * Function Admin
   * 
   */
  public function index (){
    must_login();
    $data['title'] = "Order | ".$this->apl['nama_sistem'];
    $data['content'] = "order/index.php";    
    $this->parser->parse('sistem/template', $data);
  }

  public function detail_pesanan ($id){
    must_login();
    $data['title'] = "Order | ".$this->apl['nama_sistem'];

    $data['order'] = $this->Order_m->get_pesanan_by_id($id)->row_array();
    $data['order_detail'] = $this->Order_m->get_list_pesanan_detail($id)->result();
    $data['order_status'] = $this->Order_m->get_status()->result();
    $data['content'] = "order/detail_order.php";    
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
    $page['count_row'] = $this->Order_m->get_list_count($key)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Order_m->get_list_data($key, $limit, $offset, $column, $sort);

    $this->load->view('sistem/order/list_data',$data);
  }

  /**
   * Start  Function Cart Customer
   * 
   */
  public function cart_list (){
    must_login();
    $data['title'] = "Cart | ".$this->apl['nama_sistem'];
    $id_user = $this->session->userdata('auth_id_user');
    $data['alamat'] = $this->Pelanggan_m->get_pelanggan_alamat($id_user)->result();
    $data['content'] = "order/cart.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function get_list_cart(){
    $id_user = $this->session->userdata('auth_id_user');
    $cart = $this->Order_m->get_list_cart($id_user)->result();
    $data['data'] = $cart;
    $this->load->view('frontend/order/data-cart', $data);
  }

  public function fetch_data_cart(){
    $id_user = $this->session->userdata('auth_id_user');
    $cart = $this->Order_m->get_list_cart($id_user)->result();
    $response['success'] = TRUE;
    $response['data'] = $cart;
    echo json_encode($response);  
  }

  public function add_cart()
  {
    $id_user = $this->session->userdata('auth_id_user');
    $id_produk = $this->input->post('id_produk');
    $qty = $this->input->post('qty');

    $is_login = $this->session->userdata('auth_is_login');
    if($is_login){  
      $cek_produk = $this->Order_m->get_produk_in_cart($id_produk, $id_user);
      if($cek_produk->num_rows()>0){
        $produk = $cek_produk->row_array();
        $qty = $qty + $produk['qty'];
        $object = array(
          'qty' => $qty,
          'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $produk['id']);
        $this->db->update('cart', $object);

        $response['success'] = TRUE;
        $response['message'] = "Produk berhasil diupdate ke dalam keranjang";
      }else{
        $data_object = array(
          'id_user'=>$id_user,
          'id_produk'=>$id_produk,
          'qty'=>$qty,
          'is_checkout'=>'0',
          'created_at'=>date('Y-m-d H:i:s')
        );
        $this->db->insert('cart', $data_object);

        $response['success'] = TRUE;
        $response['message'] = "Produk berhasil ditambahkan ke dalam keranjang";
      }
    }else{
      $response['success'] = FALSE;
      $response['message'] = "Maaf, silahkan login terlebih dahulu";
    }

    echo json_encode($response);   
  }

  public function delete_cart($id){
    if($id){
      $this->db->where('id', $id);
      $this->db->delete('cart');
      
      $response['success'] = true;
      $response['message'] = "Produk berhasil dihapus !";
    }else{
      $response['success'] = false;
      $response['message'] = "Data tidak ditemukan !";
    }
    echo json_encode($response);
  }

  /**
   * Start Order Function
   * 
   */
  public function order_complete (){
    $id_order = $this->input->get('id_order');
    $data['title'] = "Order | ".$this->apl['nama_sistem'];
    $data['order'] = $this->M_main->get_where('orders', 'id', $id_order)->row_array();
    $data['content'] = "order/order-complete.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function order_detail ($id_order){
    $data['title'] = "Order Detail | ".$this->apl['nama_sistem'];
    $id_user = $this->session->userdata('auth_id_user');
    $data['order'] = $this->Order_m->get_pesanan_by_id($id_order)->row_array();
    $data['order_detail'] = $this->Order_m->get_list_pesanan_detail($id_order, $id_user)->result();
    $data['content'] = "order/order-detail.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function modal_upload(){
    $data = [];
    $this->load->view('frontend/order/modal-upload-pembayaran',$data);
  }

  // Function Save / Checkout pesanan
  public function save()
  {
    date_default_timezone_set('Asia/Jakarta');
    $id_user = $this->session->userdata('auth_id_user');
    $keterangan = $this->input->post('keterangan');
    $order_detail = $this->input->post('order_detail');
    $alamat_pengiriman = $this->input->post('alamat_pengiriman');
    $order_detail = json_decode($order_detail);
    
    $pelanggan = $this->M_main->get_where('m_pelanggan', 'id_user', $id_user)->row_array();
    $no_inv = $this->M_main->get_no_otomatis_v3('orders', 'no_invoice', 'INV');
    $id_pelanggan = $pelanggan['id'];

    // Total 
    $total = 0;
    foreach ($order_detail as $row) {  
      $total += ($row->qty*$row->harga);
    }

    $id = $this->uuid->v4(false);    
    $data_object = array(
      'id'=>$id,
      'no_invoice'=>$no_inv,
      'tanggal'=>date('Y-m-d'),
      'id_pelanggan'=>$id_pelanggan,
      'total'=>$total,
      'keterangan'=>$keterangan,  
      'id_alamat' => $alamat_pengiriman,
      'status'=>'1',
      'created_at'=>date('Y-m-d H:i:s'),
      'updated_at'=>date('Y-m-d H:i:s')
    );
    $this->db->insert('orders', $data_object);

    foreach ($order_detail as $row) {  
      $id_detail = $this->uuid->v4(false); 
      $data_detail = array(
        'id'=>$id_detail,
        'id_order'=>$id,
        'id_produk'=>$row->id_produk,
        'qty'=>$row->qty,
        'harga'=>$row->harga,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
        'id_cart'=>$row->id_cart
      );
      $this->db->insert('order_detail', $data_detail);
      
      // Update stok produk
      $produk_item = $this->M_main->get_where('m_produk', 'id', $row->id_produk)->row_array();
      $stok_sisa = $produk_item['stok'] - $row->qty;
      $this->db->where('id', $row->id_produk);
      $this->db->update('m_produk', array(
        'stok' => $stok_sisa,
      ));

      // update status cart bahwa telah dicheckout 
      $this->db->where('id', $row->id_cart);
      $this->db->update('cart', array(
        'qty' => $row->qty,
        'is_checkout' => 1
      ));
    }

    $response['success'] = TRUE;
    $response['message'] = "Pesanan berhasil disimpan !";
    $response['page'] = site_url('Order/order_complete?id_order='.$id);

    echo json_encode($response);   
  }
  
  // Function update status pesanan
  public function update_status()
  {
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    
    date_default_timezone_set('Asia/Jakarta');
    $object = array(
      'status' => $status,
      'updated_at' => date('Y-m-d H:i:s'),
    );
    $this->db->where('id', $id);
    $this->db->update('orders', $object);

    $response['success'] = TRUE;
    $response['message'] = "Status pesanan berhasil diupdate";
    echo json_encode($response);   
  }
  
  /**
   * Function Untuk Upload Bukti Pembayaran
   * Digunakan untuk upload bukti pembayaran oleh pelanggan
   */
  public function upload_bukti_pembayaran(){
    $id = $this->input->post('id_order');
    $foto = do_upload_file('bukti_pembayaran', 'file_upload', 'assets/uploads/bukti_pembayaran/', 'jpg|jpeg|png|pdf');
    $path = $foto['file_name'];
    
    // Simpan ke DB
    date_default_timezone_set('Asia/Jakarta');
    $object = array(
      'bukti_bayar' => $path,
      'tanggal_upload' => date('Y-m-d H:i:s'),
    );
    $this->db->where('id', $id);
    $this->db->update('orders', $object);

    // kirim notif email upload bukti pembayaran ke toko
    $notif_email = $this->email_bukti_pembayaran($id);

    $response['success'] = true;
    $response['message_email'] = $notif_email;
    $response['message'] = "Upload bukti pembayaran berhasil disimpan !";
    echo json_encode($response);
  }

  // Function preview dokumen upload (img, pdf)
  function preview_dokumen(){
    $data['file']= $file = $this->input->post('file');
    $data['judul'] = $this->input->post('judul');
    
    $_files = explode(".", $file);
    $_files2 = explode("/", $file);
    $data['extensi'] = $_files[1];
    $data['file_path'] = base_url().$file;
    $data['file_name'] = $_files2[count($_files2)-1];
    $this->load->view('frontend/order/modal-preview.php',$data);
  }

  // Function download file bukti pembayaran
  function download_file($file){
    $this->load->helper('download');
    force_download('assets/uploads/bukti_pembayaran/'.$file, NULL);
  }

  /**
   * Function Laporan Pengiriman
   * Digunakan untuk menampilkan halaman kurir dan untuk laporan pengiriman
   */

  function laporan_pengiriman(){
    must_login();
    // $this->Menu_m->role_has_access($this->nama_menu);
    $data['title'] = "Laporan Pengiriman | ".$this->apl['nama_sistem'];
    $data['order'] = $this->Order_m->get_data_pesanan_dikirim()->result();
    $data['content'] = "laporan_pengiriman/form.php";    
    $this->parser->parse('sistem/template', $data); 
  }

  // Digunakan untuk proses simpan laporan pengiriman
  public function save_laporan_pengiriman(){
    $id_user = $this->session->userdata('auth_id_user');
    $id_order = $this->input->post('id_order');
    $penerima = strip_tags(trim($this->input->post('penerima')));
    $keterangan = strip_tags(trim($this->input->post('keterangan')));

    // Upload file
    $foto = do_upload_file('laporan_pengiriman', 'foto_bukti', 'assets/uploads/pengiriman/', 'jpg|jpeg|png');
    $path = $foto['file_name'];
    
    date_default_timezone_set('Asia/Jakarta');
    $id = $this->uuid->v4(false);    
    $data_object = array(
        'id'=>$id,
        'id_order'=>$id_order,
        'id_user'=>$id_user,
        'tanggal'=>date('Y-m-d H:i:s'),
        'foto'=>$path,
        'penerima'=>$penerima,
        'keterangan'=>$keterangan,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s')
    );
    $this->db->insert('status_pengiriman', $data_object);
    $response['success'] = TRUE;
    $response['message'] = "Data Berhasil Disimpan";
    
    echo json_encode($response);   
  }

  // Function kirim notif email upload bukti pembayaran
  public function email_bukti_pembayaran($id_order){
    // Data Order
    $data['order'] = $this->Order_m->get_pesanan_by_id($id_order)->row_array();
    $data['order_detail'] = $this->Order_m->get_list_pesanan_detail($id_order)->result();

    // Config email
    $config = [
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_user' => $this->apl['email_smtp'],
        'smtp_pass' => $this->apl['password_email_smtp'],
        'smtp_port' => 465,
        'crlf'      => "\r\n",
        'newline'   => "\r\n"
    ];
    
    // Function untuk kirim email
    $this->load->library('email', $config); 
    // email sender
    $this->email->from($this->apl['email_smtp'], $this->apl['nama_sistem']);
    // email tujuan
    $this->email->to($this->apl['email_instansi']);
    $this->email->subject('Upload Bukti Pembayaran | '.$this->apl['nama_sistem']);
    // Template email
    $body = $this->load->view('email/email-bukti-bayar', $data, TRUE);
    // send email
    $this->email->message($body);
    if ($this->email->send()) {
        $message = 'Sukses! email berhasil dikirim.';
    } else {
        $message =  'Error! email tidak dapat dikirim.';
    }

    return $message;
  }

}

/* End of file Order.php */
