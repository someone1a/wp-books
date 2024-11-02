<?php

function book_uploader_add_metabox() {
    add_meta_box(
        'book_uploader_metabox',
        __('Información del Libro'),
        'book_uploader_metabox_callback',
        'libro',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'book_uploader_add_metabox');

function book_uploader_metabox_callback($post) {
    $url_externa = get_post_meta($post->ID, '_book_uploader_external_url', true);
    $archivo_local = get_post_meta($post->ID, '_book_uploader_file', true);
    $book_cover = get_post_meta($post->ID, '_book_uploader_cover', true);
    $search_term = get_post_meta($post->ID, '_book_uploader_search_term', true);

    echo '<label for="book_external_url">' . __('Enlace Externo: ') . '</label>';
    echo '<input type="text" id="book_external_url" name="book_external_url" value="' . esc_attr($url_externa) . '" style="width: 100%;" />';

    echo '<p>' . __('o') . '</p>';

    echo '<label for="book_local_file">' . __('Archivo Local: ') . '</label>';
    echo '<input type="file" id="book_local_file" name="book_local_file" />';

    echo '<p>' . __('o') . '</p>';

    echo '<label for="book_cover">' . __('Portada del Libro: ') . '</label>';
    echo '<input type="file" id="book_cover" name="book_cover" />';

    echo '<p>' . __('o') . '</p>';

    // Display error messages for invalid input fields
    if (isset($_GET['book_uploader_error'])) {
        echo '<p style="color: red;">' . esc_html($_GET['book_uploader_error']) . '</p>';
    }
}

function book_uploader_save_meta($post_id) {
    if (isset($_POST['book_external_url'])) {
        update_post_meta($post_id, '_book_uploader_external_url', sanitize_text_field($_POST['book_external_url']));
    }

    if (isset($_FILES['book_local_file'])) {
        $file = $_FILES['book_local_file'];
        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (!isset($upload['error']) && isset($upload['url'])) {
            update_post_meta($post_id, '_book_uploader_file', $upload['url']);
        }
    }

    if (isset($_FILES['book_cover'])) {
        $file = $_FILES['book_cover'];
        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (!isset($upload['error']) && isset($upload['url'])) {
            update_post_meta($post_id, '_book_uploader_cover', $upload['url']);
        }
    }

    if (isset($_POST['book_search_term'])) {
        $search_term = sanitize_text_field($_POST['book_search_term']);
        $cover_url = book_uploader_search_cover($search_term);
        update_post_meta($post_id, '_book_uploader_cover', $cover_url);
    }

    // Add validation for external URL and local file fields
    $external_url = isset($_POST['book_external_url']) ? $_POST['book_external_url'] : '';
    $local_file = isset($_FILES['book_local_file']) ? $_FILES['book_local_file'] : '';
    $error = book_uploader_validate_fields($external_url, $local_file);
    if ($error) {
        wp_redirect(add_query_arg('book_uploader_error', urlencode($error), get_edit_post_link($post_id, 'url')));
        exit;
    }

    // Function to handle the posting of books
    book_uploader_post_book($post_id);
}
add_action('save_post', 'book_uploader_save_meta');

// Function to handle the posting of books
function book_uploader_post_book($post_id) {
    // Add your code here to handle the posting of books
}
