<?php
	$footer_description = get_field( 'footer_description', 'option' );
	$newsletter_sc 		= get_field( 'newsletter_shortcode', 'option' );
	$copyright_text 	= get_field( 'copyright_text', 'option' );

	$company_name 		= get_field( 'company_name', 'option' );
	$company_address 	= get_field( 'company_address', 'option' );
	$telephone_1 		= get_field( 'telephone_1', 'option' );
	$telephone_2 		= get_field( 'telephone_2', 'option' );
	$email_address 		= get_field( 'email_address', 'option' );

	$social_facebook 	= get_field( 'social_facebook', 'option' );
	$social_youtube 	= get_field( 'social_youtube', 'option' );
	$social_insta 		= get_field( 'social_insta', 'option' );
	$social_twitter 	= get_field( 'social_twitter', 'option' );
?>

<footer>
	<div class="footer-desc">
		<?php echo $footer_description; ?>
	</div>
	<?php if ( $newsletter_sc ) : ?>
		<div class="newsletter">
			<?php echo do_shortcode($newsletter_sc); ?>
		</div>
	<?php endif; ?>
	<?php if ( $social_facebook || $social_youtube || $social_insta || $social_twitter ) : ?>
		<div class="footer-social">
			<ul class="social-links">
				<?php if ( $social_facebook ) : ?>	
					<li>
						<a href="<?php echo $social_facebook; ?>" target="_blank">
							<svg>
								<use xlink:href="#fb"></use>
							</svg>
						</a>
					</li>
				<?php endif; ?>
				<?php if ( $social_youtube ) : ?>
					<li>
						<a href="<?php echo $social_youtube; ?>" target="_blank">
							<svg>
								<use xlink:href="#ytb"></use>
							</svg>
						</a>
					</li>
				<?php endif; ?>
				<?php if ( $social_insta ) : ?>
					<li>
						<a href="<?php echo $social_insta; ?>" target="_blank">
							<svg>
								<use xlink:href="#insta"></use>
							</svg>
						</a>
					</li>
				<?php endif; ?>
				<?php if ( $social_twitter ) : ?>
					<li>
						<a href="<?php echo $social_twitter; ?>" target="_blank">
							<svg>
								<use xlink:href="#twt"></use>
							</svg>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>
	<div class="contact-details">
		<div class="company-name"><?php echo $company_name; ?></div>
		<?php if ( $company_address ) : ?>
			<address><?php echo $company_address; ?></address>
		<?php endif; ?>
		<?php if ( $telephone_1 ) : ?>
			<a href="tel:<?php echo $telephone_1; ?>" class="tel-1"><?php echo $telephone_1; ?></a>
		<?php endif; ?>
		<?php if ( $telephone_2 ) : ?>
			<a href="tel:<?php echo $telephone_2; ?>" class="tel-2"><?php echo $telephone_2; ?></a>
		<?php endif; ?>
		<?php if ( $email_address ) : ?>
			<a href="mailto:<?php echo $email_address; ?>" class="email"><?php echo $email_address; ?></a>
		<?php endif; ?>
	</div>
	<div class="footer-menu">
		<?php
			wp_nav_menu(array(
				'container' => '',
				'theme_location' => 'footer_menu'
			));
		?>
	</div>
	<div class="copyright-section">
		<div class="copyright"><?php echo $copyright_text; ?></div>
		<div class="author">Concept and Design By <a href="https://www.antyrasolutions.com" target="_blank">Antyra Solutions</a></div>
	</div>
</footer>

<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Antyra_Core_Site
 * @since 1.0.0
 */
// Call to main class
$core_data 	=	new antyra_core();
/*
$contdetails 	=	$core_data->get_contact_info();
$socialdetails 	=	$core_data->get_social_data();
$footer_logo 	=	get_field('footer_logo', 'option');
$footer_logo 	= 	($footer_logo) ? $footer_logo : '//via.placeholder.com/260x100' ;
*/
?>

<?php 
  	// Call to SVG icons file
	include dirname(__FILE__) . '/inc/svg-compact.php';
	wp_footer();
	
	$core_data->get_schema("footer");
	$core_data->set_gtm_data("footer");

?>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts-libs.js?ver=<?php echo $GLOBALS['version']; ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js?ver=<?php echo $GLOBALS['version']; ?>"></script>

