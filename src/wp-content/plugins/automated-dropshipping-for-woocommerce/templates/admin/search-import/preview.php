<?php

	/**
	 * Template to output the preview for each
	 * found product
	 *
	 */

	// Block direct access to the file
	if ( ! defined( 'ABSPATH' ) ) {
		exit();
	}

	/**
	 * @var $preview \DSE_Product
	 */

?>
<div class="dse-minibox dse-minibox-1">
	<div class="dse-box-top">
		<div class="dse-box-media dse-hidden-">
			<img class="dse-search-thumbnail" src="<?php echo esc_url( $preview->get_images()[ 0 ] ) ?>" alt="<?php echo esc_html( $preview->get_title() ); ?>">
		</div>
		<div class="dse-minibox-content">

			<div class="dse-minibox_head">
				<a href="<?php echo esc_url( $preview->get_url() ) ?>" class="dse-minibox_title"><?php echo esc_html( $preview->get_title() ); ?></a>
			</div>
			<div class="dse-minibox_subhead">
				<a href="<?php echo esc_url( $preview->get_seller_id() ) ?>">
					<i class="fa fa-shopping-bag"></i>
					<?php esc_html_e( 'View Seller\'s Store', 'dropshipexpress' ); ?>
				</a>
				<a href="<?php echo esc_url( $preview->get_url() ) ?>">
					<i class="fa fa-external-link-alt"></i>
					<?php esc_html_e( 'View Product\'s Page', 'dropshipexpress' ); ?>
				</a>
			</div>
			<div class="dse-minibox_info">
				<div class="dse-minibox_des">
					<?php echo esc_html( wp_trim_excerpt( $preview->get_desc() ) ); ?>
				</div>
			</div>

		</div>
	</div>
	<div class="dse-minibox-bottom">
		<div class="dse-minibox-item">
			<div class="dse-minibox-extra">
				<span class="dse-minibox-title"><?php esc_html_e( 'Basic Information', 'dropshipexpress' ); ?></span>
			</div>
		</div>
		<div class="dse-minibox-item">
			<div class="dse-minibox-icon">
				<i class="fa fa-store"></i>
			</div>
			<div class="dse-minibox-extra">
				<span class="dse-minibox-title"><?php esc_html_e( 'Sales', 'dropshipexpress' ); ?></span>
				<span class="dse-minibox-value"><?php echo esc_html( $preview->sale_count() ) ?></span>
			</div>
		</div>
		<div class="dse-minibox-item">
			<div class="dse-minibox-icon">
				<i class="fa fa-dollar-sign"></i>
			</div>
			<div class="dse-minibox-extra">
				<span class="dse-minibox-title"><?php esc_html_e( 'Price', 'dropshipexpress' ); ?></span>
				<span class="dse-minibox-value"><?php echo esc_html( $preview->get_price_formatted() ) ?></span>
			</div>
		</div>
		<div class="dse-minibox-item">
			<div class="dse-minibox-icon">
				<i class="fa fa-calendar-plus"></i>
			</div>
			<div class="dse-minibox-extra">
				<span class="dse-minibox-title"><?php esc_html_e( 'Discounted Price', 'dropshipexpress' ); ?></span>
				<span class="dse-minibox-value"><?php echo esc_html( $preview->get_discount_formatted() ) ?></span>
			</div>
		</div>
		<div class="dse-minibox-item">
			<div class="dse-minibox-icon">
				<i class="fa fa-clock"></i>
			</div>
			<div class="dse-minibox-extra">
				<span class="dse-minibox-title"><?php esc_html_e( 'Category', 'dropshipexpress' ); ?></span>
				<span class="dse-minibox-value"><?php echo esc_html( $preview->get_category_id() ) ?></span>
			</div>
		</div>
		<div class="dse-minibox-item">
			<div class="dse-minibox-icon">
				<i class="fa fa-star"></i>
			</div>
			<div class="dse-minibox-extra">
				<span class="dse-minibox-title"><?php esc_html_e( 'Rating', 'dropshipexpress' ); ?></span>
				<span class="dse-minibox-value"><?php echo sprintf( '%1$s %2$s', $preview->get_rating(), esc_html__( 'Out of 5', 'dropshipexpress' ) ); ?></span>
			</div>
		</div>
	</div>
</div>