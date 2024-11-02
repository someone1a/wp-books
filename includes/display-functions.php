<?php

function book_uploader_display_download_link($content) {
    if (is_single() && get_post_type() === 'libro') {
        $url_externa = get_post_meta(get_the_ID(), '_book_uploader_external_url', true);
        $archivo_local = get_post_meta(get_the_ID(), '_book_uploader_file', true);
        $book_cover = get_post_meta(get_the_ID(), '_book_uploader_cover', true);

        if ($book_cover) {
            $content .= '<p><img src="' . esc_url($book_cover) . '" alt="Portada del Libro" style="max-width: 100%; height: auto;" /></p>';
        }

        if ($url_externa) {
            $content .= '<p><a href="' . esc_url($url_externa) . '" target="_blank">Descargar desde enlace externo</a></p>';
        } elseif ($archivo_local) {
            $content .= '<p><a href="' . esc_url($archivo_local) . '" download>Descargar archivo</a></p>';
        } else {
            $content .= '<p>No hay enlace de descarga disponible.</p>';
        }
    }
    return $content;
}
add_filter('the_content', 'book_uploader_display_download_link');

// Function to handle the posting of publications
function book_uploader_post_publication() {
    // Add your code here to handle the posting of publications
}
