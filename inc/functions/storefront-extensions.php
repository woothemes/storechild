<?php
/**
 * Storechild Storefront extension compatibility
 *
 * @package storechild
 */

/**
 * Returns an array with default storefront and extension options
 * @return array
 */
function storechild_defaults() {
	return array(

		// 'storefront_header_background_color' => '#000000',
		// 'storefront_header_text_color'       => '#ffffff',

	); 
}

/**
 * Remove Customizer settings added by Storefront extensions that this theme is incompatible with.
 * @return void
 */
function storechild_customize_storefront_extensions( $wp_customize ) {
	$wp_customize->remove_control( 'sd_header_layout' );
	$wp_customize->remove_control( 'sd_button_flat' );
	$wp_customize->remove_control( 'sd_button_shadows' );
	$wp_customize->remove_control( 'sd_button_background_style' );
	$wp_customize->remove_control( 'sd_button_rounded' );
	$wp_customize->remove_control( 'sd_button_size' );
	$wp_customize->remove_control( 'sd_header_layout_divider_after' );
	$wp_customize->remove_control( 'sd_button_divider_1' );
	$wp_customize->remove_control( 'sd_button_divider_2' );
	$wp_customize->remove_control( 'storefront_footer_background_color' );
	$wp_customize->remove_control( 'storefront_header_link_color' );
	
	// Set default values for extension settings in customizer
	foreach ( storechild_defaults() as $mod => $val ) {
		$setting = $wp_customize->get_setting( $mod );
		if ( is_object( $setting ) ) {
			$setting->default = $val;
		}
	}
}

/**
 * Set / remove theme mods to suit this theme after activation
 * @return void
 */
function storechild_set_theme_mods() {
	// Reset certain theme settings from the db
	remove_theme_mod( 'sd_header_layout' );
	remove_theme_mod( 'sd_button_flat' );
	remove_theme_mod( 'sd_button_shadows' );
	remove_theme_mod( 'sd_button_background_style' );
	remove_theme_mod( 'sd_button_rounded' );
	remove_theme_mod( 'sd_button_size' );
	remove_theme_mod( 'sd_content_background_color' );
	remove_theme_mod( 'storefront_footer_background_color' );
	remove_theme_mod( 'storefront_header_link_color' );

	// Set default theme mods
	foreach ( storechild_defaults() as $mod => $val ) {
		if ( ! (bool) get_theme_mod( $mod ) ) {
			set_theme_mod( $mod, $val );
		}
	}
}

/**
 * Storefront WooCommerce Customiser compatibility tweaks
 */
function storechild_storefront_woocommerce_customiser() {
	remove_action( 'storefront_header', 'storefront_product_search', 40 );
	remove_action( 'storefront_header', 'storefront_header_cart', 60 );
	
	$cart_link = true;
	$search    = true;

	if ( class_exists( 'Storefront_WooCommerce_Customiser' ) ) {
		$cart_link 	= get_theme_mod( 'swc_header_cart', true );
		$search 	= get_theme_mod( 'swc_header_search', true );
	}

	if ( true == $cart_link ) {
		add_action( 'storefront_header', 'storefront_header_cart', 30 );
	}

	if ( true == $search ) {
		add_action( 'storefront_header', 'storefront_product_search', 10 );
	}
}