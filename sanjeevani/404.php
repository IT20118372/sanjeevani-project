<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Antyra_Core_Site
 * @since 1.0.0
 */


get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="error-404 not-found wrap404">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'sansararesort' ); ?></h1>
				</header><!-- .page-header -->
				<div class="imgnotfount">
					<img src="<?php echo get_template_directory_uri(); ?>/images/core/404_page_not_found.svg" alt="404 Not Found">
				</div>
				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location.', 'sansararesort' ); ?></p>
					
				</div><!-- .page-content -->
			</div><!-- .error-404 -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
