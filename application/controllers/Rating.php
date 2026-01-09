<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rating extends CI_Controller {
  private $nama_menu  = "Rating";     
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Order_m');
    $this->load->model('Rating_m');
    $this->load->model('M_main');
  }

  public function penilaian($id_order){
    must_login();
    $data['title'] = "Rating | ".$this->apl['nama_sistem'];
    $id_user = $this->session->userdata('auth_id_user');
    $data['order'] = $this->Order_m->get_pesanan_by_id($id_order)->row_array();
    $data['order_detail'] = $this->Order_m->get_list_pesanan_detail($id_order, $id_user)->result();
    $data['content'] = "order/rating.php";    
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function save_ulasan()
  {
    date_default_timezone_set('Asia/Jakarta');
    $id_user = $this->session->userdata('auth_id_user');
    $id_order = $this->input->post('id_order');
    $produk = $this->input->post('id_produk_detail');
    $ulasan = $this->input->post('ulasan');
    $rating = $this->input->post('rating');
    
    $countRow = (isset($produk)) ? count($produk) : 0;
    if($countRow>0){        
      for ($i=0; $i < $countRow ; $i++) { 
        $data_object = array(
          'id_user'=>$id_user,
          'id_produk_detail'=>$produk[$i],
          'ulasan'=>$ulasan[$i],
          'rating'=>$rating[$i],
          'anonim'=>'0',
          'created_at'=>date('Y-m-d H:i:s'),
          'updated_at'=>date('Y-m-d H:i:s'),
        );
        $this->db->insert('produk_rating', $data_object);
      }

      // update pesanan
      $this->db->where('id', $id_order);
      $this->db->update('orders', array(
        'status' => '4',
      ));

      $response['success'] = TRUE;
      $response['message'] = "Ulasan berhasil disimpan !";
    }else{
      $response['success'] = FALSE;
      $response['message'] = "Rating tidak boleh kosong !";
    }

    echo json_encode($response);   
  }

  public function fetch_data_ulasan(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $column = $this->input->get("sortby");
    $sort   = $this->input->get("sorttype");
    $id_produk = $this->input->get("id_produk");
    $func_name = $this->input->get("func_name");
    
    $page              = array();
    $page['load_func_name'] = $func_name;
    $page['limit']     = $limit;
    $page['count_row'] = $this->Rating_m->get_list_count($id_produk)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Rating_m->get_list_data($id_produk, $limit, $offset, $column, $sort);

    $this->load->view('frontend/produk/list_ulasan', $data);
  }
  
}

/* End of file Rating.php */
