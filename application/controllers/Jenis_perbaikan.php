<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_perbaikan extends CI_Controller {
    private $nama_menu = "Jenis Perbaikan";
    
    public function __construct()
    {
        parent::__construct();
        $this->apl = get_apl();
        $this->load->model('Menu_m');
        $this->load->model('Jenis_perbaikan_m');
        $this->load->model('Kategori_perbaikan_m');
        must_login();
    }
    
    public function index()
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        $data['title'] = $this->nama_menu." | ".$this->apl['nama_sistem'];
        
        // Ambil data jenis perbaikan dengan kategori
        $data['jenis_list'] = $this->Jenis_perbaikan_m->get_all_with_kategori();
        $data['kategori_list'] = $this->Kategori_perbaikan_m->get_dropdown();
        
        $data['content'] = "jenis_perbaikan/index.php";
        $this->load->view('sistem/template', $data);
    }
    
    public function create()
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        if ($this->input->method() === 'post') {
            // Validasi input
            $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('nama_jenis_perbaikan', 'Nama Jenis Perbaikan', 'required|trim');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
            
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('jenis_perbaikan/create');
            }
            
            // Data untuk insert
            $data = [
                'id_kategori' => $this->input->post('id_kategori', true),
                'nama_jenis_perbaikan' => $this->input->post('nama_jenis_perbaikan', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'status' => $this->input->post('status', true) == '1' ? '1' : '0'
            ];
            
            $insert = $this->Jenis_perbaikan_m->insert($data);
            
            if ($insert) {
                $this->session->set_flashdata('success', 'Jenis perbaikan berhasil ditambahkan!');
                redirect('jenis_perbaikan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan jenis perbaikan!');
                redirect('jenis_perbaikan/create');
            }
        }
        
        $data['title'] = "Tambah ".$this->nama_menu." | ".$this->apl['nama_sistem'];
        $data['kategori_list'] = $this->Kategori_perbaikan_m->get_dropdown();
        $data['content'] = "jenis_perbaikan/create.php";
        $this->load->view('sistem/template', $data);
    }
    
    public function edit($id)
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        // Cek apakah jenis perbaikan ada
        $jenis = $this->Jenis_perbaikan_m->get_by_id($id);
        if (!$jenis) {
            $this->session->set_flashdata('error', 'Jenis perbaikan tidak ditemukan!');
            redirect('jenis_perbaikan');
        }
        
        if ($this->input->method() === 'post') {
            // Validasi input
            $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('nama_jenis_perbaikan', 'Nama Jenis Perbaikan', 'required|trim');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
            
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('jenis_perbaikan/edit/'.$id);
            }
            
            // Data untuk update
            $data = [
                'id_kategori' => $this->input->post('id_kategori', true),
                'nama_jenis_perbaikan' => $this->input->post('nama_jenis_perbaikan', true),
                'deskripsi' => $this->input->post('deskripsi', true),
                'status' => $this->input->post('status', true) == '1' ? '1' : '0'
            ];
            
            $update = $this->Jenis_perbaikan_m->update($id, $data);
            
            if ($update) {
                $this->session->set_flashdata('success', 'Jenis perbaikan berhasil diupdate!');
                redirect('jenis_perbaikan');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate jenis perbaikan!');
                redirect('jenis_perbaikan/edit/'.$id);
            }
        }
        
        $data['title'] = "Edit ".$this->nama_menu." | ".$this->apl['nama_sistem'];
        $data['jenis'] = $jenis;
        $data['kategori_list'] = $this->Kategori_perbaikan_m->get_dropdown();
        $data['content'] = "jenis_perbaikan/edit.php";
        $this->load->view('sistem/template', $data);
    }
    
    public function delete($id)
    {
        $this->Menu_m->role_has_access($this->nama_menu);
        
        // Cek apakah jenis perbaikan ada
        $jenis = $this->Jenis_perbaikan_m->get_by_id($id);
        if (!$jenis) {
            $this->session->set_flashdata('error', 'Jenis perbaikan tidak ditemukan!');
            redirect('jenis_perbaikan');
        }
        
        // Cek apakah masih digunakan di relasi
        $check_relasi = $this->db->get_where('relasi_gejala_jenis_perbaikan', ['id_jenis_perbaikan' => $id])->num_rows();
        
        if ($check_relasi > 0) {
            $this->session->set_flashdata('error', 'Jenis perbaikan tidak dapat dihapus karena masih digunakan di '.$check_relasi.' relasi gejala!');
            redirect('jenis_perbaikan');
        }
        
        $delete = $this->Jenis_perbaikan_m->delete($id);
        
        if ($delete) {
            $this->session->set_flashdata('success', 'Jenis perbaikan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus jenis perbaikan!');
        }
        
        redirect('jenis_perbaikan');
    }
    
    public function get_by_kategori()
    {
        $id_kategori = $this->input->post('id_kategori');
        $jenis_list = $this->Jenis_perbaikan_m->get_by_kategori($id_kategori);
        
        echo json_encode([
            'success' => true,
            'data' => $jenis_list
        ]);
    }
}
