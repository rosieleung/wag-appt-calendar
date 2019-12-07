jQuery(function () {
	init_avcal_admin_ajax();
});

function init_avcal_admin_ajax( ) {

    var $form = jQuery("#availability_calendar");
    if (!$form.length) return;

    // save the form with ajax
    $form.submit(function(e) {
        e.preventDefault();

        $form.addClass("doing-ajax");

        var data = {
            action: 'save_avcal',
            input: $form.serialize(),
            security : $form.find("input[name='avcal_noncename']").val()
        };

        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $form.addClass("form-saved");
            $form.removeClass("doing-ajax");
            setTimeout(function(){
                $form.removeClass("form-saved");
            },10);
        });

    });

    // jumping to a month updates the table
    jQuery("#jump-submit").click(function(e) {
        e.preventDefault();
        update_table(
            $form.find("select[name='jump-month']").val(),
            $form.find("input[name='jump-year']").val());
    });

    // clicking the prev/next links in the header updates the table
    $form.on("click",".avcal_header a",function(e) {
        e.preventDefault();
        update_table(
            jQuery(this).data("month"),
            jQuery(this).data("year"));
    });

    // given a month and year, fetches the admin table and updates the page
    function update_table(month, year) {
        var data = {
            'action': 'fetch_admin_avcal',
            'month': month,
            'year' : year
        };
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            jQuery("#avcal_table").html(response);
        });
    }

    // toggle hiding weekends
    function update_weekend_display() {
        if(jQuery("#hide_weekends").is(':checked')) {
            $form.addClass("hide_weekends");
        } else {
            $form.removeClass("hide_weekends");
        }
        if(localStorage){
            var hidden = jQuery("#hide_weekends").is(':checked');
            localStorage.setItem('hide_weekends',JSON.stringify(hidden));
        }
    }
    jQuery("#hide_weekends").change(function() {
        update_weekend_display();
    });
    if(localStorage && localStorage.getItem('hide_weekends')){
        var hidden = JSON.parse(localStorage.getItem('hide_weekends'));
        jQuery("#hide_weekends").prop("checked",hidden);
    }
    update_weekend_display();

}

