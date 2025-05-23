<?php
// Theme setup
function es_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menu( 'header-menu', 'Header Menu' );
}
add_action( 'after_setup_theme', 'es_theme_setup' );

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
function es_enqueue_assets() {
    // Remove previous font enqueue and stylesheet enqueue, as we'll handle them in the new action below
    wp_enqueue_script( 'es-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'es_enqueue_assets' );

// Register footer menu
function es_widgets_init() {
    register_nav_menu( 'footer-menu', 'Footer Menu' );
}
add_action( 'widgets_init', 'es_widgets_init' );

// Add Customizer setting and control for homepage categories
add_action( 'customize_register', function( $wp_customize ) {
    // Add section
    $wp_customize->add_section( 'es_homepage_categories', array(
        'title'    => 'Homepage Categories',
        'priority' => 30,
    ) );

    // Setting for category IDs (comma-separated)
    $wp_customize->add_setting( 'es_homepage_cat_ids', array(
        'default'           => '',
        'sanitize_callback' => function( $value ) {
            return sanitize_text_field( $value );
        }
    ) );

    // Control
    $wp_customize->add_control( 'es_homepage_cat_ids_control', array(
        'label'       => 'Category IDs (comma-separated)',
        'section'     => 'es_homepage_categories',
        'settings'    => 'es_homepage_cat_ids',
        'type'        => 'text',
        'description' => 'Enter product category IDs in the order you want them to appear.',
    ) );

    // CTA Banner settings
    $wp_customize->add_setting('cta_text', ['default'=>'Create. Play.','transport'=>'refresh']);
    $wp_customize->add_control('cta_text', ['label'=>'CTA Text','type'=>'text','section'=>'title_tagline','settings'=>'cta_text']);
    $wp_customize->add_setting('cta_link', ['default'=>'#','transport'=>'refresh']);
    $wp_customize->add_control('cta_link', ['label'=>'CTA Link','type'=>'url','section'=>'title_tagline','settings'=>'cta_link']);
    $wp_customize->add_setting('cta_button_text', ['default'=>'Learn More','transport'=>'refresh']);
    $wp_customize->add_control('cta_button_text', ['label'=>'CTA Button Text','type'=>'text','section'=>'title_tagline','settings'=>'cta_button_text']);
});

// Add Customizer controls for home page categories (individual selection)
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'WP_Customize_Category_Control' ) ) {
    class WP_Customize_Category_Control extends WP_Customize_Control {
        public $type = 'dropdown-categories';

        public function render_content() {
            $dropdown = wp_dropdown_categories( array(
                'name'              => '_customize-dropdown-categories-' . $this->id,
                'echo'              => 0,
                'show_option_none'  => __( '&mdash; Select &mdash;' ),
                'option_none_value' => '0',
                'selected'          => $this->value(),
                'taxonomy'          => 'product_cat',
                'hide_empty'        => false,
                'depth'             => 0,
                'show_count'        => true,
            ) );
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php echo $dropdown; ?>
            </label>
            <?php
        }
    }
}

add_action('customize_register', function($wp_customize) {
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
                'section' => 'title_tagline', // you can create a new section if preferred
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
                'section' => 'title_tagline',
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
            'section' => 'title_tagline',
            'settings' => "section_{$i}_title",
        ]);
    }
});

// Enqueue customizer preview JS for live preview
add_action('wp_enqueue_scripts', function() {
    if (is_customize_preview()) {
        wp_enqueue_script('rm-store-customizer', get_template_directory_uri() . '/assets/js/customizer-preview.js', ['jquery', 'customize-preview'], '', true);
    }
});

// Enqueue theme fonts and reset stylesheet
add_action('wp_enqueue_scripts', function() {
    // Reset and base styles
    wp_enqueue_style('rm-store-reset', get_template_directory_uri() . '/assets/css/reset.css');
    wp_enqueue_style('rm-store-style', get_stylesheet_uri(), [], '1.0');

    // Theme fonts
    wp_enqueue_style('rm-store-fonts', false);
    wp_add_inline_style('rm-store-fonts', "@font-face { font-family: 'Poppins'; src: url('" . get_template_directory_uri() . "/assets/fonts/poppins.woff2') format('woff2'); font-weight: 400; font-style: normal; font-display: swap; } @font-face { font-family: 'Inter'; src: url('" . get_template_directory_uri() . "/assets/fonts/inter.woff2') format('woff2'); font-weight: 400; font-style: normal; font-display: swap; }");
});
?>
