<?php if (have_posts()) : ?>
	<div class="row masonry-blog <?php echo esc_attr( goya_pagination_style() ); ?>">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'inc/templates/blogbit/grid'); ?>
		<?php endwhile; ?>
	</div>
	<?php do_action('goya_blog_pagination'); ?>
<?php else : ?>
  <?php get_template_part( 'inc/templates/not-found' ); ?>
<?php endif; ?>