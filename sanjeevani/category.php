<?php
	/**
	 * The template for displaying category pages
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @package WordPress
	 * @subpackage Antyra_Core_Site
	 * @since 1.0.0
	 */
?>

<?php get_header(); ?>

<?php 
    $cat = get_query_var('cat');
    $cat_name = get_the_category_by_ID($cat);
    $load_articles = loadPostTypes('post', -1, 'menu_order', 'ASC', $cat_name);
?>

<section class="pg-archive">
    <div class="archive-wrapper">
        <?php if ( $load_articles ) : ?>
            <ul>
                <?php foreach ( $load_articles as $article ) : ?>
                    <?php
                        $article_id = $article->ID;
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