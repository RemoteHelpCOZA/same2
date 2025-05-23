<?php
defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main class="site-main single-product">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); wc_get_template_part( 'content', 'single-product' ); endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>
