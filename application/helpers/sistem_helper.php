<?php
function json_response($payload){
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($payload);
}
function get_apl(){
    $CI =& get_instance();
    $data = $CI ->db
                ->where('id','CONF1')
                ->get('app_config')
                ->row_array();
    return $data;     
}
function is_login(){
    $CI =& get_instance();
    $sesi_is_login = $CI->session->userdata('auth_is_login');
    if($sesi_is_login==TRUE){
        redirect(site_url('/'));
    }
}
function must_login(){
    $CI =& get_instance();
    $cek = $CI->session->userdata('auth_is_login');
    if($cek==FALSE){
        redirect(site_url('Auth'));
    }
}
function get_hari($hari){
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;
    
            case 'Mon':			
                $hari_ini = "Senin";
            break;
    
            case 'Tue':
                $hari_ini = "Selasa";
            break;
    
            case 'Wed':
                $hari_ini = "Rabu";
            break;
    
            case 'Thu':
                $hari_ini = "Kamis";
            break;
    
            case 'Fri':
                $hari_ini = "Jumat";
            break;
    
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";		
            break;
        }
        return $hari_ini;
}
function get_bulan($bulan){
    $array_bulan=array(
        '01'=>'Januari',
        '02'=>'Februari',
        '03'=>'Maret',
        '04'=>'April',
        '05'=>'Mei',
        '06'=>'Juni',
        '07'=>'Juli',
        '08'=>'Agustus',
        '09'=>'September',
        '10'=>'Oktober',
        '11'=>'November',
        '12'=>'Desember'
    );
    $bulan_ini = $array_bulan[$bulan];
    return $bulan_ini;
}
function generate_tanggal_indonesia($tgl){
    $array_bulan=array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu_db = strtotime($tgl);
    $hari = date('d',$waktu_db);
    $bulan = $array_bulan[date('m',$waktu_db)];
    $tahun = date('Y',$waktu_db);
    return $hari.' '.$bulan.' '.$tahun;
}
function tgl_indo_dan_jam($tanggal){
    $date = strtotime($tanggal);
    $tanggal =  date('Y-m-d', $date);
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
function kelamin($jenkel){
    if ($jenkel=='L') {
        echo "Laki - Laki";
    }elseif ($jenkel=='P') {
        echo "Perempuan";
    }else{
        echo "-";
    }
}

// berfungsi untuk kirim email verifikasi atau aktivasi akun user setelah registrasi
function api_register($id_user,$nama,$email){
  $CI =& get_instance();
  $config = [
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'protocol'  => 'smtp',
      'smtp_host' => 'ssl://smtp.gmail.com',
      'smtp_user' => $CI->apl['email_smtp'],
      'smtp_pass' => $CI->apl['password_email_smtp'],
      'smtp_port' => 465,
      'crlf'      => "\r\n",
      'newline'   => "\r\n"
  ];

  $CI->load->library('email', $config); 
  $CI->email->from($CI->apl['email_smtp'], $CI->apl['nama_sistem']);
  $CI->email->to($email);
  // $CI->email->attach('url_file');
  $CI->email->subject('Verifikasi Akun | '.$CI->apl['nama_sistem']);
  $data['id_user'] = $id_user;
  $data['nama'] = $nama;
  // $data['root_apl'] = $CI->apl['url_root'];
  $data['root_apl'] = site_url();
  $body = $CI->load->view('auth/format-email',$data,TRUE);
  $CI->email->message($body);
  if ($CI->email->send()) {
      $message = 'Sukses! email berhasil dikirim.';
  } else {
      $message =  'Error! email tidak dapat dikirim.';
  }
  return $message;
}

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function format_tgl_indo($tanggal){
    $bulan = array (
        1 =>   '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . '-' . $bulan[ (int)$pecahkan[1] ] . '-' . $pecahkan[0];
}

function kodeRandom($length = 10) {
    $str = "";
    $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str  .= $characters[$rand];
    }
    return $str;
}

function insert_log($username = "", $action = "", $catatan = "", $ip_address = "", $browser = "", $keterangan = "", $device="Web"){
    $CI =& get_instance();
    $data = array(
        "username" => $username,
        "actions" => $action,
        "ip_address" => $ip_address,
        "browser" => $browser,
        "keterangan" => $keterangan,
        "catatan" => $catatan,
        "device" => $device,
    );
    $CI->db->insert("log_aktivitas", $data);
}

function rupiah($angka, $prefix="Rp "){	
	$hasil_rupiah = $prefix . number_format($angka,0,',','.');
	return $hasil_rupiah;
}

function format_date($date, $format="d-m-Y"){
  $time = strtotime($date);
  return date($format, $time);
}