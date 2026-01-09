<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_order extends CI_Controller
{
    private $nama_menu = "Service Order";

    public function __construct()
    {
        parent::__construct();
        $this->apl = get_apl();
        $this->load->model('Service_order_m');
        $this->load->model('M_main');
        $this->load->library('form_validation');
        $this->load->library('email');
    }

    /**
     * Function Admin
     */
    public function index()
    {
        must_login();
        $data['title'] = "Service Order | " . $this->apl['nama_sistem'];
        $data['content'] = "service_order/index.php";
        $this->load->view('sistem/template', $data);
    }

    public function detail_service_order($id)
    {
        must_login();
        $data['title'] = "Detail Service Order | " . $this->apl['nama_sistem'];

        $order = $this->Service_order_m->get_order_by_id($id);
        if (!$order) {
            redirect('Service_order');
        }

        $data['order'] = $order;
        $data['content'] = "service_order/detail_service_order.php";
        $this->load->view('sistem/template', $data);
    }

    public function fetch_data()
    {
        $pg = ($this->input->get("page") != "") ? $this->input->get("page") : 1;
        $key = ($this->input->get("search") != "") ? strtoupper(quotes_to_entities($this->input->get("search"))) : "";
        $limit = $this->input->get("limit");
        $offset = ($limit * $pg) - $limit;
        $column = $this->input->get("sortby");
        $sort = $this->input->get("sorttype");

        $page = array();
        $page['limit'] = $limit;
        $page['count_row'] = $this->Service_order_m->get_list_count($key)['jml'];
        $page['current'] = $pg;
        $page['list'] = gen_paging($page);
        $data['paging'] = $page;
        $data['list'] = $this->Service_order_m->get_list_data($key, $limit, $offset, $column, $sort);

        $this->load->view('sistem/service_order/list_data', $data);
    }

    public function update_status()
    {
        $order_id = $this->input->post('order_id');
        $current_status = $this->input->post('current_status');
        $notes = $this->input->post('notes');

        $this->form_validation->set_rules('order_id', 'Order ID', 'required');
        $this->form_validation->set_rules('current_status', 'Current Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'success' => false,
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        // Define sequential status flow
        $status_flow = array(
            'inspeksi' => 'konfirmasi_biaya',
            'konfirmasi_biaya' => 'pengerjaan',
            'pengerjaan' => 'siap_diambil',
            'siap_diambil' => 'selesai'
        );

        // Check if current status can be progressed
        if (!isset($status_flow[$current_status])) {
            $response = array(
                'success' => false,
                'message' => 'Status ini tidak dapat diupdate lebih lanjut'
            );
            echo json_encode($response);
            return;
        }

        $new_status = $status_flow[$current_status];

        // Update status
        $update_data = array(
            'status' => $new_status,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($notes) {
            $update_data['admin_notes'] = $notes;
        }

        $result = $this->Service_order_m->update_order_by_order_id($order_id, $update_data);

        if ($result) {
            // Get order details for email notification
            $order = $this->Service_order_m->get_order($order_id);

            // Send email notification to customer
            $this->send_status_update_email($order, $new_status);

            $response = array(
                'success' => true,
                'message' => 'Status berhasil diupdate'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Gagal mengupdate status'
            );
        }

        echo json_encode($response);
    }

    public function approve_order()
    {
        $order_id = $this->input->post('order_id');
        $estimated_cost = $this->input->post('estimated_cost');
        $admin_notes = $this->input->post('admin_notes');

        $this->form_validation->set_rules('order_id', 'Order ID', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'success' => false,
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        $update_data = array(
            'status' => 'inspeksi',
            'admin_notes' => $admin_notes,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($estimated_cost) {
            $update_data['estimated_cost'] = $estimated_cost;
        }

        $result = $this->Service_order_m->update_order_by_order_id($order_id, $update_data);

        if ($result) {
            $order = $this->Service_order_m->get_order($order_id);
            $this->send_status_update_email($order, 'inspeksi');

            $response = array(
                'success' => true,
                'message' => 'Pesanan berhasil disetujui dan status diubah ke Inspeksi'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Gagal menyetujui pesanan'
            );
        }

        echo json_encode($response);
    }

    public function reject_order()
    {
        $order_id = $this->input->post('order_id');
        $rejection_reason = $this->input->post('rejection_reason');

        $this->form_validation->set_rules('order_id', 'Order ID', 'required');
        $this->form_validation->set_rules('rejection_reason', 'Alasan Penolakan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'success' => false,
                'message' => validation_errors()
            );
            echo json_encode($response);
            return;
        }

        $update_data = array(
            'status' => 'ditolak',
            'admin_notes' => $rejection_reason,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $result = $this->Service_order_m->update_order_by_order_id($order_id, $update_data);

        if ($result) {
            $order = $this->Service_order_m->get_order($order_id);
            $this->send_status_update_email($order, 'ditolak');

            $response = array(
                'success' => true,
                'message' => 'Pesanan berhasil ditolak'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Gagal menolak pesanan'
            );
        }

        echo json_encode($response);
    }

    private function send_status_update_email($order, $status)
    {
        $this->load->library('email');

        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from('noreply@furniture-store.com', 'Mebel Anggita Jaya');
        $this->email->to($order->customer_name . '<noreply@example.com>'); // In real app, should have customer email
        $this->email->subject('Update Status Pesanan Layanan - ' . $order->order_id);

        $status_names = array(
            'pesanan_diterima' => 'Pesanan Diterima',
            'inspeksi' => 'Sedang Inspeksi',
            'konfirmasi_biaya' => 'Konfirmasi Biaya',
            'pengerjaan' => 'Sedang Dikerjakan',
            'siap_diambil' => 'Siap Diambil',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        );

        $message = "
        <h3>Update Status Pesanan Layanan</h3>
        <p>Halo {$order->customer_name},</p>
        <p>Status pesanan layanan Anda telah diupdate:</p>
        
        <table style='border-collapse: collapse; width: 100%; margin: 20px 0;'>
          <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Order ID:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>{$order->order_id}</td></tr>
          <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Status Terbaru:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'><strong>{$status_names[$status]}</strong></td></tr>
          <tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Tanggal Update:</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . date('d M Y H:i') . "</td></tr>
        </table>
        
        " . ($order->admin_notes ? "<p><strong>Catatan Admin:</strong><br>{$order->admin_notes}</p>" : "") . "
        
        <p>Untuk melihat detail lengkap, silakan kunjungi halaman tracking pesanan Anda.</p>
        <p>Terima kasih atas kepercayaan Anda.</p>
        
        <p>Salam,<br>Tim Mebel Anggita Jaya</p>
        ";

        $this->email->message($message);
        $this->email->send();
    }
}

/* End of file Service_order.php */
