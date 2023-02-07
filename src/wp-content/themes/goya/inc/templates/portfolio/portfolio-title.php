<?php 
$disable_title = get_post_meta(get_the_ID(), 'goya_portfolio_disable_title', true);

if ($disable_title) return;

$title_class = 'title_outer';

$portfolio_layout = goya_meta_config('portfolio','layout_single','regular');
$gallery = array();
if ( rwmb_meta( 'goya_portfolio_featured_gallery') !== '' ) {
	$gallery = rwmb_meta( 'goya_portfolio_featured_gallery', array( 'size' => 'full' ) );
}
$multiple_gallery = ( !empty($gallery) && count($gallery) > 1 ) ? true :  false; 
?>

<header class="post-title entry-header header-parallax container">
	<div class="row justify-content-md-center">
		<div class="col-lg-9">
			<div class="<?php echo esc_attr( $title_class ); ?>">
				<div class="single-post-categories">
					<?php echo strip_tags( get_the_term_list( $id, 'portfolio-category', '<ul class="post-categories"><li>', '</li><li>', '</li></ul>' ) , '<ul><li>') ; ?>
				</div>
				<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>'); ?>
				<div class="et-portfolio-excerpt">
					<?php 
						add_filter( 'excerpt_length', 'goya_mini_excerpt_length' );
						the_excerpt(); 
					?>
				</div>
			</div>
		</div>
	</div>
</header>