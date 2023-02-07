<?php if (have_posts()) : ?>
	<div class="justify-content-md-center">
		<div class="col-12 <?php echo esc_attr( goya_pagination_style() ); ?>">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'inc/templates/blogbit/list'); ?>
			<?php endwhile; ?>
		</div>
	</div>
	<?php do_action('goya_blog_pagination'); ?>
<?php else : ?>
  <?php get_template_part( 'inc/templates/not-found' ); ?>
<?php endif; ?>
