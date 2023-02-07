
<?php if (have_posts()) : ?>
	<div class="row <?php echo esc_attr( goya_pagination_style() ); ?> masonry" data-layoutmode="packery">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'inc/templates/blogbit/cards'); ?>
		<?php endwhile; ?>
	</div>
	<?php do_action('goya_blog_pagination'); ?>
<?php else : ?>
  <?php get_template_part( 'inc/templates/not-found' ); ?>
<?php endif; ?>
