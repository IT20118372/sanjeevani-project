<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Antyra_Core_Site
 * @since 1.0.0
 */
// Call to main class
$core_data 	=	new antyra_core();
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<link rel="shortcut icon" href="<?php echo $core_data->get_favicon(); ?>">
	<link rel="icon" href="<?php echo $core_data->get_favicon(); ?>" type="image/x-icon">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;700&display=swap" rel="stylesheet">

	<!-- <style><?php include dirname(__FILE__) . '/sass/header/site-header.min.css'; ?> </style> -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/sass/header/site-header.min.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/sass/footer/footer.min.css">

	<?php if (is_front_page()): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/sass/home.min.css">
	<?php else: ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/sass/style.min.css">
	<?php endif ?>

	<?php wp_head(); ?>
	<?php $core_data->get_meta_data(); ?>

	<!-- Page schema data -->
	<?php $core_data->get_schema("header"); ?>
	<?php $core_data->set_gtm_data("header"); ?>
</head>

<body <?php body_class(); ?>>
<!-- page schema code after body -->
<?php $core_data->get_schema("body"); ?>
<?php $core_data->set_gtm_data("body"); ?>

<?php
	if ( !is_front_page() ){
		$mainheader_rep = get_field('main_header_images', get_the_ID());
		$banner_class = ( !$mainheader_rep ) ? 'no-banner' : '';
	}else{
		$mainheader_rep = get_field('mainheader_rep', 'option');
	}
	$main_logo = get_field('main_logo', 'option');
	$first_slide = '';
	$rest_of_slide = '';

	if ( $mainheader_rep ){
		foreach ( $mainheader_rep as $key => $item ){
			$mobile_image = validateImage(800, 850, $item['mobile_image']);
			$tablet_image = validateImage(1200, 850, $item['tablet_image']);
			$desktop_image = validateImage(1920, 1000, $item['desktop_image']);
			$image_alt	= validateImageAlt($item['desktop_image']);
			$title_text = $item['title_text'];
			$link1 = '';
			if ( $item['link'] != '' ){
				$link1 = '<a href="'.$item['link'].'" class="">'.$item['link_text'].'</a>';
			}
	
			if ( $key == 0 ){
				$first_slide .= '
				<div class="item">
					<picture>
						<source media="(max-width:991px)" srcset="'.$mobile_image.'">
						<source media="(max-width:1199px)" srcset="'.$tablet_image.'">
						<img src="'.$desktop_image.'" alt="'.$image_alt.'">
					</picture>
					<div class="slider-text">'.$title_text.'</div>
					<div class="slider-links">'.$link1.'</div>
				</div>
				';
			}else{
				$rest_of_slide .= '
				<div class="item">
					<picture>
						<source media="(max-width:991px)" srcset="'.$mobile_image.'">
						<source media="(max-width:1199px)" srcset="'.$tablet_image.'">
						<img src="'.$desktop_image.'" alt="'.$image_alt.'">
					</picture>
					<div class="slider-text">'.$title_text.'</div>
					<div class="slider-links">'.$link1.'</div>
				</div>
				';
			}
		}
	}
?>

<?php $nav_class = ( is_front_page() ) ? 'home-page' : 'inner-page'; ?>
<header>
	<div class="navigation <?php echo $nav_class.' '.$banner_class; ?>">
		<a href="<?php echo get_site_url(); ?>" class="site-logo">
			<img src="<?php echo get_field('main_logo', 'option')['url']; ?>" alt="<?php echo get_field('main_logo', 'option')['alt']; ?>">
		</a>
		<input id="main-menu-state" type="checkbox" />
		<label class="main-menu-btn" for="main-menu-state">
			<span class="main-menu-btn-icon"></span>
		</label>
		<?php
			wp_nav_menu(array(
				'menu_class' => 'sm sm-simple',
				'menu_id' => 'main-menu',
				'container' => '',
				'theme_location' => 'main_menu'
			));
		?>
	</div>
</header>

<script>
	var rest_of_slide = <?php echo json_encode($rest_of_slide); ?>;
</script>