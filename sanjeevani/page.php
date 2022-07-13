<?php
	/**
	 * The template for displaying all single posts
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
	 *
	 * @package WordPress
	 * @subpackage Antyra_coresite
	 * @since 1.0.0
	 */

	get_header();

	$core_data    = new antyra_core();
?>

<?php $banner_margin_bottom = get_field( 'banner_margin_bottom', $post->ID ); ?>

<?php if ( $banner_margin_bottom ) : ?>
	<section class="comp-space"></section>
<?php endif; ?>

<?php 
	get_template_part( 'template-parts/content/content', 'components' );
?>

<?php get_footer(); ?>
