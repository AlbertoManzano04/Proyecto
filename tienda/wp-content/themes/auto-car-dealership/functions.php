<?php
/**
 * Auto Car Dealership functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Auto Car Dealership
 */

if ( ! defined( 'AUTO_CAR_DEALERSHIP_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'AUTO_CAR_DEALERSHIP_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'auto_car_dealership_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function auto_car_dealership_setup() {

		load_theme_textdomain( 'auto-car-dealership', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'woocommerce' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		//add_editor_style( 'style.css' );

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 192,
				'width'       => 192,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Experimental support for adding blocks inside nav menus
		add_theme_support( 'block-nav-menus' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Register nav menus.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'auto-car-dealership' ),
			)
		);
		
	// Theme Activation Notice
	global $pagenow;

	if (is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] )) {
		add_action('admin_notices', 'auto_car_dealership_activation_notice');
	}
 
	}
endif;
add_action( 'after_setup_theme', 'auto_car_dealership_setup' );

// Notice after Theme Activation
function auto_car_dealership_activation_notice() {
	echo '<div class="notice notice-success is-dismissible welcome-notice">';
	echo '<p>'. esc_html__( 'Thank you for choosing Auto Car Dealership. Would like to have you on our Welcome page so that you can reap all the benefits of our Auto Car Dealership.', 'auto-car-dealership' ) .'</p>';
	echo '<span><a href="'. esc_url( admin_url( 'themes.php?page=auto-car-dealership-info' ) ) .'" class="button button-primary">'. esc_html__( 'GET STARTED', 'auto-car-dealership' ) .'</a></span>';
	echo '<span class="demo-btn"><a href="'. esc_url( 'https://www.vwthemes.net/auto-car-dealership/' ) .'" class="button button-primary" target=_blank>'. esc_html__( 'VIEW DEMO', 'auto-car-dealership' ) .'</a></span>';
	echo '<span class="upgrade-btn"><a href="'. esc_url( 'https://www.vwthemes.com/products/car-wordpress-theme' ) .'" class="button button-primary" target=_blank>'. esc_html__( 'UPGRADE PRO', 'auto-car-dealership' ) .'</a></span>';
	echo '<span class="bundle-btn"><a href="'. esc_url( 'https://www.vwthemes.com/products/wp-theme-bundle' ) .'" class="button button-primary" target=_blank>'. esc_html__( 'THEME BUNDLE', 'auto-car-dealership' ) .'</a></span>';
	echo '</div>';
}

if ( ! function_exists( 'auto_car_dealership_fonts_url' ) ) :
	/**
	 * Register Google fonts for Auto Car Dealership
	 *
	 * Create your own auto_car_dealership_fonts_url() function to override in a child theme.
	 *
	 * @since 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function auto_car_dealership_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Poppins, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$poppins = _x( 'on', 'Poppins font: on or off', 'auto-car-dealership' );

		if ( 'off' !== $poppins ) {
			$font_families = array();
			$font_families[] = 'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
			$font_families[] = 'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';

			$query_args = array(
				'family' => implode( '&family=', $font_families ), //urlencode( implode( '|', $font_families ) ),
				// 'subset' => urlencode( 'latin,latin-ext' ),
				'display' => 'swap',
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );
		}

		if ( ! class_exists( 'WPTT_WebFont_Loader' ) ) {
			// Load Google fonts from Local.
			require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
		}

		return esc_url( wptt_get_webfont_url( $fonts_url ) );
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function auto_car_dealership_scripts() {
	wp_enqueue_style('auto-car-dealership-font', auto_car_dealership_fonts_url(), array());
	wp_enqueue_style('auto-car-dealership-style', get_stylesheet_uri(), array() );
	if (get_theme_mod('auto_car_dealership_animation', true) == true){
		wp_enqueue_script( 'auto-car-dealership-jquery-wow', esc_url(get_template_directory_uri()) . '/js/wow.js', array('jquery') );
		wp_enqueue_style( 'auto-car-dealership-animate-css', esc_url(get_template_directory_uri()).'/css/animate.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'auto_car_dealership_scripts' );


add_action( 'admin_enqueue_scripts', function( $hook ) {
  // if ( 'user-edit.php' == $hook ) {
    wp_enqueue_script(
      'auto_car_dealership',get_template_directory_uri() . '/js/custom-admin.js',array('jquery'),'',true);
  // }
} );

/**
 * Enqueue block editor style
 */
