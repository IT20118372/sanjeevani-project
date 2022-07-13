<?php
	/**
	 * The template for displaying search results pages
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
	 *
	 * @package WordPress
	 * @subpackage Antyra_Core_Site
	 * @since 1.0.0
	 */
?>

<?php get_header(); ?>

<?php
	global $query_string;

	wp_parse_str( $query_string, $search_query );
	$search = new WP_Query( $search_query );
	$results = $search->posts;
?>

<section class="pg-archive">
	<div class="archive-wrapper">
		<?php if ( $results ) : ?>
			<ul>
				<?php foreach ( $results as $result ) : ?>
					<?php
						$result_id = $result->ID;
						$result_title = get_the_title($result_id);
						$result_link = get_the_permalink($result_id);
					?>
					<li>
						<a href="<?php echo $result_link; ?>">
							<div class="text-wrapper">
								<div class="title-wrap">
									<span class="title"><?php echo $result_title; ?></span>
								</div>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php 
			else :
				// Include no result template
				get_template_part( 'template-parts/content/content', 'no-content' );
			endif; 
		?>
	</div>
	<?php
		// Include sidebar
		get_template_part( 'template-parts/content/content', 'sidebar' );
	?>
</section>

<?php get_footer(); ?>
