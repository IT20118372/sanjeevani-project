<?php
/**
 * All the core functions
 * Meta data = get_meta_data()
 * 
 */

class antyra_core{
	function __construct(){
		# code...
	}

	/**
	 * Generate all the SEO related data
	 *
	 * @package get_meta_data
	 * @subpackage Antyra_Core
	 * @since 1.0.0
	*/

	public function get_meta_data(){
		global $post;
		
		/* All the SEO needed data will generate here */
		$seo_data 	=	get_field('seo_data', $post->ID);

		/* SEO verification meta */
		$google_search_console 		=	get_field('google_search_console', 'option');
		$bing_webmaster_tools 		=	get_field('bing_webmaster_tools', 'option');
		$pinterest_verification 	=	get_field('pinterest_verification', 'option');

		if(is_category()):
			$term = get_queried_object();
			$seo_data = get_field('seo_data',$term);
		endif;

		if($seo_data):
			$get_siteinfor 		=	get_bloginfo('description');
			$seo_title 	 		=	$seo_data['seo_title'];
			$seo_meta_desc 	 	=	$seo_data['seo_meta_desc'];
			$seo_meta_key 	 	=	$seo_data['seo_meta_key'];

			$set_title 			= 	($seo_title) ? $seo_title : $post->post_title ;
			$set_descrip 		= 	($seo_meta_desc) ? $seo_meta_desc : $get_siteinfor ;

			

			$og_title 			=	$seo_data['og_title'];
			$og_desc 			=	$seo_data['og_description'];
			$og_image 			=	$seo_data['og_image'];

			$seo_noindex 		=	$seo_data['seo_noindex'];
			$seo_nofollow 		=	$seo_data['seo_nofollow'];

			$seo_canonical_link =	$seo_data['seo_canonical_link'];

			if($seo_noindex && $seo_nofollow):
				$robot_meta 	=	'noindex,nofollow';
			elseif($seo_noindex == false && $seo_nofollow):
				$robot_meta 	=	'index,nofollow';
			elseif($seo_noindex && $seo_nofollow  == false):
				$robot_meta 	=	'noindex,follow';
			elseif($seo_noindex == false && $seo_nofollow  == false):
				$robot_meta 	=	false;
			endif;

			$seo_nofollow 		= 	($seo_noindex == false && $seo_nofollow) ? 'nofollow' : '' ;

			$og_title 			= 	($og_title) ? $og_title : $set_title;
			$og_desc 			= 	($og_desc) ? $og_desc : $set_descrip;
			$og_image 			= 	($og_image) ? $og_image : get_template_directory_uri().'/images/core/seo-def-img.jpg';
			?>
				<title><?php echo my_custom_title($set_title); ?></title>

				<?php if ($robot_meta): ?>
				<meta name="robots" content="<?php echo $robot_meta; ?>">
				<meta name="googlebot" content="<?php echo $robot_meta; ?>">
				<?php endif; ?>
				<meta name="description" content="<?php echo $set_descrip; ?>"/>
  				<meta name="keywords" content="<?php echo $seo_meta_key; ?>">
  				<!-- <meta name="author" content=""> -->
				<meta property="og:title" content="<?php echo $og_title; ?>" />
				<meta property="og:type" content="website" />
				<meta property="og:url" content="<?php echo get_the_permalink( $post->ID ); ?>" />
				<meta property="og:image" content="<?php echo $og_image; ?>" />
				<meta property="og:site_name" content="<?php echo $set_title; ?>" />
				<meta property="og:description" content="<?php echo $og_desc; ?>" />
				<meta name="twitter:card" content="summary" />
				<meta name="twitter:title" content="<?php echo $og_title; ?>" />
				<meta name="twitter:description" content="<?php echo $og_desc; ?>" />
				<meta name="twitter:image" content="<?php echo $og_image; ?>" />
				<meta itemprop="image" content="<?php echo $og_image; ?>" />
				<?php if ($seo_canonical_link): ?>
					<link rel="canonical" href="<?php echo $seo_canonical_link; ?>" />
				<?php endif ?>
			<?php
		else:
			$this->show_messages("SEO meta data is missing. please update.");
		endif;

		if ($google_search_console):
			echo $google_search_console;
		endif;
		if ($bing_webmaster_tools):
			echo $bing_webmaster_tools;
		endif;
		if ($pinterest_verification):
			echo $pinterest_verification;
		endif;
	}

