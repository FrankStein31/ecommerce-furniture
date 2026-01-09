<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends CI_Controller {

  private $nama_menu  = "Laporan";     

  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('M_main');
    $this->load->model('Laporan_m');
    must_login();
  }
  
  public function penjualan()
  {
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];
    $data['content'] = "laporan/laporan_penjualan.php";
    $this->parser->parse('sistem/template', $data);
  }
  
  public function produk_terjual()
  {
    $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];
    $data['content'] = "laporan/laporan_produk_terjual.php";
    $this->parser->parse('sistem/template', $data);
  }

  public function fetch_laporan_penjualan(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $sortby = $this->input->get("sortby");
    $sorttype = $this->input->get("sorttype");
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");

    $filter = array(
      'with_pagination' => true,
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'sortby' => $sortby,
      'sorttype' => $sorttype,
      'offset' => $offset,
      'limit' => $limit,
      'q' => $key,
    );
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Laporan_m->get_count_laporan_penjualan($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Laporan_m->get_laporan_penjualan($filter);

    $this->load->view('sistem/laporan/data_penjualan',$data);
  }

  public function fetch_laporan_produk_terjual(){
    $pg     = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
    $key	  = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
    $limit	= $this->input->get("limit");
    $offset = ($limit*$pg)-$limit;
    $sortby = $this->input->get("sortby");
    $sorttype = $this->input->get("sorttype");
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");

    $filter = array(
      'with_pagination' => true,
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'sortby' => $sortby,
      'sorttype' => $sorttype,
      'offset' => $offset,
      'limit' => $limit,
      'q' => $key,
    );
    
    $page              = array();
    $page['limit']     = $limit;
    $page['count_row'] = $this->Laporan_m->get_count_laporan_produk_terjual($filter)['jml'];
    $page['current']   = $pg;
    $page['list']      = gen_paging($page);
    $data['paging']    = $page;
    $data['list']      = $this->Laporan_m->get_laporan_produk_terjual($filter);

    $this->load->view('sistem/laporan/data_produk_terjual',$data);
  }

  public function cetak_laporan_penjualan() {
    $data['title'] = "Laporan Penjualan"; 
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");
    
    $filter = array(
      'with_pagination' => false,
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'sortby' => 'nama',
      'sorttype' => 'asc',
      'offset' => 1,
      'limit' => 1000,
      'q' => "",
    );

    $data['report'] = $this->Laporan_m->get_laporan_penjualan($filter)->result();
    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;
    $data['aplikasi'] = $this->apl;

    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Penjualan.pdf";
    $this->pdf->load_view('sistem/laporan/cetak_laporan_penjualan.php', $data);
  }

  public function cetak_laporan_produk_terjual() {
    $data['title'] = "Laporan Produk Terjual"; 
    $tanggal_awal = $this->input->get("tanggal_awal");
    $tanggal_akhir = $this->input->get("tanggal_akhir");
    
    $filter = array(
      'with_pagination' => false,
      'tanggal_awal' => format_date($tanggal_awal, 'Y-m-d'),
      'tanggal_akhir' => format_date($tanggal_akhir, 'Y-m-d'),
      'sortby' => 'tanggal',
      'sorttype' => 'desc',
      'offset' => 1,
      'limit' => 1000,
      'q' => "",
    );

    $data['report'] = $this->Laporan_m->get_laporan_produk_terjual($filter)->result();
    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;
    $data['aplikasi'] = $this->apl;

    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Produk Terjual.pdf";
    $this->pdf->load_view('sistem/laporan/cetak_laporan_produk_terjual.php', $data);
  }

}

/* End of file Laporan.php */