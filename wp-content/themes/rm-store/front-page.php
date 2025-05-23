<?php /* Template for homepage */ ?>
<?php get_header(); ?>
<main class="site-main">
    <?php if ( is_front_page() ) : ?>
    <!-- Feature Banners -->
    <section class="feature-banners container">
        <div class="banners-grid">
            <?php
            $banners = [
                ['icon'=>'fa-truck','title'=>'Free shipping','text'=>'When you spend $80 or more'],
                ['icon'=>'fa-headset','title'=>'24/7 Support','text'=>'We are available 24/7'],
                ['icon'=>'fa-undo','title'=>'Easy 30-day return','text'=>'Satisfied or return'],
                ['icon'=>'fa-lock','title'=>'100% secure payments','text'=>'Visa, Mastercard, Stripe, PayPal'],
            ];
            foreach($banners as $b): ?>
                <div class="banner-item">
                    <i class="fas <?php echo esc_attr($b['icon']); ?>"></i>
                    <h4><?php echo esc_html($b['title']); ?></h4>
                    <p><?php echo esc_html($b['text']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Category Grid -->
    <section class="category-grid container">
        <h2><?php echo esc_html(get_theme_mod('home_categories_heading','Categories')); ?></h2>
        <div class="grid">
            <?php
            $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>false]);
            foreach($cats as $cat):
                $thumb_id = get_term_meta($cat->term_id,'thumbnail_id',true);
                $img = $thumb_id ? wp_get_attachment_url($thumb_id) : wc_placeholder_img_src();
            ?>
                <a href="<?php echo get_term_link($cat); ?>" class="cat-card">
                    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                    <h3><?php echo esc_html($cat->name); ?> <span>(<?php echo esc_html($cat->count); ?>)</span></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Today's Best Deal -->
    <section class="best-deal container">
        <h2><?php echo esc_html(get_theme_mod('best_deal_heading','Today’s Best Deal')); ?></h2>
        <div class="deal-grid">
            <?php
            $deal_query = wc_get_products(['limit'=>8,'status'=>'publish','on_sale'=>true]);
            foreach($deal_query as $product): ?>
                <div class="deal-item">
                    <a href="<?php echo get_permalink($product->get_id()); ?>">
                        <?php echo $product->get_image('medium'); ?>
                        <h4><?php echo esc_html($product->get_name()); ?></h4>
                    </a>
                    <span class="price"><?php echo $product->get_price_html(); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Sectioned Category Products -->
    <?php for ($i = 1; $i <= 6; $i++) :
        $cat_id = get_theme_mod("section_{$i}_category");
        if (!$cat_id) continue;
        $term = get_term($cat_id);
        if (is_wp_error($term) || !$term) continue;
        $title = get_theme_mod("section_{$i}_title", $term->name);
        $products = wc_get_products(['limit'=>8,'category'=>[$cat_id],'status'=>'publish']);
    ?>
        <section class="cat-section container">
            <div class="section-header">
                <h2><?php echo esc_html($title); ?></h2>
                <a href="<?php echo esc_url(get_term_link($cat_id)); ?>">See more</a>
            </div>
            <div class="products-grid">
                <?php foreach($products as $product): ?>
                    <div class="product-card">
                        <a href="<?php echo get_permalink($product->get_id()); ?>">
                            <?php echo $product->get_image('medium'); ?>
                            <h4><?php echo esc_html($product->get_name()); ?></h4>
                        </a>
                        <span class="price"><?php echo $product->get_price_html(); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endfor; ?>

    <!-- Call to Action Banner -->
    <section class="cta-banner">
        <div class="container">
            <h2><?php echo esc_html(get_theme_mod('cta_text','Create. Play.')); ?></h2>
            <a href="<?php echo get_theme_mod('cta_link','#'); ?>" class="btn cta-btn"><?php echo esc_html(get_theme_mod('cta_button_text','Learn More')); ?></a>
        </div>
    </section>

    <?php endif; ?>
</main>
<?php get_footer(); ?>
