<?php

function book_uploader_register_post_type() {
    register_post_type('libro', [
        'labels' => [
            'name' => __('Libros'),
            'singular_name' => __('Libro')
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-book',
        'rewrite' => [
            'slug' => 'libro',
            'with_front' => false
        ]
    ]);

    book_uploader_post_publication();
}
add_action('init', 'book_uploader_register_post_type');

function book_uploader_post_publication() {
    // Add your code here to handle the posting of publications
    $args = [
        'post_type' => 'libro',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $html_content = get_post_meta($post_id, '_book_uploader_html_content', true);

            if ($html_content) {
                $html_content = book_uploader_handle_html_structure($html_content);
                $html_content = book_uploader_verify_and_wrap_content($html_content);
                wp_update_post([
                    'ID' => $post_id,
                    'post_content' => $html_content,
                ]);
            }
        }
        wp_reset_postdata();
    }
}
