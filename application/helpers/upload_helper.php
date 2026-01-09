<?php 
	function do_upload_image($input_file,$folder,$tipe_extensi){
		$CI =& get_instance();
		$CI->load->library('upload');
		$fileData = array();
    // File upload script
    $CI->upload->initialize(array(
        'upload_path' => '.'.$folder,
        'overwrite' => false,
        'encrypt_name' => true,
        'allowed_types' => $tipe_extensi,
		));
		
		if ($CI->upload->do_upload($input_file)) {
			$data = $CI->upload->data(); // Get the file data
			$fileData[] = $data; // It's an array with many data
			// Interate throught the data to work with them
			foreach ($fileData as $file) {
				$file_data = $file;
			}

			$response['success'] = TRUE;
			$response['original_name'] = $file_data['orig_name'];
			$response['message'] = "Berhasil Upload File : ".$file_data['orig_name'];
			$response['file_name'] = $file_data['file_name'];
		} else {
			$response['success'] = FALSE;
			$response['message'] = $CI->upload->display_errors();
			$response['file_name'] = "";
		}
		return $response;
	}
	
	function do_upload_file($new_name,$input_file,$folder,$tipe_extensi){
		$CI =& get_instance();
    date_default_timezone_set('Asia/Jakarta');
		$CI->load->library('upload');
		$fileData = array();
    $t=time();
    // File upload script
    $CI->upload->initialize(array(
        'upload_path' => './'.$folder,
        'file_name' => $new_name.'_'.$t,
        'overwrite' => false,
        // 'encrypt_name' => true,
        'allowed_types' => $tipe_extensi,
		));
		
		if ($CI->upload->do_upload($input_file)) {
			$data = $CI->upload->data(); // Get the file data
			$fileData[] = $data; // It's an array with many data
			// Interate throught the data to work with them
			foreach ($fileData as $file) {
				$file_data = $file;
			}

			$response['success'] = TRUE;
			$response['original_name'] = $file_data['orig_name'];
			$response['message'] = "Berhasil Upload File : ".$file_data['orig_name'];
			$response['file_name'] = $folder.$file_data['file_name'];
		} else {
			$response['success'] = FALSE;
			$response['message'] = $CI->upload->display_errors();
			$response['file_name'] = "";
		}
		return $response;
	}

	/**
	 * Upload image dengan validasi modern
	 * 
	 * @param string $field_name Nama field input file
	 * @param string $folder_name Nama folder tujuan (tanpa slash)
	 * @param int $max_size Max size dalam KB (default 2048 = 2MB)
	 * @param string $allowed_types Tipe file yang diizinkan (default: jpg|jpeg|png|gif)
	 * @return array ['status' => bool, 'message' => string, 'file_path' => string]
	 */
	function upload_image($field_name, $folder_name, $max_size = 2048, $allowed_types = 'jpg|jpeg|png|gif')
	{
		$CI =& get_instance();
		
		// Path upload
		$upload_path = './assets/uploads/' . $folder_name . '/';
		
		// Buat folder jika belum ada
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		}
		
		// Konfigurasi upload
		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = $allowed_types;
		$config['max_size']      = $max_size; // KB
		$config['file_name']     = $folder_name . '_' . time();
		$config['encrypt_name']  = FALSE;
		$config['remove_spaces'] = TRUE;
		
		$CI->load->library('upload', $config);
		
		// Lakukan upload
		if ($CI->upload->do_upload($field_name)) {
			$upload_data = $CI->upload->data();
			
			return array(
				'status' => TRUE,
				'message' => 'Upload berhasil',
				'file_path' => 'assets/uploads/' . $folder_name . '/' . $upload_data['file_name'],
				'file_name' => $upload_data['file_name'],
				'full_path' => $upload_data['full_path']
			);
		} else {
			return array(
				'status' => FALSE,
				'message' => $CI->upload->display_errors('', ''),
				'file_path' => NULL
			);
		}
	}
?>