<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_main extends CI_Model{

	/**
	 * [all fungsi mengambil data dari table]
	 * @param  [string] $table [nama tabel]
	 * @return [array]        [data dari tabel]
	 */
	public function get_all($table)
	{
		return $this->db->get($table);
	}
	/**
	 * [get_where mengambil dengan klausa where]
	 * @param  [string] $table [tabel]
	 * @param  [string] $clm   [nama kolom]
	 * @param  [string] $where [value klausa where]
	 */
	public function get_where($table,$clm,$where)
	{
		$this->db->where($clm, $where);
		return $this->db->get($table);
	}

	public function get_where2($table,$key)
	{
		return $this->db->get_where($table,$key);
	}

	public function insert($table,$obj)
	{
		$this->db->insert($table, $obj);
	}
	public function update($table,$data,$clm,$id)
	{
		$this->db->where($clm, $id);
		$this->db->update($table, $data);
	}

	public function update_pass($tabel,$data,$where)
	{
		# code...
		$edit_pass = $this->db->update($tabel,$data,$where);
		return $edit_pass;
	}

	public function get_kode_master_v3($awal,$clm,$table){
        $q = $this->db->query("SELECT MAX(RIGHT($clm,3)) AS idmax FROM $table");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->idmax)+1;
            	$kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }
        $kar = "$awal";
        $kodemax =  $awal.$kd;
        return $kodemax;
	}

	public function get_kode_master_v7($awal,$clm,$table){
        $q = $this->db->query("SELECT MAX(RIGHT($clm,7)) AS idmax FROM $table");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->idmax)+1;
            	$kd = sprintf("%07s", $tmp);
            }
        }else{
            $kd = "0000001";
        }
        $kar = "$awal";
        $kodemax =  $awal.$kd;
        return $kodemax;
	}

  function get_no_otomatis_v3($tbl,$kolom,$awal){
    $q = $this->db->query("SELECT MAX(RIGHT($kolom,3)) AS kd_max FROM $tbl WHERE DATE(created_at)=current_date");
    $kd = "";
    if($q->num_rows()>0){
        $data = $q->row_array();
        foreach($q->result() as $k){
            $tmp = intval($k->kd_max)+1;
            $kd = sprintf("%03s", $tmp);
        }
    }else{
        $kd = "001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return $awal.date('dmY').$kd;
  }

	function get_no_otomatis_v4($tbl,$kolom,$awal){
        $q = $this->db->query("SELECT MAX(RIGHT($kolom,4)) AS kd_max FROM $tbl WHERE DATE(created_at)=current_date");
        $kd = "";
        if($q->num_rows()>0){
            $data = $q->row_array();
            foreach($q->result() as $k){
                $tmp = intval($k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return $awal.date('dmY').$kd;
    }
}
/* End of file M_main.php */
/* Location: ./application/models/M_main.php */