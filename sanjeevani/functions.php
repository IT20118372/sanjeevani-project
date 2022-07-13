<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Antyra_Core_Site
 * @since 1.0.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

//* Enable XML/SWF files to be uploaded *//
function custom_upload_mimes( $fileExt=array()) {
	$fileExt["xml"] = "text/xml";
	$fileExt["mp4"] = "video/mp4";
	$fileExt["swf"] = "application/x-shockwave-flash";
	$fileExt['svg'] = "image/svg+xml";
	$fileExt['html'] = "text/html";
	return $fileExt;
}
add_filter("upload_mimes", "custom_upload_mimes");


@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );


add_filter('wp_title', 'my_custom_title');



function my_custom_title( $title ){
    // Return my custom title
    return sprintf("%s %s", $title, '');

}

remove_action( 'wp_head', '_wp_render_title_tag', 1 );


function pagination_array($array, $page = 1, $link_prefix = false, $limit_page, $link_suffix = false, $limit_number = 10000){

	if (empty($page) or !$limit_page) $page = 1;

	$num_rows 		= 	count($array); 

	// if (!$num_rows or $limit_page >= $num_rows) return false;

	$num_pages 		= 	ceil($num_rows / $limit_page);
	$page_offset 	= 	($page - 1) * $limit_page;
	//Calculating the first number to show.
	if ($limit_number){
		$limit_number_start 	= 	$page - ceil($limit_number / 2);
		$limit_number_end 		= 	ceil($page + $limit_number / 2) - 1;
		if ($limit_number_start < 1) $limit_number_start = 1;
		//In case if the current page is at the beginning.
		$dif = ($limit_number_end - $limit_number_start);
		if ($dif < $limit_number) $limit_number_end = $limit_number_end + ($limit_number - ($dif + 1));
		if ($limit_number_end > $num_pages) $limit_number_end = $num_pages;
		//In case if the current page is at the ending.
		$dif = ($limit_number_end - $limit_number_start);
		if ($limit_number_start < 1) $limit_number_start = 1;
	}else{
		$limit_number_start 	= 	1;
		$limit_number_end 		= 	$num_pages;
	}

	
	if( isset( $_GET['num'] ) ) {
		$num = $_GET['num'];
		$per_page_filter_param = '&num='.$num;
	} else {
		$per_page_filter_param = false;
	}

	if( isset( $_GET['col'] ) && isset( $_GET['val'] ) ) {
	    $filter_params = '&col='.$_GET['col'].'&val='.$_GET['val'];
	} else {
		$filter_params = false;
	}

	if ( get_query_var('paged') ){
		$current_pg_number = get_query_var('paged');
	}elseif ( get_query_var('page') ){
		$current_pg_number = get_query_var('page');
	}else{
		$current_pg_number = 1;
	}	

	// var_dump($num_rows);
	$panel='';
	$panel = '<ul class="pagination">';

				if( $current_pg_number != 1 ):
					$panel .= '<li class="prev"><a href="'.get_the_permalink().$link_prefix.($page - 1).$link_suffix.$per_page_filter_param.$filter_params.'" class="navbtn prev"><span></span></a></li>';
				endif;

					 for ($i = $limit_number_start; $i <= $limit_number_end; $i++){
					 	$set_active 	= 	($page == $i) ? 'class="active"' : '' ;
						$panel .= '<li '.$set_active.'><a href="'.get_the_permalink().$link_prefix.$i.$link_suffix.$per_page_filter_param.$filter_params.'">'.$i.'</a></li>';
						// if ($page == $i) $page_cur = '<option value="'.$link_prefix.$i.$link_suffix.'" selected>'.$i.'</option>';
						// else $page_cur = '<option value="'.$link_prefix.$i.$link_suffix.'">'.$i.'</option>';
					}


					// if()
					if( $limit_number_end != $current_pg_number ):
						$panel 	.= '<li class="next"><a href="'.get_the_permalink().$link_prefix.($page + 1).$link_suffix.$per_page_filter_param.$filter_params.'"><span></span></a></li>';
					endif;
			$panel 	.= '</ul>';	

	$panel = trim($panel);
	//Navigation arrows.
	/*if ($limit_number_start > 1) $panel = "<li><a href='$link_prefix".(1)."$link_suffix' class='pagination-first'>&nbsp;</a></li><li><a href='$link_prefix".($page - 1)."$link_suffix' class='pagination-previw'>&nbsp;</a></li> $panel";
	if ($limit_number_end < $num_pages) $panel = "$panel <li><a href='$link_prefix".($page + 1)."$link_suffix' class='pagination-next'>&nbsp;</a></li><li><a href='$link_prefix$num_pages$link_suffix' class='pagination-last'>&nbsp;</a></li>";*/

	$output['panel'] 	= $panel; //Panel HTML source.
	$output['offset'] 	= $page_offset; //Current page number.
	$output['limit'] 	= $limit_page; //Number of resuts per page.
	$output['array'] 	= array_slice($array, $page_offset, $limit_page, true); //Array of current page results.
	
	return $output;
}

