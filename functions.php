<?php
/*
Plugin Name: WooCommerce Video Fields
Description: Adds custom fields (Video Title and Video URL) in the General section of WooCommerce products.
Version: 1.0
Author: Your Name
*/

// Custom fields ko General section mein add karna
add_action('woocommerce_product_options_general_product_data', 'add_custom_video_fields');

function add_custom_video_fields() {
    // Video Title field
    woocommerce_wp_text_input(array(
        'id' => '_video_title',
        'label' => __('Video Title', 'woocommerce'),
        'description' => __('Enter the video title here.', 'woocommerce'),
        'desc_tip' => true,
    ));

    // Video URL field
    woocommerce_wp_text_input(array(
        'id' => '_video_url',
        'label' => __('Video URL', 'woocommerce'),
        'description' => __('Enter the video URL here.', 'woocommerce'),
        'desc_tip' => true,
    ));
}

// Custom fields ko save karna jab product save ho
add_action('woocommerce_process_product_meta', 'save_custom_video_fields');

function save_custom_video_fields($post_id) {
    $video_title = isset($_POST['_video_title']) ? sanitize_text_field($_POST['_video_title']) : '';
    $video_url = isset($_POST['_video_url']) ? esc_url($_POST['_video_url']) : '';

    // Save custom fields
    update_post_meta($post_id, '_video_title', $video_title);
    update_post_meta($post_id, '_video_url', $video_url);
}

// Single product page par Video Title aur Video URL display karna
add_action('woocommerce_single_product_summary', 'display_video_fields_on_product_page', 15);

function display_video_fields_on_product_page() {
    global $product;

    // Get the custom fields' values
    $video_title = get_post_meta($product->get_id(), '_video_title', true);
    $video_url = get_post_meta($product->get_id(), '_video_url', true);

    // Agar fields mein value hai tabhi display karna
    if ($video_title || $video_url) {
        echo '<div class="product-video">';
        
        if ($video_title) {
            echo '<h3>' . esc_html($video_title) . '</h3>';
        }
        
        if ($video_url) {
            echo '<p><a href="' . esc_url($video_url) . '" target="_blank">Watch Video</a></p>';
        }
        
        echo '</div>';
    }
}
