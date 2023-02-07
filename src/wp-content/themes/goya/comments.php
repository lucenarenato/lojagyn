<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

if ( $comments ) {

	$comments_number = absint( get_comments_number() );
	?>

	<div class="comments-container">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-10 col-lg-8">
					<h4 class="comments-title">
						<?php
							if ( ! have_comments() ) {
								_e( 'Leave a comment', 'goya' );
							} else {
								printf(_nx('%1$s reply on &ldquo;%2$s&rdquo;', '%1$s replies on &ldquo;%2$s&rdquo;', $comments_number, 'comments title', 'goya'),
									number_format_i18n( $comments_number ),
									get_the_title()
								);
							}

							?>
					</h4>
						
					<ul class="commentlist cf">
						<?php wp_list_comments(
							array(
								'type'		  	=> 'all',
								'style'       => 'ul',
								'short_ping'  => true,
								'avatar_size' => 60,
							)
						); ?>
					</ul>
					
					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
						<div class="navigation">
							<div class="nav-previous"><?php previous_comments_link(); ?></div>
							<div class="nav-next"><?php next_comments_link(); ?></div>
						</div><!-- .navigation -->
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

<?php }

if ( comments_open() || pings_open() ) { ?>

	<div class="respond-container">
		<div class="container">
			<?php 
			comment_form( array( 
				'comment_notes_after' => ''
			) );
			?>
		</div>
	</div>

<?php } elseif ( is_single() ) { ?>

	<div class="respond-container">
		<div class="container">
			<p class="comments-closed"><?php _e( 'Comments are closed', 'goya' ); ?></p>
		</div>
	</div>

	<?php
}