// Numbered Pagination
if ( !function_exists( 'wpex_pagination' ) ) {
	
	function wpex_pagination() {
		
		$prev_arrow = is_rtl() ? 'Next' : 'Prev';
		$next_arrow = is_rtl() ? 'Prev' : 'Next';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );
		}
	}
	
}

/* breadcrumb */

function the_breadcrumb(){

    // Settings
    $breadcrums_id    = 'breadcrumb';
    $breadcrums_class = 'breadcrumb';
    $home_title       = 'Home';
	$breadcrumb_content = '';

    $breadcrumb_content .= '<ol class="' . $breadcrums_class . '" itemscope itemtype="https://schema.org/BreadcrumbList">';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy = 'product_cat';

    // Get the query & post information
    global $post, $wp_query;

    // Do not display on the homepage
    if (!is_front_page()) {


        // Home page
        $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '"><span itemprop="name">' . $home_title . '</span></a> <meta itemprop="position" content="1" /></li> ';

        if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . get_the_archive_title() . '</li> ';
        } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object  = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                // $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li> ';
            }

            $custom_tax_name = get_queried_object()->name;
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $custom_tax_name . '</li> ';
        } else if (is_single()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object  = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                // $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '"><span itemprop="name">' . $post_type_object->labels->name . '</span></a><meta itemprop="position" content="2" /></li>';
            }else{
				$blog_page = new WP_Query(array(
					'post_type' =>'page',
					'meta_key'  =>'_wp_page_template',
					'meta_value'=> 'pg-blog.php'
				));
				$blog_page_id = $blog_page->posts[0]->ID;
				$blog_page_link = get_the_permalink($blog_page_id);
				$blog_page_title = get_the_title($blog_page_id);
				$breadcrumb_content .= '<li><a href="'.$blog_page_link.'"><span>'.$blog_page_title.'</span></a></li>';
			}

            // Get post category info
            $category = get_the_category();

            if (!empty($category)) {
                $count_cat = count($category);
                // Get last category post is in
                if ($count_cat != 1) {
                    $tmp = array_values($category);
                    $last_category = end($tmp);
                } else {
                    $last_category = $category[0];
                }
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents     = explode(',', $get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				$g = 2;
                foreach ($cat_parents as $parents) {
                    if (!empty($parents)) {
                        $cat_display .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . str_replace("category/", "", $parents) . '<meta itemprop="position" content="'. $g .'" /></li>';
					}
					$g++;
                }
            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if (!empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
            }

            // Check if the post is in a category
            if (!empty($last_category)) {
                //$breadcrumb_content .= $cat_display;
                $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span></li>';

                // Else if post is in a custom taxonomy
            } else if (!empty($cat_id)) {

                $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '"><span itemprop="name">' . $cat_name . '</span></a></li>';
                $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span></li>';
            } else {

                $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span></li>';
            }
        } else if (is_category()) {

            // Category page
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . single_cat_title('', false) . '</span></li>';
        } else if (is_page()) {

            // Standard page
            if ($post->post_parent) {

                // If child page, get parents
                $anc = get_post_ancestors($post->ID);

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if (!isset($parents))
					$parents = null;
					$f = 2;
                foreach ($anc as $ancestor) {
                    $parents .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '"><span itemprop="name">' . get_the_title($ancestor) . '</span></a><meta itemprop="position" content="'. $f .'" /></li> ';
					$f++;
				}

                // Display parent pages
                $breadcrumb_content .= $parents;

                // Current page
                $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span><meta itemprop="position" content="'. $f .'" /></li>';
            } else {

                // Just display current page if not parents
                $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . get_the_title() . '</span><meta itemprop="position" content="2" /></li>';
            }
        } else if (is_tag()) {
            // Tag page
            // Get tag information
			$term_id       = get_query_var('tag_id');
            $taxonomy      = 'post_tag';
            $args          = 'include=' . $term_id;
            $terms         = get_terms(array('taxonomy' => 'post_tag', 'hide_empty' => false));
            $get_term_id   = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;

            // Display the tag name
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $get_term_name . '</li>';
        } elseif (is_day()) {

            // Day archive
            // Year link
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

            // Month link
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';

            // Day display
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">Archives</li>';
        } else if (is_month()) {

            // Month Archive
            // Year link
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

            // Month display
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
        } else if (is_year()) {

            // Display year archive
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">Archives</li>';
        } else if (is_author()) {

            // Auhor archive
            // Get the author information
            global $author;
            $userdata = get_userdata($author);

            // Display author name
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . 'Author: ' . $userdata->display_name . '</li>';
        } else if (get_query_var('paged')) {

            // Paginated archives
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . __('Page') . ' ' . get_query_var('paged') . '</span><meta itemprop="position" content="2" /></li>';
        } else if (is_search()) {

            // Search results page
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">Search results for: ' . get_search_query() . '</span><meta itemprop="position" content="2" /></li>';
        } elseif (is_404()) {

            // 404 page
            $breadcrumb_content .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . 'Error 404' . '</span><meta itemprop="position" content="2" /></li>';
        }
    }
    $breadcrumb_content .= '</ol>';

	return $breadcrumb_content;
}

