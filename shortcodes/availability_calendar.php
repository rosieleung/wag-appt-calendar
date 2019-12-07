<?php

// [availability_calendar]
function availability_calendar_fun($atts) {

    if(!isset($atts) || !isset($atts['type'])) {
        return '';
    }

    ob_start();
    ?>

    <div class="avcal_table_wrapper show-<?php echo esc_attr($atts['type']); ?>">
        <div class="avcal_title">
        <?php
            $calendars = avcal_calendar_list();
                foreach($calendars as $key=>$val) {
                echo '<strong class="',$key,'-title"> ',$val['longname'],' Appointments</strong>';
            }
        ?>
        </div>
        <div class="avcal_table">

        <?php
            $month = date('n');
            $year = date('Y');
            echo draw_frontend_calendar_for_month($month,$year);
        ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'availability_calendar', 'availability_calendar_fun' );


function draw_frontend_calendar_for_month($month,$year) {
    ob_start();

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

    <div class="avcal_header">
        <a class="prev_month" href="#" data-month="<?php echo $lastmonth; ?>" data-year="<?php echo $lastyear; ?>"></a>
        <h2><?php echo $monthName, ' ', $year; ?></h2>
        <a class="next_month" href="#" data-month="<?php echo $nextmonth; ?>" data-year="<?php echo $nextyear; ?>"></a>
    </div>


    <?php echo draw_calendar($month,$year,'frontend_avcal_callback',array('S','M','T','W','T','F','S')); ?>

        <div class="avcal_legend">
            <div class="avcal_legend_avail"><div></div> Available</div>
            <div class="avcal_legend_booked"><div></div> Unavailable</div>
        </div>

    <?php
    return ob_get_clean();
}

// customizes table cell output
function frontend_avcal_callback($day,$data) {
    $classes = array();
    foreach($data as $key=>$val) {
        if ($val) {
            $classes[] = $key . '-ok';
        } else {
            $classes[] = 'no-' . $key;
        }
    }

    ob_start();
    ?>
    <td class="calendar-day <?php echo implode(" ",$classes); ?>">
    <?php echo $day; ?>
    </td>
         <?php
    return ob_get_clean();
}
