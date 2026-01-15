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
    
    // Get all gejala untuk jenis perbaikan ini
    $all_gejala = $this->db->query("
      SELECT DISTINCT gk.* 
      FROM gejala_kerusakan gk
      INNER JOIN gejala_jenis_perbaikan gjp ON gk.id = gjp.id_gejala
      WHERE gjp.id_jenis_perbaikan = ? AND gk.status = '1'
      ORDER BY gk.urutan ASC, gk.kode_gejala ASC
    ", array($id_jenis_perbaikan))->result();
    
    // Jika kosong, coba tabel relasi
    if (empty($all_gejala)) {
      $all_gejala = $this->db->query("
        SELECT DISTINCT gk.* 
        FROM gejala_kerusakan gk
        INNER JOIN relasi_gejala_jenis_perbaikan rgjp ON gk.id = rgjp.id_gejala_kerusakan
        WHERE rgjp.id_jenis_perbaikan = ? AND gk.status = '1'
        ORDER BY gk.urutan ASC, gk.kode_gejala ASC
      ", array($id_jenis_perbaikan))->result();
    }
    
    // Hitung sudah berapa pertanyaan yang dijawab
    $jawaban_gejala = $diagnosis_data['jawaban_gejala'] ?? array();
    $total_gejala = count($all_gejala);
    $total_dijawab = count($jawaban_gejala);
    
    // Ambil gejala saat ini (yang belum dijawab)
    $current_gejala = null;
    $current_index = $total_dijawab;
    
    if ($current_index < $total_gejala) {
      $current_gejala = $all_gejala[$current_index];
    }
    
    $data['title'] = "Pertanyaan Gejala | " . $this->apl['nama_sistem'];
    $data['current_step'] = 3;
    $data['current_gejala'] = $current_gejala;
    $data['current_index'] = $current_index + 1;
    $data['total_gejala'] = $total_gejala;
    $data['jawaban_gejala'] = $jawaban_gejala;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }
  
  private function step4_kerusakan($diagnosis_data)
  {
    $jawaban_gejala = $diagnosis_data['jawaban_gejala'] ?? array();
    if (empty($jawaban_gejala)) {
      redirect('home/rekomendasi?step=3');
    }
    
    // Get jenis kerusakan yang relevan berdasarkan gejala YA
    $gejala_ya = array();
    foreach ($jawaban_gejala as $id_gejala => $jawab) {
      if ($jawab['jawaban'] == 'ya') {
        $gejala_ya[] = $id_gejala;
      }
    }
    
    $all_kerusakan = array();
    if (!empty($gejala_ya)) {
      $gejala_ids = implode(',', $gejala_ya);
      $all_kerusakan = $this->db->query("
        SELECT DISTINCT jk.* 
        FROM jenis_kerusakan jk
        INNER JOIN relasi_jenis_kerusakan_gejala rjkg ON jk.id = rjkg.id_jenis_kerusakan
        WHERE rjkg.id_gejala_kerusakan IN ($gejala_ids) AND jk.status = '1'
        ORDER BY jk.urutan ASC, jk.kode_kerusakan ASC
      ")->result();
    }
    
    // Hitung sudah berapa pertanyaan yang dijawab
    $jawaban_kerusakan = $diagnosis_data['jawaban_kerusakan'] ?? array();
    $total_kerusakan = count($all_kerusakan);
    $total_dijawab = count($jawaban_kerusakan);
    
    // Ambil kerusakan saat ini (yang belum dijawab)
    $current_kerusakan = null;
    $current_index = $total_dijawab;
    
    if ($current_index < $total_kerusakan) {
      $current_kerusakan = $all_kerusakan[$current_index];
    }
    
    $data['title'] = "Pertanyaan Kerusakan | " . $this->apl['nama_sistem'];
    $data['current_step'] = 4;
    $data['current_kerusakan'] = $current_kerusakan;
    $data['current_index'] = $current_index + 1;
    $data['total_kerusakan'] = $total_kerusakan;
    $data['jawaban_kerusakan'] = $jawaban_kerusakan;
    $data['content'] = "home/rekomendasi.php";
    $this->load->view('frontend/template_produk', $data);
  }
  
  private function step5_hasil($diagnosis_data)
  {
    $jawaban_kerusakan = $diagnosis_data['jawaban_kerusakan'] ?? array();
    if (empty($jawaban_kerusakan)) {
      redirect('home/rekomendasi?step=4');
    }
    
    // Get data lengkap untuk tampilan riwayat
    $id_kategori = $diagnosis_data['id_kategori'] ?? 0;
    $id_jenis_perbaikan = $diagnosis_data['id_jenis_perbaikan'] ?? 0;
    
    // Load kategori yang dipilih
    $kategori = $this->db->get_where('kategori_jenis_perbaikan', array('id' => $id_kategori))->row();
    
    // Load jenis perbaikan yang dipilih
    $jenis_perbaikan = $this->db->get_where('jenis_perbaikan', array('id' => $id_jenis_perbaikan))->row();
    
    // Load semua gejala yang dijawab YA
    $gejala_dipilih = array();
    foreach ($diagnosis_data['jawaban_gejala'] as $id_gejala => $jawab) {
      if ($jawab['jawaban'] == 'ya') {
        $gejala_item = $this->db->get_where('gejala_kerusakan', array('id' => $id_gejala))->row();
        if ($gejala_item) {
          $gejala_dipilih[] = array(
            'data' => $gejala_item,
            'cf_value' => floatval($jawab['cf_value']),
            'cf_persen' => floatval($jawab['cf_value']) * 100
          );
        }
      }
    }
    
    // Load semua kerusakan yang dijawab YA
    $kerusakan_dipilih = array();
    foreach ($diagnosis_data['jawaban_kerusakan'] as $id_kerusakan => $jawab) {
      if ($jawab['jawaban'] == 'ya') {
        $kerusakan_item = $this->db->get_where('jenis_kerusakan', array('id' => $id_kerusakan))->row();
        if ($kerusakan_item) {
          $kerusakan_dipilih[] = array(
            'data' => $kerusakan_item,
            'cf_value' => floatval($jawab['cf_value']),
            'cf_persen' => floatval($jawab['cf_value']) * 100
          );
        }
      }
    }
    
    // Hitung CF untuk rekomendasi
    $hasil_cf = $this->hitung_certainty_factor($diagnosis_data);
    
    $data['title'] = "Hasil Diagnosis | " . $this->apl['nama_sistem'];
    $data['current_step'] = 5;
    $data['diagnosis_data'] = $diagnosis_data;
    $data['kategori'] = $kategori;
    $data['jenis_perbaikan'] = $jenis_perbaikan;
    $data['gejala_dipilih'] = $gejala_dipilih;
    $data['kerusakan_dipilih'] = $kerusakan_dipilih;
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
        // Simpan jawaban gejala satu per satu
        $id_gejala = $this->input->post('id_gejala');
        $jawaban = $this->input->post('jawaban');
        $cf_value = $this->input->post('cf_value');
        
        if (!isset($diagnosis_data['jawaban_gejala'])) {
          $diagnosis_data['jawaban_gejala'] = array();
        }
        
        $diagnosis_data['jawaban_gejala'][$id_gejala] = array(
          'jawaban' => $jawaban,
          'cf_value' => $cf_value ?: 0.6
        );
        
        $this->session->set_userdata('diagnosis_data', $diagnosis_data);
        
        // Cek apakah masih ada gejala yang belum dijawab
        $selesai = $this->input->post('selesai');
        if ($selesai == '1') {
          return 4; // Lanjut ke step kerusakan
        }
        return 3; // Masih di step gejala
        
      case 4:
        // Simpan jawaban kerusakan satu per satu
        $id_kerusakan = $this->input->post('id_kerusakan');
        $jawaban = $this->input->post('jawaban');
        $cf_value = $this->input->post('cf_value');
        
        if (!isset($diagnosis_data['jawaban_kerusakan'])) {
          $diagnosis_data['jawaban_kerusakan'] = array();
        }
        
        $diagnosis_data['jawaban_kerusakan'][$id_kerusakan] = array(
          'jawaban' => $jawaban,
          'cf_value' => $cf_value ?: 0.6
        );
        
        $this->session->set_userdata('diagnosis_data', $diagnosis_data);
        
        // Cek apakah masih ada kerusakan yang belum dijawab
        $selesai = $this->input->post('selesai');
        if ($selesai == '1') {
          return 5; // Lanjut ke hasil
        }
        return 4; // Masih di step kerusakan
    }
    
    return $step;
  }
  
  private function hitung_certainty_factor($diagnosis_data)
  {
    $jawaban_gejala = $diagnosis_data['jawaban_gejala'] ?? array();
    $jawaban_kerusakan = $diagnosis_data['jawaban_kerusakan'] ?? array();
    $id_jenis_perbaikan = $diagnosis_data['id_jenis_perbaikan'] ?? 0;
    
    // Get gejala yang dijawab YA
    $gejala_ya = array();
    foreach ($jawaban_gejala as $id_gejala => $jawab) {
      if ($jawab['jawaban'] == 'ya') {
        $gejala_ya[] = $id_gejala;
      }
    }
    
    // Get kerusakan yang dijawab YA
    $kerusakan_ya = array();
    foreach ($jawaban_kerusakan as $id_kerusakan => $jawab) {
      if ($jawab['jawaban'] == 'ya') {
        $kerusakan_ya[] = $id_kerusakan;
      }
    }
    
    if (empty($gejala_ya) || empty($kerusakan_ya)) {
      return array();
    }
    
    // STEP 1: Cari rekomendasi yang terkait dengan kerusakan yang dipilih
    $gejala_ids_str = implode(',', $gejala_ya);
    $kerusakan_ids_str = implode(',', $kerusakan_ya);
    
    $rekomendasi_list = $this->db->query("
      SELECT DISTINCT rp.*, 
             GROUP_CONCAT(DISTINCT rrjk.id_jenis_kerusakan) as kerusakan_ids,
             COUNT(DISTINCT rrjk.id_jenis_kerusakan) as jumlah_relasi
      FROM rekomendasi_perbaikan rp
      INNER JOIN relasi_rekomendasi_jenis_kerusakan rrjk ON rp.id = rrjk.id_rekomendasi_perbaikan
      WHERE rp.status = '1' 
        AND rrjk.id_jenis_kerusakan IN ($kerusakan_ids_str)
      GROUP BY rp.id
      ORDER BY jumlah_relasi DESC, rp.cf_value DESC
    ")->result();
    
    $hasil = array();
    
    foreach ($rekomendasi_list as $rekomendasi) {
      // CF dari expert (dari database)
      $cf_expert = floatval($rekomendasi->cf_value);
      
      // STEP 2: Hitung CF gabungan dari gejala yang dijawab YA
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
      
      // STEP 3: Hitung CF gabungan dari kerusakan yang dijawab YA
      $cf_kerusakan = 0;
      $count_kerusakan_ya = 0;
      $kerusakan_match_count = 0;
      
      $kerusakan_ids_array = explode(',', $rekomendasi->kerusakan_ids);
      
      foreach ($jawaban_kerusakan as $id_kerusakan => $jawab) {
        if ($jawab['jawaban'] == 'ya') {
          $cf_user = floatval($jawab['cf_value']);
          
          // Hitung berapa banyak kerusakan yang match
          if (in_array($id_kerusakan, $kerusakan_ids_array)) {
            $kerusakan_match_count++;
          }
          
          if ($count_kerusakan_ya == 0) {
            $cf_kerusakan = $cf_user;
          } else {
            $cf_kerusakan = $cf_kerusakan + ($cf_user * (1 - $cf_kerusakan));
          }
          $count_kerusakan_ya++;
        }
      }
      
      // STEP 4: Kombinasi CF Evidence (rata-rata weighted)
      // Kerusakan lebih penting (70%) daripada gejala (30%)
      $cf_evidence = ($cf_kerusakan * 0.7) + ($cf_gejala * 0.3);
      
      // STEP 5: CF Total = CF Expert × CF Evidence
      $cf_total = $cf_expert * $cf_evidence;
      
      // STEP 6: Bonus untuk match rate
      $match_percentage = $kerusakan_match_count / max(1, count($kerusakan_ya));
      $bonus = $match_percentage * 0.15; // Max bonus 15%
      $cf_total = min(1.0, $cf_total + ($bonus * (1 - $cf_total)));
      
      // Hanya tampilkan yang memiliki CF > 0.15 (15%)
      if ($cf_total > 0.15) {
        $hasil[] = array(
          'rekomendasi' => $rekomendasi,
          'cf_score' => $cf_total,
          'confidence' => $cf_total * 100,
          'cf_gejala' => $cf_gejala,
          'cf_kerusakan' => $cf_kerusakan,
          'match_count' => $kerusakan_match_count,
          'match_percentage' => $match_percentage * 100
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