if ( ! function_exists( 'antyracoresite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function antyracoresite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'antyracoresite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'antyracoresite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		//add_theme_support( 'post-thumbnails' );
		//set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'main_menu' => __( 'Main Menu', 'themesanjeevani' ),
				'footer_menu' => __( 'Footer Menu', 'themesanjeevani' )
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', 'antyracoresite_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function antyracoresite_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'antyracoresite' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'antyracoresite' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'antyracoresite_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */

function antyracoresite_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'antyracoresite_content_width', 640 );
}

add_action( 'after_setup_theme', 'antyracoresite_content_width', 0 );

// Sample ajax call function
function sample_ajax(){
	$get_month 		=	$_POST['data'];
	
	die();
}

add_action( 'wp_ajax_sample_ajax', 'sample_ajax' );
add_action( 'wp_ajax_nopriv_sample_ajax','sample_ajax' );

// Set ajax url
add_action('wp_head', 'set_ajaxurl');

function set_ajaxurl() {

   echo '<script type="text/javascript">
           var wpajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}


/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */


/* ACF option page enable */
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	/* Theme settings */
	acf_add_options_sub_page('Theme settings');
	acf_add_options_sub_page('Home page');
	acf_add_options_sub_page('Contact / Social');
	acf_add_options_sub_page('Footer');

	// /* Custom forms option page init */
	// acf_add_options_page(array(
	// 	'page_title' 	=> 'Contact forms',
	// 	'menu_title'	=> 'Contact forms',
	// 	'menu_slug' 	=> 'contact_forms',
	// 	'capability'	=> 'edit_posts',
	// 	'redirect'		=> false,
	// 	'icon_url' 		=>	'dashicons-admin-settings',
	// ));

	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Settings',
	// 	'menu_title'	=> 'Settings',
	// 	'parent_slug'	=> 'contact_forms',
	// ));
	
}

/*Set name for option page menu*/
if (function_exists('acf_set_options_page_menu')){
	acf_set_options_page_menu('Site options');
}


/* Remove Emoji Styles & Scripts */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');


