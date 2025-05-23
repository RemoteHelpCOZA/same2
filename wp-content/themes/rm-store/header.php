<?php // Header template ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
  <div class="header-top">
    <div class="container">
      <div class="top-left">
        <span>24/7 Customer Service: <a href="tel:1-800-234-5678">1-800-234-5678</a></span>
        <?php if ( has_nav_menu('top') ) wp_nav_menu(['theme_location'=>'top','container'=>'','menu_class'=>'top-menu']); ?>
      </div>
      <div class="top-right">
        <?php if ( function_exists('wc_get_account_menu_items') ) : ?>
          <?php woocommerce_account_menu(); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="header-main">
    <div class="container">
      <div class="logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>">
        </a>
      </div>
      <nav class="main-nav">
        <?php wp_nav_menu(['theme_location'=>'primary','container'=>'','menu_class'=>'menu']); ?>
      </nav>
      <div class="header-icons">
        <?php get_search_form(); ?>
        <a href="<?php echo wc_get_cart_url(); ?>" class="cart-icon"><?php echo WC()->cart->get_cart_contents_count(); ?></a>
      </div>
    </div>
  </div>
</header>

<main>
  <?php if ( is_front_page() ) : ?>
    <section class="hero">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero.jpg" alt="Hero">
      <div class="hero-text">
        <h1><?php echo get_theme_mod('hero_heading', 'The best home entertainment system is here'); ?></h1>
        <p><?php echo get_theme_mod('hero_text', 'Sit diam odio eget rhoncus volutpat est nibh velit posuere egestas.'); ?></p>
        <a href="<?php echo get_theme_mod('hero_cta_link', '#'); ?>" class="btn"><?php echo get_theme_mod('hero_cta_text','Shop now'); ?></a>
      </div>
    </section>
  <?php endif; ?>
