<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Custom session configuration for PHP 8 compatibility
 * This helps avoid session-related errors in CodeIgniter 3.x with PHP 8+
 */

// Alternative session configuration
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = APPPATH . 'cache/sessions/';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// Create session directory if it doesn't exist
if (!is_dir($config['sess_save_path'])) {
    mkdir($config['sess_save_path'], 0700, true);

    // Create .htaccess to protect session files
    $htaccess_content = "Deny from all\n";
    file_put_contents($config['sess_save_path'] . '.htaccess', $htaccess_content);

    // Create index.html to prevent directory browsing
    $index_content = "<!DOCTYPE html>\n<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
    file_put_contents($config['sess_save_path'] . 'index.html', $index_content);
}
