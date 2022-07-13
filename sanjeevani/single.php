<?php
    /**
     * The template for displaying all single posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
     *
     * @package WordPress
     * @subpackage Antyra_Core_Site
     * @since 1.0.0
     */
?>

<?php get_header(); ?>

<?php 
    $banner_margin_bottom = get_field( 'banner_margin_bottom', $post->ID );
    $article_author         = get_field( 'article_author_name', $post->ID );
?>

<?php if ( $banner_margin_bottom ) : ?>
	<section class="comp-space"></section>
<?php endif; ?>

<?php
    get_template_part( 'template-parts/content/content', 'components' );

    if ( $article_author ){
        echo '<section class="comp-paragraph margin-bottom"><p>By <span style="font-style: italic;">'.$article_author.'</span></p></section>';
    }
?>

<?php get_footer(); ?>
