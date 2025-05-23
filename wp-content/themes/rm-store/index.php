<?php
/**
 * Main template file
 *
 * @package ElectronicStore
 */
get_header();
if ( is_front_page() ) {
    include locate_template( 'front-page.php' );
} else if ( is_woocommerce() ) {
    // Let WooCommerce handle templates
    woocommerce_content();
} else {
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    endif;
}
get_footer();
?>
