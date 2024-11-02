<?php

function book_uploader_handle_html_content_upload($post_id) {
    if (isset($_POST['book_html_content'])) {
        $html_content = wp_kses_post($_POST['book_html_content']);
        update_post_meta($post_id, '_book_uploader_html_content', $html_content);
    }
}
add_action('save_post', 'book_uploader_handle_html_content_upload');
?>
