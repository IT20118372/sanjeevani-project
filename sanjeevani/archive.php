<?php
	/**
	 * The template for displaying archive pages
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package WordPress
	 * @subpackage Antyra_Core_Site
	 * @since 1.0.0
	 */
?>

<?php get_header(); ?>

<section class="pg-archive">
	<div class="archive-wrapper">
		<ul>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						$article_id = get_the_ID();
						$article_title = get_the_title($article_id);
						$article_link = get_the_permalink($article_id);
					?>
					<li>
						<a href="<?php echo $article_link; ?>">
							<div class="text-wrapper">
								<div class="title-wrap">
									<span class="title"><?php echo $article_title; ?></span>
								</div>
							</div>
						</a>
					</li>
				<?php endwhile; ?>
			<?php 
				else :
					// Include no result template
					get_template_part( 'template-parts/content/content', 'no-content' );
				endif; 
			?>
		</ul>
	</div>
	<?php
		// Include sidebar
		get_template_part( 'template-parts/content/content', 'sidebar' );
	?>
</section>

<?php get_footer(); ?>