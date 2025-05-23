<?php
/**
 * Plugin Name: Electronic Store Sample Products Importer
 * Description: Imports sample products matching demo content.
 * Version: 1.0
 * Author: Assistant
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function esp_import_products() {
    if ( get_option( 'esp_products_imported' ) ) return;

    $products = array(
        array(
            'name' => 'Multigroomer All-in-One Trimmer Series 5000, 23 Piece Mens Grooming Kit',
            'price' => 44.00,
            'regular_price' => 49.00,
            'image_url' => 'https://ext.same-assets.com/493246017/4092406740.jpeg',
        ),
        array(
            'name' => 'Smart Speaker with Alexa Voice Control Built-in Compact Size with Incredible Sound for Any Room',
            'price' => 219.00,
            'regular_price' => 249.00,
            'image_url' => 'https://ext.same-assets.com/493246017/1644006432.jpeg',
        ),
        // Add more products as needed
    );

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    foreach ( $products as $p ) {
        $post_id = wp_insert_post( array(
            'post_title'  => wp_strip_all_tags( $p['name'] ),
            'post_content'=> '',
            'post_status' => 'publish',
            'post_type'   => 'product',
        ) );
        if ( ! is_wp_error( $post_id ) ) {
            // Set prices
            update_post_meta( $post_id, '_price', $p['price'] );
            update_post_meta( $post_id, '_regular_price', $p['regular_price'] );
            update_post_meta( $post_id, '_sale_price', $p['price'] );

            // Import image
            $image_id = media_sideload_image( $p['image_url'], $post_id, null, 'id' );
            if ( ! is_wp_error( $image_id ) ) {
                set_post_thumbnail( $post_id, $image_id );
            }
        }
    }

    update_option( 'esp_products_imported', 1 );
}
register_activation_hook( __FILE__, 'esp_import_products' );
