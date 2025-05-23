<?php // Footer template ?>
<footer class="site-footer">
  <div class="container footer-widgets">
    <?php for ($i = 1; $i <= 4; $i++): ?>
      <div class="footer-col footer-col-<?php echo $i; ?>">
        <?php if ( is_active_sidebar("footer_col_{$i}") ) : ?>
          <?php dynamic_sidebar("footer_col_{$i}"); ?>
        <?php endif; ?>
      </div>
    <?php endfor; ?>
  </div>
  <div class="footer-bottom container">
    <div class="footer-menu">
      <?php wp_nav_menu(['theme_location'=>'footer-menu','container'=>'','menu_class'=>'footer-nav']); ?>
    </div>
    <div class="footer-payments">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-payments.png" alt="Payment Methods">
    </div>
    <div class="footer-contact">
      <span>Call us: 1-234-567-8900</span> | <span>Email: support@example.com</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
