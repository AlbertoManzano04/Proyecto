<?php
/**
 * Add theme page
 */

function auto_car_dealership_menu() {
	add_theme_page( esc_html__( 'Auto Car Dealership', 'auto-car-dealership' ), esc_html__( 'Automobile Theme', 'auto-car-dealership' ), 'edit_theme_options', 'auto-car-dealership-info', 'auto_car_dealership_theme_page_display' );
}
add_action( 'admin_menu', 'auto_car_dealership_menu' );

function auto_car_dealership_admin_theme_style() {
	wp_enqueue_style('auto-car-dealership-custom-admin-style', esc_url(get_template_directory_uri()) . '/css/admin-style.css');
	wp_enqueue_script('auto-car-dealership-tabs', esc_url(get_template_directory_uri()) . '/js/tab.js');
}
add_action('admin_enqueue_scripts', 'auto_car_dealership_admin_theme_style');

/**
 * Display About page
 */
function auto_car_dealership_theme_page_display() {
	$theme = wp_get_theme();

	if ( is_child_theme() ) {
		$theme = wp_get_theme()->parent();
	} ?>
 
	<div class="wrapper-info">
	    <div class="col-left sshot-section">
	    	<h2><?php esc_html_e( 'Welcome to Auto Car Dealership Theme', 'auto-car-dealership' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
	    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','auto-car-dealership'); ?></p>
	    </div>
	    <div class="col-right coupen-section">
			<div class="logo-section">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
			</div>
			<div class="logo-right">			
				<div class="update-now">
					<h4><?php esc_html_e('Try Premium ','auto-car-dealership'); ?></h4>
					<h4><?php esc_html_e('Auto Car Dealership Theme','auto-car-dealership'); ?></h4>
					<h4 class="disc-text"><?php esc_html_e('at 20% Discount','auto-car-dealership'); ?></h4>
					<h4><?php esc_html_e('Use Coupon','auto-car-dealership'); ?> ( <span><?php esc_html_e('vwpro20','auto-car-dealership'); ?></span> ) </h4> 
					<div class="info-link">
						<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'Upgrade to Pro', 'auto-car-dealership' ); ?></a>
					</div>
				</div>
			</div>   
			<div class="logo-img">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/final-logo.png" alt="" />
			</div>	
	    </div>

	

	    <div class="tab-sec">
			<div class="tab">
				<button class="tablinks" onclick="auto_car_dealership_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Free Setup', 'auto-car-dealership' ); ?></button>
			  	<button class="tablinks" onclick="auto_car_dealership_open_tab(event, 'pro_theme')"><?php esc_html_e( 'Get Premium', 'auto-car-dealership' ); ?></button>
			  	<button class="tablinks" onclick="auto_car_dealership_open_tab(event, 'free_pro')"><?php esc_html_e( 'Free Vs Premium', 'auto-car-dealership' ); ?></button>
			  	<button class="tablinks" onclick="auto_car_dealership_open_tab(event, 'get_bundle')"><?php esc_html_e( 'Get 250+ Themes Bundle at $99', 'auto-car-dealership' ); ?></button>
			</div>

			<div id="lite_theme" class="tabcontent open">
				<div class="lite-theme-tab">
					<h3><?php esc_html_e( 'Lite Theme Information', 'auto-car-dealership' ); ?></h3>
					<hr class="h3hr">
				  	<p><?php esc_html_e('Auto Car Dealership is a spectacular block based theme for websites designed for car and automobile businesses, car rentals, automotive and car dealerships, auto dealers, car listings, electric cars and vehicles, auto part shops, car repair services, etc. This theme is loaded with full site editing features, block patterns, block editor patterns and much more. Crafted by WordPress experts, this theme makes use of lightweight design and the latest HTML codes that are further optimized to give you a faster page load speed. The overall look is elegant and at the same time professional to represent your business in a very presentable manner. This theme is retina-ready and has a responsive design that makes it work well across any device. There is a beautifully designed banner and many sections for displaying information about your Team, showing the client Testimonials, and more. There are plenty of customization options available for you to tweak the design and add your own flavor. To make the design SEO-friendly, developers have implemented the best coding practices so that you don’t need to take extra effort. Call to Action Button (CTA) will ensure that your visitors will get the proper guidance for the next step. There are many social media options available for your website and the theme is also made translation-ready to support multiple languages.','auto-car-dealership'); ?></p>
				  	<div class="col-left-inner">
						<div class="pro-links">
					    	<a href="<?php echo esc_url( admin_url() . 'site-editor.php' ); ?>" target="_blank"><?php esc_html_e('Edit Your Site', 'auto-car-dealership'); ?></a>
							<a href="<?php echo esc_url( home_url() ); ?>" target="_blank"><?php esc_html_e('Visit Your Site', 'auto-car-dealership'); ?></a>
						</div>
						<div class="support-forum-col-section">
							<div class="support-forum-col">
								<h4><?php esc_html_e('Having Trouble, Need Support?', 'auto-car-dealership'); ?></h4>
								<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'auto-car-dealership'); ?></p>
								<div class="info-link">
									<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'auto-car-dealership'); ?></a>
								</div>
							</div>
							<div class="support-forum-col">
								<h4><?php esc_html_e('Reviews & Testimonials', 'auto-car-dealership'); ?></h4>
								<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'auto-car-dealership'); ?>  </p>
								<div class="info-link">
									<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'auto-car-dealership'); ?></a>
								</div>
							</div>
							<div class="support-forum-col">
								<h4><?php esc_html_e('Theme Documentation', 'auto-car-dealership'); ?></h4>
								<p> <?php esc_html_e('If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'auto-car-dealership'); ?>  </p>
								<div class="info-link">
									<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_FREE_DOC ); ?>" target="_blank"><?php esc_html_e('Free Theme Documentation', 'auto-car-dealership'); ?></a>
								</div>
							</div>
						</div>
				  	</div>
				</div>
			</div>

			<div id="pro_theme" class="tabcontent">
			  	<h3><?php esc_html_e( 'Premium Theme Information', 'auto-car-dealership' ); ?></h3>
				<hr class="h3hr">
			    <div class="col-left-pro">
			    	<p><?php esc_html_e('This spectacular premium Automobile WordPress Theme is made for the motor-heads. We have created our Automobile themes Stunning design with respect to the automotive industry. The frenzy for keeping our cars immaculate and shiny is well known. We assure you that it will be well reflected in our theme. As they are made with utilizing clean coding standards and it will function well with current WordPress version. It is built on the foundation of being responsive & user-friendly. This allows it to function at its optimal best across all platforms. This takes care of all the visitors and users, regardless of the source of traffic is being driven from.','auto-car-dealership'); ?></p>
			    	
			    </div>
			    <div class="col-right-pro">
			    	<div class="pro-links">
				    	<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'auto-car-dealership'); ?></a>
						<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'auto-car-dealership'); ?></a>
						<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'auto-car-dealership'); ?></a>
						<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get 250+ Themes Bundle at $99', 'auto-car-dealership'); ?></a>
					</div>
			    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/pro.png" alt="" />
			    </div>
			    
			</div>

			<div id="free_pro" class="tabcontent">
				<div class="support-sec">
				  	<div class="featurebox">
				    	<h3 class="theme-features"><?php esc_html_e( 'Theme Features', 'auto-car-dealership' ); ?></h3>
						<hr class="h3hr1">
						<div class="table-image">
							<table class="tablebox">
								<thead>
									<tr>
										<th><?php esc_html_e('Features', 'auto-car-dealership'); ?></th>
										<th><?php esc_html_e('Free Themes', 'auto-car-dealership'); ?></th>
										<th><?php esc_html_e('Premium Themes', 'auto-car-dealership'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php esc_html_e('Easy Setup', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Responsive Design', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('SEO Friendly', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Banner Settings', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Number of Slider/ Banner', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('Banner', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('Unlimited Slides', 'auto-car-dealership'); ?></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Template Pages', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('3', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('6', 'auto-car-dealership'); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Home Page Template', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('1', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('1', 'auto-car-dealership'); ?></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Theme sections', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('2', 'auto-car-dealership'); ?></td>
										<td class="table-img"><?php esc_html_e('10', 'auto-car-dealership'); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Contact us Page Template', 'auto-car-dealership'); ?></td>
										<td class="table-img">0</td>
										<td class="table-img"><?php esc_html_e('1', 'auto-car-dealership'); ?></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Blog Templates & Layout', 'auto-car-dealership'); ?></td>
										<td class="table-img">0</td>
										<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'auto-car-dealership'); ?></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Page Templates & Layout', 'auto-car-dealership'); ?></td>
										<td class="table-img">0</td>
										<td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'auto-car-dealership'); ?></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Section Reordering', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Demo Importer', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Full Documentation', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Latest WordPress Compatibility', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Woo-Commerce Compatibility', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Support 3rd Party Plugins', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Secure and Optimized Code', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Exclusive Functionalities', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Section Enable / Disable', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Section Google Font Choices', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Gallery', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Simple & Mega Menu Option', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Support to add custom CSS / JS ', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Shortcodes', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Premium Membership', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Budget Friendly Value', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('Priority Error Fixing', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Custom Feature Addition', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
										<td><?php esc_html_e('All Access Theme Pass', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr class="odd">
										<td><?php esc_html_e('Seamless Customer Support', 'auto-car-dealership'); ?></td>
										<td class="table-img"><span class="dashicons dashicons-no"></span></td>
										<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									</tr>
									<tr>
									<td></td>
									<td class="table-img"></td>
									<td class="update-link"><a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'auto-car-dealership'); ?></a></td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>

			<div id="get_bundle" class="tabcontent">		  	
			   <div class="col-left-pro">
			   	<h3><?php esc_html_e( 'WP Theme Bundle', 'auto-car-dealership' ); ?></h3>
			    	<p><?php esc_html_e('Enhance your website effortlessly with our WP Theme Bundle. Get access to 250+ premium WordPress themes and 5+ powerful plugins, all designed to meet diverse business needs. Enjoy seamless integration with any plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.','auto-car-dealership'); ?></p>
			    	<div class="feature">
			    		<h4><?php esc_html_e( 'Features:', 'auto-car-dealership' ); ?></h4>
			    		<p><?php esc_html_e('250+ Premium Themes & 5+ Plugins.', 'auto-car-dealership'); ?></p>
			    		<p><?php esc_html_e('Seamless Integration.', 'auto-car-dealership'); ?></p>
			    		<p><?php esc_html_e('Customization Flexibility.', 'auto-car-dealership'); ?></p>
			    		<p><?php esc_html_e('Regular Updates.', 'auto-car-dealership'); ?></p>
			    		<p><?php esc_html_e('Dedicated Support.', 'auto-car-dealership'); ?></p>
			    	</div>
			    	<p>Upgrade now and give your website the professional edge it deserves, all at an unbeatable price of $99!</p>
			    	<div class="pro-links">
						<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'auto-car-dealership'); ?></a>
						<a href="<?php echo esc_url( AUTO_CAR_DEALERSHIP_THEME_BUNDLE_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'auto-car-dealership'); ?></a>
					</div>
			   </div>
			   <div class="col-right-pro">
			    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bundle.png" alt="" />
			   </div>		    
			</div>
			
		</div>
	</div>
<?php }?>
