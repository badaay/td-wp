<?php
/**
 * The Sidebar containing the footer widget area
 */
?>
<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
<div class="col-md-3">
  <?php dynamic_sidebar( 'footer-one' ); ?>
</div>
<?php endif; ?>
<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
<div class="col-md-3">
  <?php dynamic_sidebar( 'footer-two' ); ?>
</div>
<?php endif; ?>
<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
<div class="col-md-3">
  <?php dynamic_sidebar( 'footer-three' ); ?>
</div>
<?php endif; ?>
<?php if ( is_active_sidebar( 'footer-four' ) ) : ?>
<div class="col-md-3">
  <?php dynamic_sidebar( 'footer-four' ); ?>
</div>
<?php endif; ?>
