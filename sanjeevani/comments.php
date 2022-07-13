<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Antyra_Core_Site
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">
	<div class="<?php echo $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses'; ?>">
		<h2 class="comments-title">
		<?php
		if ( comments_open() ) {
			if ( have_comments() ) {
				_e( 'Join the Conversation', 'antyracoresite' );
			} else {
				_e( 'Leave a comment', 'antyracoresite' );
			}
		} else {
			if ( '1' == $discussion->responses ) {
				/* translators: %s: post title */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'antyracoresite' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$discussion->responses,
						'comments title',
						'antyracoresite'
					),
					number_format_i18n( $discussion->responses ),
					get_the_title()
				);
			}
		}
		?>
		</h2><!-- .comments-title -->
		<?php
			// Only show discussion meta information when comments are open and available.
		if ( have_comments() && comments_open() ) {
			get_template_part( 'template-parts/post/discussion', 'meta' );
		}
		?>
	</div><!-- .comments-title-flex -->
	<?php
	if ( have_comments() ) :?>
		<?php

		// Show comment navigation
		if ( have_comments() ) :
			$comments_text = __( 'Comments', 'antyracoresite' );
			the_comments_navigation(
				array(
					'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, __( 'Previous', 'antyracoresite' ), __( 'Comments', 'antyracoresite' ) ),
					'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', 'antyracoresite' ), __( 'Comments', 'antyracoresite' ), $next_icon ),
				)
			);
		endif;

		// Show comment form at bottom if showing newest comments at the bottom.
		if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
			?>
			<div class="comment-form-flex">
				<span class="screen-reader-text"><?php _e( 'Leave a comment', 'antyracoresite' ); ?></span>
				
				<h2 class="comments-title" aria-hidden="true"><?php _e( 'Leave a comment', 'antyracoresite' ); ?></h2>
			</div>
			<?php
		endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments">
				<?php _e( 'Comments are closed.', 'antyracoresite' ); ?>
			</p>
			<?php
		endif;

	else :

		// Show comment form.
		antyracoresite_comment_form( true );

	endif; // if have_comments();
	?>
</div><!-- #comments -->
