<?php
/**
 * Plugin Name: Electronic Store Sample Products Importer
 * Plugin URI: https://example.com/
 * Description: Imports sample products programmatically to populate the Electronic Store demo content.
 * Version: 1.0
 * Author: Remote Help
 * Text Domain: es-sample-importer
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function esspi_import_products() {
    if ( get_option( 'esspi_imported' ) ) {
        return;
    }

    $products = array(
        array(
            'name' => 'Multigroomer All-in-One Trimmer Series 5000, 23 Piece Mens Grooming Kit',
            'price' => 44,
            'regular_price' => 49,
            'image' => 'https://ext.same-assets.com/493246017/4092406740.jpeg',
        ),
        array(
            'name' => 'Smart Speaker with Alexa Voice Control Built-in Compact Size with Incredible Sound for Any Room',
            'price' => 219,
            'regular_price' => 249,
            'image' => 'https://ext.same-assets.com/493246017/1644006432.jpeg',
        ),
        // add additional products here
    );

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    foreach ( $products as $p ) {
        $post_id = wp_insert_post( array(
            'post_title' => sanitize_text_field( $p['name'] ),
            'post_status' => 'publish',
            'post_type' => 'product',
        ) );

        if ( ! is_wp_error( $post_id ) ) {
            update_post_meta( $post_id, '_price', $p['price'] );
            update_post_meta( $post_id, '_regular_price', $p['regular_price'] );
            update_post_meta( $post_id, '_sale_price', $p['price'] );

            // sideload image
            $image_id = media_sideload_image( esc_url_raw( $p['image'] ), $post_id, null, 'id' );
            if ( ! is_wp_error( $image_id ) ) {
                set_post_thumbnail( $post_id, $image_id );
            }
        }
    }

    update_option( 'esspi_imported', 1 );
}

register_activation_hook( __FILE__, 'esspi_import_products' );
