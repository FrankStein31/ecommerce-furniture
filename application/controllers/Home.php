<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
  private $nama_menu  = "Home";
  public function __construct()
  {
    parent::__construct();
    $this->apl = get_apl();
    $this->load->model('Menu_m');
    $this->load->model('Damage_report_m');
    $this->load->library('form_validation');
    $this->load->library('upload');
    $this->load->library('email');
    // must_login();
  }

  public function index()
  {
    $data['title'] = "Home | " . $this->apl['nama_sistem'];

    $data['content'] = "home/index.php";
    $this->parser->parse('frontend/template', $data);
  }

  public function detail()
  {
    $data['title'] = "Detail Produk | " . $this->apl['nama_sistem'];
    $data['content'] = "produk/detail_produk.php";
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function about()
  {
    $data['title'] = "About | " . $this->apl['nama_sistem'];
    $data['content'] = "home/about.php";
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function contact()
  {
    $data['title'] = "Contact | " . $this->apl['nama_sistem'];
    $data['content'] = "home/contact.php";
    $this->parser->parse('frontend/template_produk', $data);
  }

  public function submit_damage_report()
  {
    $this->load->helper('file');

    // Validasi input
    $this->form_validation->set_rules('customer_name', 'Nama Pelanggan', 'required|trim');
    $this->form_validation->set_rules('phone_number', 'Nomor Telepon', 'required|trim');
    $this->form_validation->set_rules('product_name', 'Nama Produk', 'required|trim');
    $this->form_validation->set_rules('damage_type', 'Jenis Kerusakan', 'required');
    $this->form_validation->set_rules('damage_description', 'Deskripsi Kerusakan', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
      $response = array(
        'status' => 'error',
        'message' => validation_errors()
      );
      echo json_encode($response);
      return;
    }

    // Persiapkan data
    $data = array(
      'customer_name' => $this->input->post('customer_name'),
      'phone_number' => $this->input->post('phone_number'),
      'product_name' => $this->input->post('product_name'),
      'damage_type' => $this->input->post('damage_type'),
      'damage_description' => $this->input->post('damage_description'),
      'purchase_date' => $this->input->post('purchase_date'),
      'warranty_claim' => $this->input->post('warranty_claim') ? 1 : 0,
      'report_date' => date('Y-m-d H:i:s'),
      'status' => 'pending'
    );

    // Upload foto kerusakan jika ada
    $uploaded_files = array();
    if (!empty($_FILES['damage_photos']['name'][0])) {
      $config['upload_path'] = './assets/uploads/damage_reports/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 2048; // 2MB
      $config['encrypt_name'] = TRUE;

      // Buat direktori jika belum ada
      if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0755, true);
      }

      $this->load->library('upload', $config);

      $files = $_FILES['damage_photos'];
      for ($i = 0; $i < count($files['name']) && $i < 5; $i++) {
        if (!empty($files['name'][$i])) {
          $_FILES['photo']['name'] = $files['name'][$i];
          $_FILES['photo']['type'] = $files['type'][$i];
          $_FILES['photo']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['photo']['error'] = $files['error'][$i];
          $_FILES['photo']['size'] = $files['size'][$i];

          if ($this->upload->do_upload('photo')) {
            $upload_data = $this->upload->data();
            $uploaded_files[] = $upload_data['file_name'];
          }
        }
      }
    }

    $data['damage_photos'] = !empty($uploaded_files) ? json_encode($uploaded_files) : null;

    try {
      $insert_id = $this->Damage_report_m->save_report($data);

      if ($insert_id) {
        // Kirim email notifikasi
        // $this->send_damage_report_email($data);

        $response = array(
          'status' => 'success',
          'message' => 'Laporan kerusakan berhasil dikirim. Tim kami akan menghubungi Anda dalam 1x24 jam.',
          'report_id' => $insert_id
        );
      } else {
        $response = array(
          'status' => 'error',
          'message' => 'Gagal menyimpan laporan kerusakan. Silakan coba lagi.'
        );
      }
    } catch (Exception $e) {
      // Fallback: simpan ke file log jika database error
      $log_data = "=== LAPORAN KERUSAKAN BARU ===\n";
      $log_data .= "Tanggal: " . date('Y-m-d H:i:s') . "\n";
      $log_data .= "Nama: " . $data['customer_name'] . "\n";
      $log_data .= "Telepon: " . $data['phone_number'] . "\n";
      $log_data .= "Produk: " . $data['product_name'] . "\n";
      $log_data .= "Jenis Kerusakan: " . $data['damage_type'] . "\n";
      $log_data .= "Deskripsi: " . $data['damage_description'] . "\n";
      $log_data .= "Tanggal Beli: " . ($data['purchase_date'] ?: 'Tidak diisi') . "\n";
      $log_data .= "Klaim Garansi: " . ($data['warranty_claim'] ? 'Ya' : 'Tidak') . "\n";
      $log_data .= "Foto: " . ($data['damage_photos'] ? implode(', ', $uploaded_files) : 'Tidak ada') . "\n";
      $log_data .= "Error: " . $e->getMessage() . "\n";
      $log_data .= "=============================\n\n";

      $log_file = APPPATH . 'logs/damage_reports_' . date('Y-m') . '.log';
      file_put_contents($log_file, $log_data, FILE_APPEND | LOCK_EX);

      $response = array(
        'status' => 'success',
        'message' => 'Laporan kerusakan berhasil dikirim. Tim kami akan menghubungi Anda dalam 1x24 jam.'
      );
    }

    echo json_encode($response);
  }

  private function send_damage_report_email($data)
  {
    $this->load->library('email');

    $config['mailtype'] = 'html';
    $this->email->initialize($config);

    $this->email->from('noreply@furniture-store.com', 'Furniture Store');
    $this->email->to('admin@furniture-store.com');
    $this->email->subject('Laporan Kerusakan Furniture Baru');

    $message = "
    <h3>Laporan Kerusakan Furniture Baru</h3>
    <table style='border-collapse: collapse; width: 100%;'>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Nama Pelanggan:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['customer_name']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Telepon:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['phone_number']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Produk:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['product_name']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Jenis Kerusakan:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['damage_type']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Deskripsi:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['damage_description']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Tanggal Beli:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . ($data['purchase_date'] ?: 'Tidak diisi') . "</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Klaim Garansi:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . ($data['warranty_claim'] ? 'Ya' : 'Tidak') . "</td></tr>
    </table>
    <p><strong>Tanggal Laporan:</strong> {$data['report_date']}</p>
    ";

    $this->email->message($message);
    $this->email->send();
  }

  public function submit_service_order()
  {
    $this->load->helper('file');

    // Validasi input
    $this->form_validation->set_rules('customer_name', 'Nama Pelanggan', 'required|trim');
    $this->form_validation->set_rules('phone_number', 'Nomor Telepon', 'required|trim');
    $this->form_validation->set_rules('address', 'Alamat', 'required|trim');
    $this->form_validation->set_rules('selected_service', 'Jenis Layanan', 'required');
    $this->form_validation->set_rules('selected_method', 'Metode Layanan', 'required');
    $this->form_validation->set_rules('damage_description', 'Deskripsi Kebutuhan', 'required|trim');
    $this->form_validation->set_rules('service_date', 'Tanggal Layanan', 'required');
    $this->form_validation->set_rules('service_time', 'Waktu Layanan', 'required');

    if ($this->form_validation->run() == FALSE) {
      $response = array(
        'status' => 'error',
        'message' => validation_errors()
      );
      echo json_encode($response);
      return;
    }

    // Generate order ID
    $order_id = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

    // Persiapkan data order
    $data = array(
      'order_id' => $order_id,
      'user_id' => $this->session->userdata('auth_id_user') ?: null,
      'customer_name' => $this->input->post('customer_name'),
      'phone_number' => $this->input->post('phone_number'),
      'address' => $this->input->post('address'),
      'service_type' => $this->input->post('selected_service'),
      'service_method' => $this->input->post('selected_method'),
      'damage_description' => $this->input->post('damage_description'),
      'material_type' => $this->input->post('material_type'),
      'foam_modification' => $this->input->post('foam_modification'),
      'shape_modification' => $this->input->post('shape_modification'),
      'service_date' => $this->input->post('service_date'),
      'service_time' => $this->input->post('service_time'),
      'special_notes' => $this->input->post('special_notes'),
      'estimated_cost' => $this->input->post('estimated_cost'),
      'vehicle_brand' => $this->input->post('vehicle_brand'),
      'chair_type' => $this->input->post('chair_type'),
      'bed_size' => $this->input->post('bed_size'),
      'order_date' => date('Y-m-d H:i:s'),
      'status' => 'pesanan_diterima'
    );

    // Upload foto jika ada
    $uploaded_files = array();
    if (!empty($_FILES['damage_photos']['name'][0])) {
      $config['upload_path'] = './assets/uploads/service_orders/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 2048; // 2MB
      $config['encrypt_name'] = TRUE;

      // Buat direktori jika belum ada
      if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0755, true);
      }

      $this->load->library('upload', $config);

      $files = $_FILES['damage_photos'];
      for ($i = 0; $i < count($files['name']) && $i < 5; $i++) {
        if (!empty($files['name'][$i])) {
          $_FILES['photo']['name'] = $files['name'][$i];
          $_FILES['photo']['type'] = $files['type'][$i];
          $_FILES['photo']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['photo']['error'] = $files['error'][$i];
          $_FILES['photo']['size'] = $files['size'][$i];

          if ($this->upload->do_upload('photo')) {
            $upload_data = $this->upload->data();
            $uploaded_files[] = $upload_data['file_name'];
          }
        }
      }
    }

    $data['order_photos'] = !empty($uploaded_files) ? json_encode($uploaded_files) : null;

    // Simpan ke database
    try {
      $this->load->model('Service_order_m');
      $insert_id = $this->Service_order_m->save_order($data);

      if ($insert_id) {
        // Kirim email notifikasi
        $this->send_service_order_email($data);

        $response = array(
          'status' => 'success',
          'message' => 'Pesanan layanan berhasil dikirim. Tim kami akan menghubungi Anda dalam 1x24 jam.',
          'order_id' => $order_id
        );
      } else {
        $response = array(
          'status' => 'error',
          'message' => 'Gagal menyimpan pesanan layanan. Silakan coba lagi.'
        );
      }
    } catch (Exception $e) {
      // Fallback: simpan ke file log jika database error
      $log_data = "=== PESANAN LAYANAN BARU ===\n";
      $log_data .= "Order ID: " . $order_id . "\n";
      $log_data .= "Tanggal: " . date('Y-m-d H:i:s') . "\n";
      $log_data .= "Nama: " . $data['customer_name'] . "\n";
      $log_data .= "Telepon: " . $data['phone_number'] . "\n";
      $log_data .= "Alamat: " . $data['address'] . "\n";
      $log_data .= "Jenis Layanan: " . $data['service_type'] . "\n";
      $log_data .= "Metode Layanan: " . $data['service_method'] . "\n";
      $log_data .= "Tanggal Layanan: " . $data['service_date'] . " " . $data['service_time'] . "\n";
      $log_data .= "Estimasi Biaya: " . $data['estimated_cost'] . "\n";
      $log_data .= "Error: " . $e->getMessage() . "\n";
      $log_data .= "===============================\n\n";

      $log_file = APPPATH . 'logs/service_orders_' . date('Y-m') . '.log';
      file_put_contents($log_file, $log_data, FILE_APPEND | LOCK_EX);

      $response = array(
        'status' => 'success',
        'message' => 'Pesanan layanan berhasil dikirim. Tim kami akan menghubungi Anda dalam 1x24 jam.',
        'order_id' => $order_id
      );
    }

    echo json_encode($response);
  }

  private function send_service_order_email($data)
  {
    $this->load->library('email');

    $config['mailtype'] = 'html';
    $this->email->initialize($config);

    $this->email->from('noreply@furniture-store.com', 'Mebel Anggita Jaya');
    $this->email->to('admin@furniture-store.com');
    $this->email->subject('Pesanan Layanan Baru - ' . $data['order_id']);

    $service_names = array(
      'jok-motor' => 'Perbaikan Jok Motor',
      'jok-mobil' => 'Perbaikan Jok Mobil',
      'kursi-rumah' => 'Perbaikan Kursi Rumah Tangga',
      'spring-bed' => 'Perbaikan/Pemesanan Spring Bed'
    );

    $method_names = array(
      'antar-lokasi' => 'Antar ke Lokasi Workshop',
      'antar-jemput' => 'Layanan Antar & Jemput'
    );

    $message = "
    <h3>Pesanan Layanan Baru</h3>
    <table style='border-collapse: collapse; width: 100%;'>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Order ID:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['order_id']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Nama Pelanggan:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['customer_name']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Telepon:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['phone_number']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Alamat:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['address']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Jenis Layanan:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . $service_names[$data['service_type']] . "</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Metode Layanan:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . $method_names[$data['service_method']] . "</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Tanggal Layanan:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['service_date']} {$data['service_time']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Estimasi Biaya:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['estimated_cost']}</td></tr>
      <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Deskripsi:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$data['damage_description']}</td></tr>
    </table>
    <p><strong>Tanggal Pesanan:</strong> {$data['order_date']}</p>
    ";

    $this->email->message($message);
    $this->email->send();
  }

  public function order_tracking($order_id = null)
  {
    if (!$order_id) {
      redirect('Home');
    }

    $data['title'] = "Lacak Pesanan | " . $this->apl['nama_sistem'];
    $data['order_id'] = $order_id;
    $data['content'] = "tracking/order_tracking.php";
    $this->parser->parse('frontend/template', $data);
  }

  public function service()
  {
    $data['title'] = "Layanan Perbaikan | " . $this->apl['nama_sistem'];
    $data['content'] = "frontend/service/index.php";
    $this->parser->parse('frontend/template', $data);
  }

  public function api_track_order()
  {
    $order_id = $this->input->post('order_id') ?: $this->input->get('order_id');

    if (!$order_id) {
      $response = array(
        'status' => 'error',
        'message' => 'Order ID diperlukan'
      );
      echo json_encode($response);
      return;
    }

    try {
      $this->load->model('Service_order_m');
      $order = $this->Service_order_m->get_order($order_id);

      if ($order) {
        $response = array(
          'status' => 'success',
          'data' => $order
        );
      } else {
        $response = array(
          'status' => 'error',
          'message' => 'Pesanan tidak ditemukan'
        );
      }
    } catch (Exception $e) {
      $response = array(
        'status' => 'error',
        'message' => 'Terjadi kesalahan sistem'
      );
    }

    echo json_encode($response);
  }

  public function rekomendasi()
  {
    // Load models
    $this->load->model('Kategori_perbaikan_m');
    $this->load->model('Jenis_perbaikan_m');
    $this->load->model('Gejala_kerusakan_m');
    $this->load->model('Jenis_kerusakan_m');
    $this->load->model('Rekomendasi_perbaikan_m');
    
    // Reset session jika ada parameter reset
    if ($this->input->get('reset')) {
      $this->session->unset_userdata('diagnosis_data');
      redirect('home/rekomendasi?step=1');
      return;
    }
    
    // Cek step dari session atau default step 1
    $diagnosis_data = $this->session->userdata('diagnosis_data');
    $step = $this->input->get('step') ?: 1;
    
    // Handle POST dari setiap step
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $new_step = $this->process_step_data($step, $diagnosis_data);
      // Redirect ke step baru setelah proses data
      redirect('home/rekomendasi?step=' . $new_step);
      return;
    }
    
    // Load view berdasarkan step
    switch ($step) {
      case 2:
        // Reload diagnosis_data dari session setelah redirect
        $diagnosis_data = $this->session->userdata('diagnosis_data');
        $this->step2_jenis_perbaikan($diagnosis_data);
        break;
      case 3:
        $diagnosis_data = $this->session->userdata('diagnosis_data');
        $this->step3_gejala($diagnosis_data);
        break;
      case 4:
        $diagnosis_data = $this->session->userdata('diagnosis_data');
        $this->step4_kerusakan($diagnosis_data);
        break;
      case 5:
        $diagnosis_data = $this->session->userdata('diagnosis_data');
        $this->step5_hasil($diagnosis_data);
        break;
      default:
        $this->step1_kategori();
        break;
    }
  }
  
  private function step1_kategori()
  {
    // Search functionality
    $search = $this->input->get('search_kategori');
    
    $this->db->select('id, nama_kategori');
    $this->db->from('kategori_jenis_perbaikan');
    $this->db->where('status', '1');
    
    if ($search) {
      $this->db->like('nama_kategori', $search);
      $this->db->or_like('deskripsi', $search);
    }
    
    $this->db->order_by('urutan', 'ASC');
    $kategori_query = $this->db->get();
    
    $kategori_list = array();
    foreach ($kategori_query->result() as $row) {
      $kategori_list[$row->id] = $row->nama_kategori;
    }
    
    $data['title'] = "Diagnosis Kerusakan Furniture | " . $this->apl['nama_sistem'];
    $data['current_step'] = 1;
    $data['kategori_list'] = $kategori_list;
    $data['search_kategori'] = $search;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }
  
  private function step2_jenis_perbaikan($diagnosis_data)
  {
    $id_kategori = $diagnosis_data['id_kategori'] ?? null;
    if (!$id_kategori) {
      redirect('home/rekomendasi?step=1');
    }
    
    // Search functionality
    $search = $this->input->get('search_jenis');
    
    // Pagination
    $page = $this->input->get('page') ?: 1;
    $per_page = 6; // 6 items per page (3 rows x 2 columns)
    $offset = ($page - 1) * $per_page;
    
    // Get kategori detail
    $kategori = $this->db->get_where('kategori_jenis_perbaikan', array('id' => $id_kategori, 'status' => '1'))->row();
    
    // Count total
    $this->db->from('jenis_perbaikan');
    $this->db->where('id_kategori', $id_kategori);
    $this->db->where('status', '1');
    if ($search) {
      $this->db->group_start();
      $this->db->like('nama_jenis_perbaikan', $search);
      $this->db->or_like('deskripsi', $search);
      $this->db->group_end();
    }
    $total_rows = $this->db->count_all_results();
    $total_pages = ceil($total_rows / $per_page);
    
    // Get jenis perbaikan berdasarkan kategori dengan pagination
    $this->db->select('*');
    $this->db->from('jenis_perbaikan');
    $this->db->where('id_kategori', $id_kategori);
    $this->db->where('status', '1');
    if ($search) {
      $this->db->group_start();
      $this->db->like('nama_jenis_perbaikan', $search);
      $this->db->or_like('deskripsi', $search);
      $this->db->group_end();
    }
    $this->db->order_by('nama_jenis_perbaikan', 'ASC');
    $this->db->limit($per_page, $offset);
    $jenis_perbaikan_list = $this->db->get()->result();
    
    $data['title'] = "Pilih Jenis Perbaikan | " . $this->apl['nama_sistem'];
    $data['current_step'] = 2;
    $data['kategori_selected'] = $kategori;
    $data['jenis_perbaikan_list'] = $jenis_perbaikan_list;
    $data['search_jenis'] = $search;
    $data['current_page'] = $page;
    $data['total_pages'] = $total_pages;
    $data['total_rows'] = $total_rows;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }  private function step3_gejala($diagnosis_data)
  {
    $id_jenis_perbaikan = $diagnosis_data['id_jenis_perbaikan'] ?? null;
    if (!$id_jenis_perbaikan) {
      redirect('home/rekomendasi?step=2');
    }
    
    // Coba kedua nama tabel yang mungkin ada
    $gejala_list = $this->db->query("
      SELECT DISTINCT gk.* 
      FROM gejala_kerusakan gk
      INNER JOIN gejala_jenis_perbaikan gjp ON gk.id = gjp.id_gejala
      WHERE gjp.id_jenis_perbaikan = ? AND gk.status = '1'
      ORDER BY gk.kode_gejala ASC
    ", array($id_jenis_perbaikan))->result();
    
    // Jika kosong, coba tabel relasi
    if (empty($gejala_list)) {
      $gejala_list = $this->db->query("
        SELECT DISTINCT gk.* 
        FROM gejala_kerusakan gk
        INNER JOIN relasi_gejala_jenis_perbaikan rgjp ON gk.id = rgjp.id_gejala_kerusakan
        WHERE rgjp.id_jenis_perbaikan = ? AND gk.status = '1'
        ORDER BY gk.kode_gejala ASC
      ", array($id_jenis_perbaikan))->result();
    }
    
    $data['title'] = "Pertanyaan Gejala | " . $this->apl['nama_sistem'];
    $data['current_step'] = 3;
    $data['gejala_list'] = $gejala_list;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }
  
  private function step4_kerusakan($diagnosis_data)
  {
    $jawaban_gejala = $diagnosis_data['jawaban_gejala'] ?? array();
    if (empty($jawaban_gejala)) {
      redirect('home/rekomendasi?step=3');
    }
    
    // Get jenis kerusakan yang relevan
    $gejala_ya = array();
    foreach ($jawaban_gejala as $id_gejala => $jawab) {
      if ($jawab['jawaban'] == 'ya') {
        $gejala_ya[] = $id_gejala;
      }
    }
    
    $kerusakan_list = array();
    if (!empty($gejala_ya)) {
      $gejala_ids = implode(',', $gejala_ya);
      $kerusakan_list = $this->db->query("
        SELECT DISTINCT jk.* 
        FROM jenis_kerusakan jk
        INNER JOIN relasi_jenis_kerusakan_gejala rjkg ON jk.id = rjkg.id_jenis_kerusakan
        WHERE rjkg.id_gejala_kerusakan IN ($gejala_ids) AND jk.status = '1'
        ORDER BY jk.kode_kerusakan ASC
      ")->result();
    }
    
    $data['title'] = "Pertanyaan Kerusakan | " . $this->apl['nama_sistem'];
    $data['current_step'] = 4;
    $data['kerusakan_list'] = $kerusakan_list;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }
  
  private function step5_hasil($diagnosis_data)
  {
    $jawaban_kerusakan = $diagnosis_data['jawaban_kerusakan'] ?? array();
    if (empty($jawaban_kerusakan)) {
      redirect('home/rekomendasi?step=4');
    }
    
    // Hitung CF untuk rekomendasi
    $hasil_cf = $this->hitung_certainty_factor($diagnosis_data);
    
    $data['title'] = "Hasil Diagnosis | " . $this->apl['nama_sistem'];
    $data['current_step'] = 5;
    $data['diagnosis_data'] = $diagnosis_data;
    $data['hasil_cf'] = $hasil_cf;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }
  
  private function process_step_data($step, $diagnosis_data)
  {
    if (!is_array($diagnosis_data)) {
      $diagnosis_data = array();
    }
    
    switch ($step) {
      case 1:
        $diagnosis_data['id_kategori'] = $this->input->post('id_kategori');
        $this->session->set_userdata('diagnosis_data', $diagnosis_data);
        return 2;
        
      case 2:
        $diagnosis_data['id_jenis_perbaikan'] = $this->input->post('id_jenis_perbaikan');
        $this->session->set_userdata('diagnosis_data', $diagnosis_data);
        return 3;
        
      case 3:
        $diagnosis_data['jawaban_gejala'] = $this->input->post('gejala');
        $this->session->set_userdata('diagnosis_data', $diagnosis_data);
        return 4;
        
      case 4:
        $diagnosis_data['jawaban_kerusakan'] = $this->input->post('kerusakan');
        $this->session->set_userdata('diagnosis_data', $diagnosis_data);
        return 5;
    }
    
    return $step;
  }
  
  private function hitung_certainty_factor($diagnosis_data)
  {
    $jawaban_gejala = $diagnosis_data['jawaban_gejala'] ?? array();
    $jawaban_kerusakan = $diagnosis_data['jawaban_kerusakan'] ?? array();
    
    // Get semua rekomendasi aktif dengan kerusakan terkait
    $rekomendasi_list = $this->db->query("
      SELECT rp.*, GROUP_CONCAT(DISTINCT rrjk.id_jenis_kerusakan) as kerusakan_ids
      FROM rekomendasi_perbaikan rp
      LEFT JOIN relasi_rekomendasi_jenis_kerusakan rrjk ON rp.id = rrjk.id_rekomendasi_perbaikan
      WHERE rp.status = '1'
      GROUP BY rp.id
      ORDER BY rp.cf_value DESC
    ")->result();
    
    $hasil = array();
    
    foreach ($rekomendasi_list as $rekomendasi) {
      // CF dari expert (MB - MD dari database)
      $cf_expert = floatval($rekomendasi->cf_value);
      
      // CF gabungan dari gejala
      $cf_gejala = 0;
      $count_gejala_ya = 0;
      foreach ($jawaban_gejala as $id_gejala => $jawab) {
        if ($jawab['jawaban'] == 'ya') {
          $cf_user = floatval($jawab['cf_value']);
          if ($count_gejala_ya == 0) {
            $cf_gejala = $cf_user;
          } else {
            // Kombinasi CF: CF(combined) = CF1 + CF2 * (1 - CF1)
            $cf_gejala = $cf_gejala + ($cf_user * (1 - $cf_gejala));
          }
          $count_gejala_ya++;
        }
      }
      
      // CF gabungan dari kerusakan
      $cf_kerusakan = 0;
      $count_kerusakan_ya = 0;
      $kerusakan_match = false;
      
      $kerusakan_ids_array = explode(',', $rekomendasi->kerusakan_ids);
      
      foreach ($jawaban_kerusakan as $id_kerusakan => $jawab) {
        if ($jawab['jawaban'] == 'ya') {
          $cf_user = floatval($jawab['cf_value']);
          
          // Cek apakah kerusakan ini match dengan rekomendasi
          if (in_array($id_kerusakan, $kerusakan_ids_array)) {
            $kerusakan_match = true;
          }
          
          if ($count_kerusakan_ya == 0) {
            $cf_kerusakan = $cf_user;
          } else {
            $cf_kerusakan = $cf_kerusakan + ($cf_user * (1 - $cf_kerusakan));
          }
          $count_kerusakan_ya++;
        }
      }
      
      // Hitung CF total dengan rumus Certainty Factor
      // CF(H,E) = CF(H) * max(CF(E1), CF(E2), ...) untuk sequential
      // atau CF(H,E) = CF(H) * CF(E) untuk parallel evidence
      
      $cf_evidence = max($cf_gejala, $cf_kerusakan);
      
      if ($cf_evidence > 0) {
        // CF final = CF expert * CF evidence
        $cf_total = $cf_expert * $cf_evidence;
        
        // Bonus jika kerusakan match
        if ($kerusakan_match) {
          $cf_total = $cf_total + (0.1 * (1 - $cf_total));
        }
      } else {
        $cf_total = 0;
      }
      
      // Hanya tampilkan yang memiliki CF > 0.1 (10%)
      if ($cf_total > 0.1) {
        $hasil[] = array(
          'rekomendasi' => $rekomendasi,
          'cf_score' => $cf_total,
          'confidence' => $cf_total * 100,
          'cf_gejala' => $cf_gejala,
          'cf_kerusakan' => $cf_kerusakan
        );
      }
    }
    
    // Sort by CF score descending
    usort($hasil, function($a, $b) {
      return $b['cf_score'] <=> $a['cf_score'];
    });
    
    return array_slice($hasil, 0, 5);
  }

  public function get_jenis_perbaikan()
  {
    // Fetch data from external API
    $url = 'http://localhost:8000/jenis-perbaikan';
    $options = array(
      'http' => array(
        'header'  => "Accept: application/json\r\n",
        'method'  => 'GET',
        'ignore_errors' => true
      )
    );

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
      $response = array(
        'status' => 'error',
        'message' => 'Gagal mengambil data dari server',
        'data' => []
      );
    } else {
      $data = json_decode($result, true);
      $response = array(
        'status' => 'success',
        'total' => isset($data['total']) ? $data['total'] : count($data['data']),
        'data' => isset($data['data']) ? $data['data'] : []
      );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  public function get_rekomendasi()
  {
    // Validasi input
    $gejala_kerusakan = $this->input->post('gejala_kerusakan');
    $jenis_kerusakan = $this->input->post('jenis_kerusakan');
    $jenis_perbaikan = $this->input->post('jenis_perbaikan');

    if (!$gejala_kerusakan || !$jenis_kerusakan || !$jenis_perbaikan) {
      $response = array(
        'status' => 'error',
        'message' => 'Semua field harus diisi'
      );
      echo json_encode($response);
      return;
    }

    // Siapkan data untuk API
    $api_data = array(
      'gejala_kerusakan' => $gejala_kerusakan,
      'jenis_kerusakan' => $jenis_kerusakan,
      'jenis_perbaikan' => $jenis_perbaikan
    );

    // Call API menggunakan file_get_contents
    $url = 'http://localhost:8000/rekomendasi';
    $options = array(
      'http' => array(
        'header'  => "Content-type: application/json\r\nAccept: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($api_data),
        'ignore_errors' => true
      )
    );
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    // Check if request was successful
    if ($result === FALSE) {
      $response = array(
        'status' => 'error',
        'message' => 'Gagal menghubungi API. Pastikan API server berjalan di http://localhost:8000'
      );
      echo json_encode($response);
      return;
    }

    // Parse response
    $api_response = json_decode($result, true);
    
    if ($api_response) {
      $response = array(
        'status' => 'success',
        'data' => $api_response
      );
    } else {
      $response = array(
        'status' => 'error',
        'message' => 'Gagal memproses response dari API',
        'details' => $result
      );
    }

    echo json_encode($response);
  }
}

/* End of file Home.php */
