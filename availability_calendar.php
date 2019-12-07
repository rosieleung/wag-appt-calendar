<?php
/*
Plugin Name: Availability Calendar
Version:     1.1
Description: Provides a calendar that shows availability of cat and dog appointments.
Author:      Rosie Leung
Author URI:  mailto:margaretroseleung@gmail.com
License:     Copyright 2016 Rosie Leung, all rights reserved.
*/

if( !defined( 'ABSPATH' ) ) exit;

define('AVCAL_VERSION', '1.1');

function init_avcal_plugin() {
	include( dirname(__FILE__) . '/shortcodes/availability_calendar.php' );
	include( dirname(__FILE__) . '/includes/draw_calendar.php' );
	include( dirname(__FILE__) . '/includes/availability_calendar.php' );
	include( dirname(__FILE__) . '/includes/enqueue.php' );
	include( dirname(__FILE__) . '/includes/ajax.php' );
}
add_action( 'init', 'init_avcal_plugin' );


// define the calendars
function avcal_calendar_list() {
    return array(
    'cat_m' => array(
        'shortname' => 'Cats (M)',
        'longname' => 'Male Cat'
        ),
    'cat_f' => array(
        'shortname' => 'Cats (F)',
        'longname' => 'Female Cat'
        ),
    'dog_m' => array(
        'shortname' => 'Dogs (M)',
        'longname' => 'Male Dog'
        ),
    'dog_f' => array(
        'shortname' => 'Dogs (F)',
        'longname' => 'Female Dog'
        ),
    );
}