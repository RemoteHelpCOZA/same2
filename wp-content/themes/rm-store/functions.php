<?php
// Theme setup
function rm_store_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'top' => 'Top Menu',
        'footer-menu' => 'Footer Menu'
    ));
}
add_action('after_setup_theme', 'rm_store_theme_setup');

// Register footer widget areas
add_action('widgets_init', function() {
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar([
            'name' => "Footer Column {$i}",
            'id' => "footer_col_{$i}",
            'before_widget' => '<div class="footer-widget footer-col-' . $i . '">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-title">',
            'after_title' => '</h4>',
        ]);
    }
});

// Enqueue styles and scripts
function rm_store_enqueue_assets() {
    // Reset and base styles
    wp_enqueue_style('rm-store-reset', get_template_directory_uri() . '/assets/css/reset.css');
    wp_enqueue_style('rm-store-style', get_stylesheet_uri(), [], '1.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

    // Theme fonts
    wp_enqueue_style('rm-store-fonts', false);
    wp_add_inline_style('rm-store-fonts', "@font-face { font-family: 'Poppins'; src: url('" . get_template_directory_uri() . "/assets/fonts/poppins.woff2') format('woff2'); font-weight: 400; font-style: normal; font-display: swap; } @font-face { font-family: 'Inter'; src: url('" . get_template_directory_uri() . "/assets/fonts/inter.woff2') format('woff2'); font-weight: 400; font-style: normal; font-display: swap; }");

    // Theme scripts
    wp_enqueue_script('rm-store-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'rm_store_enqueue_assets');

// Add Customizer controls for home page categories
class WP_Customize_Category_Control extends WP_Customize_Control {
    public $type = 'dropdown-categories';

    public function render_content() {
        $dropdown = wp_dropdown_categories(array(
            'name'              => '_customize-dropdown-categories-' . $this->id,
            'echo'              => 0,
            'show_option_none'  => __('&mdash; Select &mdash;'),
            'option_none_value' => '0',
            'selected'          => $this->value(),
            'taxonomy'          => 'product_cat',
            'hide_empty'        => false,
            'depth'             => 0,
            'show_count'        => true,
        ));
        $dropdown = str_replace('<select', '<select ' . $this->get_link(), $dropdown);
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php echo $dropdown; ?>
        </label>
        <?php
    }
}

// Add Customizer settings
add_action('customize_register', function($wp_customize) {
    // Add section for homepage categories
    $wp_customize->add_section('rm_store_homepage', array(
        'title'    => 'Homepage Settings',
        'priority' => 30,
    ));

    // Home Hero section
    $wp_customize->add_setting('hero_heading', [
        'default' => 'The best home entertainment system is here',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('hero_heading', [
        'label' => 'Hero Heading',
        'section' => 'rm_store_homepage',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('hero_text', [
        'default' => 'Sit diam odio eget rhoncus volutpat est nibh velit posuere egestas.',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('hero_text', [
        'label' => 'Hero Text',
        'section' => 'rm_store_homepage',
        'type' => 'textarea',
    ]);

    $wp_customize->add_setting('hero_cta_text', [
        'default' => 'Shop now',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('hero_cta_text', [
        'label' => 'Hero Button Text',
        'section' => 'rm_store_homepage',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('hero_cta_link', [
        'default' => '#',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('hero_cta_link', [
        'label' => 'Hero Button Link',
        'section' => 'rm_store_homepage',
        'type' => 'url',
    ]);

    // Categories heading
    $wp_customize->add_setting('home_categories_heading', [
        'default' => 'Categories',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('home_categories_heading', [
        'label' => 'Categories Section Heading',
        'section' => 'rm_store_homepage',
        'type' => 'text',
    ]);

    // Best deal heading
    $wp_customize->add_setting('best_deal_heading', [
        'default' => "Today's Best Deal",
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('best_deal_heading', [
        'label' => 'Best Deal Section Heading',
        'section' => 'rm_store_homepage',
        'type' => 'text',
    ]);

    // Individual home categories
    for ($i = 1; $i <= 4; $i++) {
        $setting_id = "home_category_$i";
        $wp_customize->add_setting($setting_id, [
            'default' => '',
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control(new WP_Customize_Category_Control(
            $wp_customize,
            $setting_id,
            [
                'label' => "Home Category #$i",
                'section' => 'rm_store_homepage',
                'settings' => $setting_id,
            ]
        ));
    }

    // Sectioned category product blocks
    for ($i = 1; $i <= 6; $i++) {
        $wp_customize->add_setting("section_{$i}_category", [
            'default' => '',
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control(new WP_Customize_Category_Control(
            $wp_customize,
            "section_{$i}_category",
            [
                'label' => "Section {$i} Category",
                'section' => 'rm_store_homepage',
                'settings' => "section_{$i}_category",
            ]
        ));
        $wp_customize->add_setting("section_{$i}_title", [
            'default' => '',
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control("section_{$i}_title", [
            'label' => "Section {$i} Title",
            'type' => 'text',
            'section' => 'rm_store_homepage',
            'settings' => "section_{$i}_title",
        ]);
    }

    // CTA Banner settings
    $wp_customize->add_setting('cta_text', ['default'=>'Create. Play.','transport'=>'refresh']);
    $wp_customize->add_control('cta_text', [
        'label' => 'CTA Text',
        'type' => 'text',
        'section' => 'rm_store_homepage',
        'settings' => 'cta_text'
    ]);

    $wp_customize->add_setting('cta_link', ['default'=>'#','transport'=>'refresh']);
    $wp_customize->add_control('cta_link', [
        'label' => 'CTA Link',
        'type' => 'url',
        'section' => 'rm_store_homepage',
        'settings' => 'cta_link'
    ]);

    $wp_customize->add_setting('cta_button_text', ['default'=>'Learn More','transport'=>'refresh']);
    $wp_customize->add_control('cta_button_text', [
        'label' => 'CTA Button Text',
        'type' => 'text',
        'section' => 'rm_store_homepage',
        'settings' => 'cta_button_text'
    ]);
});

// Enqueue customizer preview JS for live preview
add_action('wp_enqueue_scripts', function() {
    if (is_customize_preview()) {
        wp_enqueue_script('rm-store-customizer', get_template_directory_uri() . '/assets/js/customizer-preview.js', ['jquery', 'customize-preview'], '', true);
    }
});
