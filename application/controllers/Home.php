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
    $data['title'] = "Rekomendasi Perbaikan | " . $this->apl['nama_sistem'];
    $data['content'] = "home/rekomendasi.php";
    $this->parser->parse('frontend/template_produk', $data);
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