function auto_car_dealership_block_editor_styles() {
	wp_enqueue_style( 'auto-car-dealership-block-patterns-style-editor', get_theme_file_uri( '/css/block-editor.css' ), false, '1.0', 'all' );
	wp_enqueue_style('auto-car-dealership-font', auto_car_dealership_fonts_url(), array());
}
add_action( 'enqueue_block_editor_assets', 'auto_car_dealership_block_editor_styles' );



if ( ! function_exists( 'auto_car_dealership_switch_sanitization' ) ) {
	function auto_car_dealership_switch_sanitization( $input ) {
		if ( true === $input ) {
			return 1;
		} else {
			return 0;
		}
	}
}

function auto_car_dealership_init_setup() {
	/* Load Jetpack compatibility file. */
	require get_template_directory() . '/inc/customizer.php';

	// Add block patterns
	require get_template_directory() . '/inc/block-patterns.php';

	/**
	 * Load core file.
	 */
	require_once get_template_directory() . '/inc/core/theme-info.php';
	require_once get_template_directory() . '/inc/core/template-functions.php';

	/**
	 * TGM
	 */
	require_once get_template_directory() . '/inc/tgm/tgm.php';

	/**
	 * Section Pro
	 */
	require get_template_directory() . '/inc/section-pro/customizer.php';

	define('AUTO_CAR_DEALERSHIP_BUY_NOW',__('https://www.vwthemes.com/products/car-wordpress-theme','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_SUPPORT',__('https://wordpress.org/support/theme/auto-car-dealership/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_REVIEW',__('https://wordpress.org/support/theme/auto-car-dealership/reviews/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_LIVE_DEMO',__('https://www.vwthemes.net/auto-car-dealership/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_PRO_DOC',__('https://preview.vwthemesdemo.com/docs/vw-automobile-pro/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_FREE_DOC',__('https://preview.vwthemesdemo.com/docs/free-auto-car-dealership/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_FAQ',__('https://www.vwthemes.com/faqs/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_CONTACT',__('https://www.vwthemes.com/contact/','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_THEME_BUNDLE_BUY_NOW',__('https://www.vwthemes.com/products/wp-theme-bundle','auto-car-dealership'));
	define('AUTO_CAR_DEALERSHIP_THEME_BUNDLE_DOC',__('https://preview.vwthemesdemo.com/docs/theme-bundle/','auto-car-dealership'));

}
add_action( 'after_setup_theme', 'auto_car_dealership_init_setup' );


/* Here you trigger the ajax handler function using jQuery */

add_action( 'admin_footer', 'cache_purge_action_js' );

function cache_purge_action_js() { ?>
  <script type="text/javascript" >
     jQuery("li#wp-admin-bar-cache-purge .ab-item").on( "click", function() {
        var data = {
                      'action': 'example_cache_purge',
                    };

        /* since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php */
        jQuery.post(ajaxurl, data, function(response) {
           alert( response );
        });

      });
  </script> <?php
}

/* Here you hook and define ajax handler function */

add_action( 'wp_ajax_example_cache_purge', 'example_cache_purge_callback' );

function example_cache_purge_callback() {
    global $wpdb; /* this is how you get access to the database */
    /* You cache purge logic should go here. */
    $response = "Cache Purged !";
    echo $response;
    wp_die(); /* this is required to terminate immediately and return a proper response */
}
?>
