<?php
/**
 * The template for displaying the related posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

global $post; 
$postId = $post->ID;
$query = goya_get_posts_related_by_category($postId);
$columns = 12 / get_theme_mod('single_post_related_columns', 3);
?>

<?php if ($query->have_posts()) : ?>
<aside class="related-posts cf hide-on-print">
  <div class="container">
    <h3 class="related-title"><?php esc_html_e( 'Related Posts', 'goya' ); ?></h3>
  	<div class="row">
    <?php while ($query->have_posts()) : $query->the_post(); ?>             
      <div class="col-12 col-md-6 col-lg-<?php echo esc_attr( $columns ); ?>">
      	<div <?php post_class('post post-grid'); ?> id="post-<?php the_ID(); ?>">
      		<?php if ( has_post_thumbnail() ) { ?>
      		<figure class="post-gallery">
      			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium_large'); ?></a>
      		</figure>
      		<?php } ?>
          <?php if ( get_theme_mod('blog_category', true) == true ) the_category(); ?>
      		<header class="post-title entry-header">
      			<?php the_title( sprintf( '<h3 class="entry-title" itemprop="name headline"><a class="entry-link" href="%s" rel="bookmark" title="%s">', esc_url( get_permalink() ), esc_html(get_the_title()) ), '</a></h3>' ); ?>
      		</header>
          <?php get_template_part( 'inc/templates/postbit/post-meta' ); ?>
      		<div class="post-content">
      			<?php echo goya_excerpt(100, '&hellip;'); ?>
      		</div>
      	</div>
      </div>
    <?php endwhile; ?>
    </div>
  </div>
</aside>
<?php endif; ?>
<?php wp_reset_postdata(); ?>