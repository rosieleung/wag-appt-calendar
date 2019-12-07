<?php

function fetch_avcal_callback() {
	$month = intval( $_POST['month'] );
	$year = intval( $_POST['year'] );
    if ($month && $year) {
        echo draw_frontend_calendar_for_month($month,$year);
    } else {
        echo "Error: Could not determine month and year!";
    }
	wp_die();
}
add_action( 'wp_ajax_nopriv_fetch_avcal', 'fetch_avcal_callback' );
add_action( 'wp_ajax_fetch_avcal', 'fetch_avcal_callback' );


// save availability
function save_avcal_callback( ) {

    // die if nonce doesn't match
    check_ajax_referer('save_avcal','security');

    // unserialize input
    $form = array();
    parse_str($_POST['input'], $form);

    // get the month and year being saved
    $month = intval($form['month']);
    $year = intval($form['year']);

    // get the existing data for this year
    $optionName = "avcal_" . $year;

    $currentyear = get_option($optionName, array());

    if(!isset($currentyear[$month])) {
        $currentyear[$month] = array();
    }

    $calendars = avcal_calendar_list();
    foreach ($calendars as $key=>$val) {

        // form provides booked days; convert to available days
        $allDays = array_fill(1,31,'1');
        $availableDays = array_diff_key($allDays,$form[$key]);

        // fill this month with all the dates that cats/dogs are accepted
        $currentyear[$month][$key] = $availableDays;
    }

    // update the saved data for this year
    update_option($optionName, $currentyear, false);

    wp_die();
}

add_action( 'wp_ajax_save_avcal', 'save_avcal_callback' );




function fetch_admin_avcal_callback() {
	$month = intval( $_POST['month'] );
	$year = intval( $_POST['year'] );

    if ($month && $year)
        draw_admin_calendar_for_month($month,$year);

	wp_die();
}
add_action( 'wp_ajax_fetch_admin_avcal', 'fetch_admin_avcal_callback' );;