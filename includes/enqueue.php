<?php

function availability_calendar_enqueue_frontend_scripts() {
	wp_enqueue_style( 'availability_calendar', plugins_url(  '/assets/availability_calendar.css', dirname(__FILE__)  ),array(), AVCAL_VERSION );
	wp_enqueue_script( 'availability_calendar', plugins_url( '/assets/availability_calendar.js', dirname(__FILE__)  ), array( 'jquery' ), AVCAL_VERSION, true);
    wp_localize_script( 'availability_calendar', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ), array(), AVCAL_VERSION );
}
add_action( 'wp_enqueue_scripts', 'availability_calendar_enqueue_frontend_scripts' );

function availability_calendar_enqueue_backend_scripts() {
	wp_enqueue_style( 'availability_calendar-admin', plugins_url( '/assets/availability_calendar-admin.css', dirname(__FILE__)  ), array(), AVCAL_VERSION );
	wp_enqueue_script( 'availability_calendar-admin', plugins_url( '/assets/availability_calendar-admin.js', dirname(__FILE__)  ), array('jquery'), AVCAL_VERSION, true );
	wp_localize_script( 'availability_calendar-admin', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ), array(), AVCAL_VERSION);
}
add_action( 'admin_enqueue_scripts', 'availability_calendar_enqueue_backend_scripts' );
