<?php
/**
 * Auto Car Dealership Theme Customizer
 *
 * @package Auto Car Dealership
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function auto_car_dealership_custom_controls() {
	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'auto_car_dealership_custom_controls' );

function auto_car_dealership_customize_register( $wp_customize ) {

	//Homepage Settings
	$wp_customize->add_panel( 'auto_car_dealership_homepage_panel', array(
		'title' => esc_html__( 'Homepage Settings', 'auto-car-dealership' ),
		'panel' => 'auto_car_dealership_panel_id',
		'priority' => 20,
	));

	//theme Layouts
	$wp_customize->add_section( 'auto_car_dealership_animation_wow', array(
    	'title'      => esc_html__( 'Animation', 'auto-car-dealership' ),
		'panel' => 'auto_car_dealership_homepage_panel'
	) );

    //Wow Animation
	$wp_customize->add_setting( 'auto_car_dealership_animation',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'auto_car_dealership_switch_sanitization'
    ));
    $wp_customize->add_control( new Auto_Car_Dealership_Toggle_Switch_Custom_Control( $wp_customize, 'auto_car_dealership_animation',array(
        'label' => esc_html__( 'Animation ','auto-car-dealership' ),
        'description' => __('Here you can disable overall site animation effect','auto-car-dealership'),
        'section' => 'auto_car_dealership_animation_wow'
    )));
    
}

add_action( 'customize_register', 'auto_car_dealership_customize_register' );
