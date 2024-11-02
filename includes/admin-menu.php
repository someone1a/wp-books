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
}