// Remove type attribute from style and script link
add_filter('style_loader_tag', 'remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'remove_type_attr', 10, 2);

function remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

// Remove recent comments style
add_action('widgets_init', 'remove_recent_comments_style');

function remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}


// Change XML upload location.
function save_xml_sitemaps() {
	global $wpdb;
	// Set DB name
	$table_name 	=	$wpdb->prefix.'search_console';

	// get current user screen
	$screen = get_current_screen();

	if (strpos($screen->id, "acf-options") == true) {
		//retrieve file data
		$sitemap_xml 		= 	get_field( "sitemap_xml" , 'options' );
		$image_sitemap_xml 	= 	get_field( "image_sitemap_xml" , 'options' );
		$video_sitemap_xml 	= 	get_field( "video_sitemap_xml" , 'options' );

		// Search console file
		$search_console_file= 	get_field( "search_console_file" , 'options' );


		/* Get all the records form database */
		$get_searchcons 	= 	$wpdb->get_results("SELECT filename FROM ".$table_name."");
		
		if($get_searchcons):
			foreach($get_searchcons as $key => $sin_filename):
				$get_file_name 	=	$sin_filename->filename;
				if($get_file_name):
					/*Get current file path*/
					$get_filepath  	=	ABSPATH.$get_file_name;
					if($get_filepath):
						/*Delete other files form ROOT*/
						if(unlink($get_filepath)):
							$get_colid 	=	$sin_filename->id;
							// Remove unlink file from DB.
							$detele_row 	=	$wpdb->delete( $table_name, array( 'filename' => $get_file_name ) );
						endif;
					endif;
				endif;
			endforeach;
		endif;
		
		// search for previous files and remove

		if($sitemap_xml):
			// Sitemap
			read_xml_and_save_on_root($sitemap_xml , 'sitemap.xml');
		endif;

		if($image_sitemap_xml):
			// Image sitemap
			read_xml_and_save_on_root($image_sitemap_xml , 'image-sitemap.xml');
		endif;

		if($search_console_file):
			// Video sitemap
			read_xml_and_save_on_root($search_console_file['url'] , $search_console_file['filename']);	
			// Add to database to keep a track
			$insert_filename 	=	$wpdb->insert($table_name, array(
			   "filename" => $search_console_file['filename'],
			));
		endif;
	}
}

add_action('acf/save_post', 'save_xml_sitemaps', 20);

/* read xml and save on root*/
function read_xml_and_save_on_root($fileurl , $typeofxml){
	$filecontent = getContentByCurl($fileurl);
	// read and write
	$fp 		 = 	fopen(ABSPATH .  $typeofxml, 'w');
	if($filecontent):
		fwrite($fp,$filecontent);
	endif;
		fclose($fp);
	return;
}

/*Get file conetent by curl*/

function getContentByCurl($link=null){
	if($link):
		$url 			= $link;
		$ch 			= curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data 			= curl_exec($ch);
		curl_close($ch);
		if($data):
			return $data;
		endif;	
	endif;
}

/**
 * Remove Admin Menu Link from wp Admin
 */
add_action( 'wp_before_admin_bar_render', 'wpse200296_before_admin_bar_render' ); 

function wpse200296_before_admin_bar_render(){
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('customize');
}

add_action('admin_init', 'remove_customizer');

function remove_customizer () {
	remove_submenu_page( 'themes.php', 'widgets.php' ); //widgets
	remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2Fpost.php%3Fpost%3D6%26action%3Dedit' ); //customizer
	remove_menu_page( 'customize.php?return=%2Fwp-admin%2Fpost.php%3Fpost%3D6%26action%3Dedit' ); //customizer
	remove_menu_page( 'edit-comments.php' );  //Comments
}

