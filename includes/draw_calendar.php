<?php

function draw_calendar($month,$year,$day_callback = NULL,$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')){

    /* load the list of calendars (e.g. male/female dog/cat) */
    $calendars = avcal_calendar_list();
    $calendar_keys = array_keys($calendars);

    /* load availability info for the given year */
    $openDaysYear = get_option("avcal_" . $year, array());

	/* draw table */
	$return = '<table class="calendar">';

	$return.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$return.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$return.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):

        if($day_callback) {
            // using a custom callback function to output each day, so let's
            // supply it with cat/dog availability info for this day

            $data = array();

            // has this month been saved yet?
            if (isset($openDaysYear[$month])) {

                // if this day is a key, then it's available
                foreach ($calendar_keys as $key) {
                    $data[$key] = isset($openDaysYear[$month][$key][$list_day]);
                }

            } else {
                // this month hasn't been saved yet, so just use default values
                if ($running_day == 0 || $running_day == 6) {
                    // default to closed on sundays and saturdays
                    $data = array_fill_keys($calendar_keys,0);
                } else {
                    // default to open on weekdays
                    $data = array_fill_keys($calendar_keys,1);
                }
            }
            $return .= call_user_func_array($day_callback,array($list_day,$data));
        } else {
            // not using a custom callback function, so just output the day number
            $return.= '<td class="calendar-day">';
            $return.= '<div class="day-number">'.$list_day.'</div>';
            $return.= '</td>';
		}


		if($running_day == 6):
			$return.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$return.= '<tr class="calendar-row">';
			    $running_day = -1;
			    $days_in_this_week = 0;
			endif;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$return.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	if($running_day != 7) {
	    // close table row if not already closed
	    $return.= '</tr>';
	}

	/* end the table */
	$return.= '</table>';

	/* all done, return result */
	return $return;
}