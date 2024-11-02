<?php
/**
 * Plugin Name: Book Uploader
 * Description: Permite a los usuarios cargar libros como artículos y seleccionar enlaces de descarga o archivos locales.
 * Version: 1.0
 * Author: someone1a
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BOOK_UPLOADER_PATH', plugin_dir_path(__FILE__));

require_once BOOK_UPLOADER_PATH . 'includes/admin-menu.php';
require_once BOOK_UPLOADER_PATH . 'includes/book-upload-handler.php';
require_once BOOK_UPLOADER_PATH . 'includes/book-metabox.php';
require_once BOOK_UPLOADER_PATH . 'includes/display-functions.php'; // Agrega la función de visualización

function book_uploader_activate() {
    book_uploader_post_publication();
}
register_activation_hook(__FILE__, 'book_uploader_activate');

// Add user-friendly error handling and feedback for file upload errors
function book_uploader_handle_upload_error($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return __('El archivo es demasiado grande.');
            case UPLOAD_ERR_PARTIAL:
                return __('El archivo se subió parcialmente.');
            case UPLOAD_ERR_NO_FILE:
                return __('No se subió ningún archivo.');
            default:
                return __('Error desconocido al subir el archivo.');
        }
    }
    return null;
}

// Add validation for external URL and local file fields
function book_uploader_validate_fields($external_url, $local_file) {
    if (empty($external_url) && empty($local_file)) {
        return __('Debe proporcionar un enlace externo o un archivo local.');
    }
    if (!empty($external_url) && !filter_var($external_url, FILTER_VALIDATE_URL)) {
        return __('El enlace externo no es válido.');
    }
    return null;
}

// Function to handle the posting of publications
function book_uploader_post_publication() {
    // Add your code here to handle the posting of publications
}
