<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_perbaikan extends CI_Controller {
    private $nama_menu = "Kategori Perbaikan";
    
    public function __construct()
    {
        parent::__construct();
        $this->apl = get_apl();
        $this->load->model('Menu_m');
        $this->load->model('Kategori_perbaikan_m');
        must_login();
    }
    
    public function index()
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];
        
        // Ambil data kategori
        $data['kategori_list'] = $this->Kategori_perbaikan_m->get_all();
        
        $data['content'] = "kategori_perbaikan/index.php";
        $this->load->view('sistem/template', $data);
    }
    
    public function create()
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        if ($this->input->method() === 'post') {
            // Validasi input
            $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
            
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('kategori_perbaikan/create');
            }
            
            // Data untuk insert
            $data = [
                'nama_kategori' => $this->input->post('nama_kategori', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'status' => $this->input->post('status', true) == '1' ? '1' : '0'
            ];
            
            $insert = $this->Kategori_perbaikan_m->insert($data);
            
            if ($insert) {
                $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan!');
                redirect('kategori_perbaikan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan kategori!');
                redirect('kategori_perbaikan/create');
            }
        }
        
        $data['title'] = "Tambah ".$this->nama_menu." | ".$this->apl['nama_sistem'];
        $data['content'] = "kategori_perbaikan/create.php";
        $this->load->view('sistem/template', $data);
    }
    
    public function edit($id)
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        // Cek apakah kategori ada
        $kategori = $this->Kategori_perbaikan_m->get_by_id($id);
        if (!$kategori) {
            $this->session->set_flashdata('error', 'Kategori tidak ditemukan!');
            redirect('kategori_perbaikan');
        }
        
        if ($this->input->method() === 'post') {
            // Validasi input
            $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
            
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('kategori_perbaikan/edit/'.$id);
            }
            
            // Data untuk update
            $data = [
                'nama_kategori' => $this->input->post('nama_kategori', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'status' => $this->input->post('status', true) == '1' ? '1' : '0'
            ];
            
            $update = $this->Kategori_perbaikan_m->update($id, $data);
            
            if ($update) {
                $this->session->set_flashdata('success', 'Kategori berhasil diupdate!');
                redirect('kategori_perbaikan');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate kategori!');
                redirect('kategori_perbaikan/edit/'.$id);
            }
        }
        
        $data['title'] = "Edit ".$this->nama_menu." | ".$this->apl['nama_sistem'];
        $data['kategori'] = $kategori;
        $data['content'] = "kategori_perbaikan/edit.php";
        $this->load->view('sistem/template', $data);
    }
    
    public function delete($id)
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        // Cek apakah kategori ada
        $kategori = $this->Kategori_perbaikan_m->get_by_id($id);
        if (!$kategori) {
            $this->session->set_flashdata('error', 'Kategori tidak ditemukan!');
            redirect('kategori_perbaikan');
        }
        
        // Cek apakah kategori masih digunakan di jenis_perbaikan
        $check_usage = $this->db->get_where('jenis_perbaikan', ['id_kategori' => $id])->num_rows();
        
        if ($check_usage > 0) {
            $this->session->set_flashdata('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh '.$check_usage.' jenis perbaikan!');
            redirect('kategori_perbaikan');
        }
        
        $delete = $this->Kategori_perbaikan_m->delete($id);
        
        if ($delete) {
            $this->session->set_flashdata('success', 'Kategori berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kategori!');
        }
        
        redirect('kategori_perbaikan');
    }
    
    public function toggle_status($id)
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        $kategori = $this->Kategori_perbaikan_m->get_by_id($id);
        if (!$kategori) {
            echo json_encode(['success' => false, 'message' => 'Kategori tidak ditemukan']);
            return;
        }
        
        // Toggle status
        $new_status = $kategori->status == '1' ? '0' : '1';
        $update = $this->Kategori_perbaikan_m->update($id, ['status' => $new_status]);
        
        if ($update) {
            echo json_encode(['success' => true, 'message' => 'Status berhasil diubah', 'new_status' => $new_status]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengubah status']);
        }
    }
}
