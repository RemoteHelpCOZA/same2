<?php
defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main class="site-main">
    <section class="shop-header">
        <div class="container">
            <h1><?php woocommerce_page_title(); ?></h1>
        </div>
    </section>
    <section class="product-listing">
        <div class="container">
            <?php if ( woocommerce_product_loop() ) {
                woocommerce_product_loop_start();
                while ( have_posts() ) {
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                }
                woocommerce_product_loop_end();
                do_action( 'woocommerce_after_shop_loop' );
            } else {
                do_action( 'woocommerce_no_products_found' );
            } ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
