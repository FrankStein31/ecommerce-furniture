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
?>