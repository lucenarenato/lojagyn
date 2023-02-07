<div class="row results-not-found">
	<div class="col-12">
		<?php if ( is_search() ) : ?>

		<h4 class="alert-error"><?php esc_html_e( 'Sorry, but nothing matched your search terms.', 'goya' ); ?></h4>
		<p><?php esc_html_e( 'Please try again with some different keywords.', 'goya' ); ?></p>

		<?php get_search_form(); ?>

		<?php else : ?>

			<h4><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'goya' ); ?></h4>

		<?php endif; ?>
	</div>
</div>