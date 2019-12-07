<?php

// register Availability Calendar menu page
function wpdocs_register_avcal_admin_page() {
    add_menu_page(
        'Appointment Calendar',
        'Appointment Calendar',
        'manage_options',
        'availability_calendar',
        'avcal_admin_page',
        'dashicons-calendar-alt',
        20
    );
}
add_action( 'admin_menu', 'wpdocs_register_avcal_admin_page' );

function avcal_admin_page(){
    $month = date('n');
    $year = date('Y');
?>
<div class="wrap">
<h1>Appointment Availability Calendar</h1>
<form action="#" method="POST" id="availability_calendar" class="hide_weekends">

<p><label><input type="checkbox" id="hide_weekends" checked="checked" /> Hide weekends</label></p>

<div class="avcal_jump_to_date">
<p>Jump to a month:</p>
<select name="jump-month">
<option value="1"<?php selected($month, 1); ?>>January</option>
<option value="2"<?php selected($month, 2); ?>>Febuary</option>
<option value="3"<?php selected($month, 3); ?>>March</option>
<option value="4"<?php selected($month, 4); ?>>April</option>
<option value="5"<?php selected($month, 5); ?>>May</option>
<option value="6"<?php selected($month, 6); ?>>June</option>
<option value="7"<?php selected($month, 7); ?>>July</option>
<option value="8"<?php selected($month, 8); ?>>August</option>
<option value="9"<?php selected($month, 9); ?>>September</option>
<option value="10"<?php selected($month, 10); ?>>October</option>
<option value="11"<?php selected($month, 11); ?>>November</option>
<option value="12"<?php selected($month, 12); ?>>December</option>
</select>
<input type="number" name="jump-year" value="<?php echo $year; ?>" min="2016" />
<button type="button" id="jump-submit">Go</button>
</div>

<?php draw_admin_calendar_for_month($month,$year); ?>

	<input type="hidden" name="avcal_noncename" value="<?php echo wp_create_nonce( 'save_avcal' ); ?>" />
	<div class="avcal_save_wrapper"><input type="submit" value="Save month" class="avcal_save" /></div>
	</form>

	</div>
	<?php
}


// given a month and year, output the admin interface for managing it
function draw_admin_calendar_for_month($month,$year) {
    $nextmonth = $month+1;
    $nextyear = $year;
    $lastmonth = $month-1;
    $lastyear = $year;
    switch($month) {
        case 1:
            $lastmonth = 12;
            $lastyear = $year-1;
            break;
        case 12:
            $nextmonth = 1;
            $nextyear = $year+1;
            break;
    }

    // convert current month name to string
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
?>
<div id="avcal_table">
    <div class="avcal_header">
        <a class="prev_month" href="#" data-month="<?php echo $lastmonth; ?>" data-year="<?php echo $lastyear; ?>">&laquo; Previous</a>
        <h2><?php echo $monthName, ' ', $year; ?></h2>
        <a class="next_month" href="#" data-month="<?php echo $nextmonth; ?>" data-year="<?php echo $nextyear; ?>">Next &raquo;</a>
    </div>
    <?php echo draw_calendar($month,$year,'admin_avcal_callback'); ?>
    <input type="hidden" name="month" value="<?php echo $month; ?>" />
    <input type="hidden" name="year" value="<?php echo $year; ?>" />
</div>
<?php
}


// customizes table cell output to include checkboxes
function admin_avcal_callback($day,$data) {
ob_start();
?>
<td class="calendar-day">
    <div class="day-number"><?php echo $day; ?></div>
    <?php
        $calendars = avcal_calendar_list();
        foreach ($calendars as $key=>$val) {
            echo '<label><input type="checkbox" name="',$key,'[', $day, ']" value="1"', checked(!$data[$key],true,false), ' />',$val['shortname'],'</label>';
        }
    ?>
</td>
<?php
return ob_get_clean();
}