<script>
	// Google font loading functionality
	WebFontConfig = {
			google: { families: ['Hind+Guntur:500,600,700'] }
		};
		(function() {
			var wf = document.createElement('script');
			wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
	})();

	var get_windowwidth	=	$(window).width();
	var directory		=	'<?php echo get_template_directory_uri(); ?>';
	

	refresh_handler = function(e) {
	    var elements = document.querySelectorAll("*[data-src]");
	    for (var i = 0; i < elements.length; i++) {
			var elementType = elements[i].localName;
            var boundingClientRect = elements[i].getBoundingClientRect();
            if (elements[i].hasAttribute("data-src") && boundingClientRect.top < window.innerHeight) {
                if (elementType == 'img'){
					elements[i].setAttribute("src", elements[i].getAttribute("data-src"));
				}else{
					elements[i].setAttribute("srcset", elements[i].getAttribute("data-src"));
				}
                elements[i].removeAttribute("data-src");
            }
		}
    };

    window.addEventListener('scroll', refresh_handler);
    window.addEventListener('load', refresh_handler);
    window.addEventListener('resize', refresh_handler);
    window.addEventListener('load', function() {
		pageRelatedCss('https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css?ver=5.2.2');
		
		// pageRelatedCss(directory+'/sass/footer/footer.min.css');
	})
	if(get_windowwidth < 1200){
		document.addEventListener("DOMContentLoaded", function(event) {
		    var lazyImages = [].slice.call(
		        document.querySelectorAll(".lazy > source")
		    )

	    if ("IntersectionObserver" in window && 'IntersectionObserverEntry' in window) {
	        let lazyImageObserver =
	            new IntersectionObserver(function(entries, observer) {
	                entries.forEach(function(entry) {
	                    if (entry.isIntersecting) {
	                        let lazyImage = entry.target;
	                        lazyImage.srcset = lazyImage.dataset.srcset;
	                        lazyImage.nextElementSibling.srcset = lazyImage.dataset.srcset;
	                        lazyImage.nextElementSibling.classList.add('fade-in');
	                        lazyImage.parentElement.classList.remove("lazy");
	                        lazyImageObserver.unobserve(lazyImage);
	                    }
	                });
	            });

	        lazyImages.forEach(function(lazyImage) {
	            lazyImageObserver.observe(lazyImage);
	        });
	    } else {

	        // Not supported, load all images immediately
	        let active = false;

	        const lazyLoad = function() {
	            if (active === false) {
	                active = true;
	                setTimeout(function() {
	                    lazyImages.forEach(function(lazyImage) {
	                        if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
	                            lazyImage.srcset = lazyImage.dataset.srcset;
	                            lazyImage.nextElementSibling.src = lazyImage.dataset.srcset;
	                            lazyImage.nextElementSibling.classList.add('fade-in');
	                            lazyImage.parentElement.classList.remove("lazy");

	                            lazyImages = lazyImages.filter(function(image) {
	                                return image !== lazyImage;
	                            });

	                            if (lazyImages.length === 0) {
	                                document.removeEventListener("scroll", lazyLoad);
	                                window.removeEventListener("resize", lazyLoad);
	                                window.removeEventListener("orientationchange", lazyLoad);
	                            }
	                        }
	                    });

	                    active = false;
	                }, 200);
	            }
	        };

	        document.addEventListener("scroll", lazyLoad);
	        window.addEventListener("resize", lazyLoad);
	        window.addEventListener("orientationchange", lazyLoad);
	    }

	});
	}

	

	// Defer image load function
	function initImgFunction() {
		var imgDefer = document.getElementsByTagName('img');

		for (var i=0; i<imgDefer.length; i++) {
			if(imgDefer[i].getAttribute('data-src')) {
				imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
			} 
		} 
	}

	// Page related css load function
	function pageRelatedCss(filename){
		// Create new link Element 
		var link = document.createElement('link');  
	
		// set the attributes for link element 
		link.rel = 'stylesheet';  
	
		link.type = 'text/css'; 
	
		link.href = filename;  

		// Get HTML head element to append  

		// link element to it  
		document.getElementsByTagName('HEAD')[0].appendChild(link);  
	}
</script>

</body>
</html>