	public function show_messages($msg=null){
		if(is_user_logged_in()):
			$set_msg 	=	"<div class='alert alert-info'>".$msg."<br>This message only visible for log in users</div>";
		endif;

		return $set_msg;
	}

	/**
     * @access public
     * @uses get favicon URL
     * @since 1.0
     */
	public function get_favicon(){
		$get_favic 	=	get_field('site_favicon', 'option');

		if($get_favic):
			$return_url		=	$get_favic;
		else:
			$return_url		=	get_template_directory_uri().'/favicon.ico';
		endif;

		return $return_url;
	}

	/**
     * @access public
     * @uses validate URL
     * @since 1.0
     */
	public function check_valid_url($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	/**
     * @access public
     * @uses GTM Tags
     * @since 1.0
     */
	public function set_gtm_data($positi=null){
		$rep_verify		=	get_field('rep_verify', 'option');
		if($rep_verify):
			foreach ($rep_verify as $key => $sin_gtm):
				$comment 	=	$sin_gtm['comment'];
				$script 	=	$sin_gtm['script'];
				$position 	=	strtolower($sin_gtm['position']);
				if($script && $position):
					if($position == $positi):
						echo '<!-- '.$comment.' -->'.$script.'<!-- End '.$comment.' -->';
					endif;
				endif;
			endforeach;
		endif;
	}


	/**
     * @access public
     * @uses Generate schema data
     * @since 1.0
     */

	public function get_schema($get_position=null){
		global $post;
		$seo_data 			=	get_field('seo_data', $post->ID);
		if($seo_data):
			$checkenable 			=	$seo_data['en_schema'];
			if($checkenable):
				$schema_code		=	$seo_data['schema_code'];
				$sch_position		=	$seo_data['sch_position'];

				if($schema_code && $sch_position):
					if($get_position == $sch_position):
						echo $schema_code; 
					endif;
				endif;
			endif;
		endif;
	}

	/**
     * @access public
     * @uses Contact informations
     * @since 1.0
     */

	public function get_contact_info(){
		$contargs 	=	array();
		/* Get contact information from back-end */
		$contact_name 					=	get_field('contact_name', 'option');
		
		$contargs['contact_name']		=	$contact_name;

		/* address group data */
		$con_address 					=	get_field('con_address', 'option');
		if($con_address):
			$contargs['address']['line_1'] 		=	$con_address['ad_line1'];
			$contargs['address']['line_2'] 		=	$con_address['ad_line2'];
			$contargs['address']['line_3'] 		=	$con_address['ad_line3'];
			$contargs['address']['country'] 	=	$con_address['country'];
		endif;

		/* Emails list */
		$email_rep 					=	get_field('email_rep', 'option');
		$emails_args 				=	array();
		if($email_rep):
			foreach ($email_rep as $key => $sin_email):
				$emails_args[$key] 	=	$sin_email['email_address'];
			endforeach;
		endif;

		/* Telephone list */
		$telephone_rep 				=	get_field('telephone_rep', 'option');
		$tels_args 					=	array();
		if($telephone_rep):
			foreach ($telephone_rep as $key => $sin_tel):
				$tels_args[$key] 	=	$sin_tel['telephone_number'];
			endforeach;
		endif;

		/* Mobile list */
		$mobile_rep 				=	get_field('mobile_rep', 'option');
		$mobiles_args 				=	array();
		if($mobile_rep):
			foreach ($mobile_rep as $key => $sin_mobiles):
				$mobiles_args[$key]	=	$sin_mobiles['mobile_number'];
			endforeach;
		endif;

		/* Location coordinates */
		$loc_coordi 				=	get_field('coordinates', 'option');
		$loc_arg 					=	array();
		if($loc_coordi):
			$explode_item 			=	explode(',',$loc_coordi);
			$loc_arg['lati']		=	floatval($explode_item[0]);
			$loc_arg['long']		=	floatval($explode_item[1]);
		endif;

		$contargs['emails']			=	$emails_args;
		$contargs['tels']			=	$tels_args;
		$contargs['mobiles']		=	$mobiles_args;
		$contargs['coordinates']	=	$loc_arg;

		return $contargs;
	}

	/**
     * @access public
     * @uses Social links data
     * @since 1.0
     */

	public function get_social_data(){
		$output_args 	=		array();
		$social_group 	= 		get_field('social_group', 'option');

		if($social_group):
			$sme_fd 		= 		$social_group['sme_fb'];
			$sme_tw 		= 		$social_group['sme_tw'];
			$sme_insta 		= 		$social_group['sme_insta'];
			$sme_ytb 		= 		$social_group['sme_ytb'];
			$sme_link 		= 		$social_group['sme_link'];

			$output_args['facebook'] 		=	$sme_fd;
			$output_args['twitter'] 		=	$sme_tw;
			$output_args['instagram'] 		=	$sme_insta;
			$output_args['youtube'] 		=	$sme_ytb;
			$output_args['linkedln'] 		=	$sme_link;
		endif;


		return $output_args;
	}


	/**
     * @access public
     * @uses Breadcrumb
     * @since 1.0
     */

	public function breadcrumb( $param=null ){
		global $post;

		$main_hm_name = '';

		$home_url   = home_url()."/";
		$network_home_url = network_home_url();

		$child_1 = $child_2 = $child_3 = '';
			$post = (object) $post;
		$parent_array = get_post_ancestors($post->ID);

		if(sizeof($parent_array)==1):
			$child_1 = $parent_array[0];
		endif;

		if(sizeof($parent_array)==2):
			$child_1 = $parent_array[0];
			$child_2 = $parent_array[1];
		endif;

		if(sizeof($parent_array)==3):
			$child_1 = $parent_array[0];
			$child_2 = $parent_array[1];
			$child_3 = $parent_array[2];
		endif;

		if(empty($parent_array)):
			$child_0 = 0;
		endif;

		if(sizeof($parent_array)==3) {
			$output  = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.get_permalink($child_3).'">'.get_the_title($child_3).'</a><meta itemprop="position" content="1" /></li>';
			$output .= '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.get_permalink($child_2).'">'.get_the_title($child_2).'</a><meta itemprop="position" content="2" /></li>';
			$output .= '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.get_permalink($child_1).'">'.get_the_title($child_1).'</a><meta itemprop="position" content="3" /></li>';
			$output .= '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item">'.get_the_title($post->ID).'<meta itemprop="position" content="4" /></li>';
		}

		if(sizeof($parent_array)==2) {
			$output  = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.get_permalink($child_2).'">'.get_the_title($child_2).'</a><meta itemprop="position" content="1" /></li>';
			$output .= '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.get_permalink($child_1).'">'.get_the_title($child_1).'</a><meta itemprop="position" content="2" /></li>';
			$pid = ( $post->ID=='' )?$post['ID']:$post->ID;
			$output .= '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item">'.get_the_title($pid).'<meta itemprop="position" content="3" /></li>';
		}

		if(sizeof($parent_array)==1) {
			$output  = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.get_permalink($child_1).'">'.get_the_title($child_1).'</a><meta itemprop="position" content="1" /></li>';
			$pid = ( $post->ID=='' )?$post['ID']:$post->ID;
			$output .= '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item">'.get_the_title($pid).'<meta itemprop="position" content="2" /></li>';
		}

		if( ($child_1==0)&&($child_2==0)&&($child_3==0)) { 
			$pid = ( $post->ID=='' )?$post['ID']:$post->ID;
			$output = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item">'.get_the_title($pid).'<meta itemprop="position" content="1" /></li>';
		}

		if ($home_url==$network_home_url){
			$output = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.network_home_url().'" title="'.get_bloginfo().'" class="bolds">Home</a><meta itemprop="position" content="1" /></li>'.$output;  
		}else{

			if (is_home() || is_front_page()){
				$output = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.network_home_url().'" title="'.get_bloginfo("name").'" class="bolds">'.get_bloginfo("name").'</a><meta itemprop="position" content="1" /></li><li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a href="'.$home_url.'" title="'.get_bloginfo("name").'">'.get_bloginfo("name").'</a><meta itemprop="position" content="2" /></li>'.$output;
			}else{ 
				$output ='<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.$home_url.'" title="'.get_bloginfo("name").'">Home</a><meta itemprop="position" content="1" /></li>'.$output;
			}
		}

		if( is_404() ):
			$output = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a  class="focuson" href="'.network_home_url().'" title="'.get_bloginfo().'" class="bolds">Home</a>Page not found<meta itemprop="position" content="1" /></li>';
		elseif( is_search() ):
			$output = '<li itemprop="itemListElement" itemscope itemprop="name" itemtype="https://schema.org/ListItem" class="item"><a class="focuson" href="'.network_home_url().'" title="'.get_bloginfo().'" class="bolds">Home</a>Search Result<meta itemprop="position" content="1" /></li>';
		endif;

		return '<ol class="bredcrumbs" itemscope itemprop="name" itemtype="https://schema.org/BreadcrumbList">' . $output . '</ol>';

		return $output;
		
	}
}

?>