/*Clean string - remove unwanted symble from string */
function clean($string) {
   $string = str_replace(' ', '', $string);
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

/*Remove unwanted body class*/
add_filter( 'body_class', 'wpse15850_body_class', 10, 2 );

function wpse15850_body_class( $wp_classes, $extra_classes ) {

    // List of the only WP generated classes allowed
    $whitelist = array( 'portfolio', 'home', 'error404' );

    // Filter the body classes
    $wp_classes = array_intersect( $wp_classes, $whitelist );

    // Add the extra classes back untouched
    return array_merge( $wp_classes, (array) $extra_classes );
}

function partition( $list, $p ) {
	$listlen = count( $list );
	$partlen = floor( $listlen / $p );
	$partrem = $listlen % $p;
	$partition = array();
	$mark = 0;
	for ($px = 0; $px < $p; $px++) {
		$incr = ($px < $partrem) ? $partlen + 1 : $partlen;
		$partition[$px] = array_slice( $list, $mark, $incr );
		$mark += $incr;
	}
	return $partition;
}

function get_temp_url($TEMPLATE_NAME){
    $url = '';

	$pages = new WP_Query(array(
		'post_type' =>'page',
		'meta_key'  =>'_wp_page_template',
		'meta_value'=> $TEMPLATE_NAME
	));
	
	if(isset($pages->posts[0])) {
	$url = get_the_permalink($pages->posts[0]->ID);
	}
	return $url;
}

function pagination_nav() {
    global $wp_query;
 
    if ( $wp_query->max_num_pages > 1 ) { ?>
        <nav class="pagination" role="navigation">
            <div class="nav-previous"><?php next_posts_link( '&larr; Older posts' ); ?></div>
            <div class="nav-next"><?php previous_posts_link( 'Newer posts &rarr;' ); ?></div>
        </nav>
	<?php }
}

// remove customizer from backend menu
function as_remove_menus () {
   remove_submenu_page( 'edit.php', 'edit-tags.php' ); //hide tags
   global $submenu;
   // Appearance Menu
   unset($submenu['themes.php'][6]); // Customize
}
add_action('admin_menu', 'as_remove_menus');


add_action('admin_head', 'custom_styles_backend');

function custom_styles_backend() {
  echo '<style>
  	a.customize{
  		display:none;
  	}

  </style>';
}

add_action('admin_head', 'acf_custom_styles');

function acf_custom_styles() {
	echo '<style>
		.acf-image-uploader .image-wrap img{
			max-width: 150px;
		} 
	</style>';
}

/**
 * Antyra core function
 */
require get_template_directory() . '/classes/class-core.php';

/**
 * Site related functions
 */

// Validate image URLs

function validateImage($width, $height, $image){
	$image_url = ( $image ) ? $image['url'] : 'https://via.placeholder.com/'.$width.'x'.$height;
	return $image_url;
}

// Validate image alt

function validateImageAlt($image){
	$image_alt = ( $image['alt'] ) ? $image['alt'] : get_the_title(get_the_ID());
	return $image_alt;
}

// Load post types

function loadPostTypes($type, $count, $orderby, $order, $catname){
	$post_result = get_posts(array(
		'post_type' => $type,
		'posts_per_page' => $count,
		'orderby' => $orderby,
		'order' => $order,
		'category_name' => $catname
	));

	return $post_result;
}

// Page speed

add_action('wp_enqueue_scripts', 'rudr_move_jquery_to_footer');  

function rudr_move_jquery_to_footer(){  
 	// unregister the jQuery at first
	wp_deregister_script('jquery');  
	// register to footer (the last function argument should be true)
	wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), false, null, true);  
	wp_enqueue_script('jquery');  
}

/*function to add preload to all scripts*/
function js_preload_attr($tag){
	//Add preload to all  scripts tags
	return str_replace( ' src', ' rel="preload" as="script" src', $tag );
}
add_filter( 'script_loader_tag', 'js_preload_attr', 10 );

function add_rel_preload($html, $handle, $href, $media){
	if (is_admin())
	return $html;

	$html = '<link rel="preload" href="'.$href.'" as="style" onload="this.rel=\'stylesheet\'">';

	return $html;
}

add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );

add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images' );
// This will remove the default image sizes and the medium_large size. 
function prefix_remove_default_images( $sizes ){
	unset( $sizes['small']); // 150px
	unset( $sizes['medium']); // 300px
	unset( $sizes['large']); // 1024px
	unset( $sizes['medium_large']); // 768px
	return $sizes;
}