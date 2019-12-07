jQuery(function () {
	init_avcal_frontend();
});

function init_avcal_frontend( ) {

    var $avcals = jQuery(".avcal_table");
    if (!$avcals.length) return;

    $avcals.on("click",".avcal_header a",function(e) {

        e.preventDefault();
        $cal = jQuery(e.delegateTarget); // the clicked .avcal_table

        var month = jQuery(this).data("month");
        var year = jQuery(this).data("year");
        var data = {
            'action': 'fetch_avcal',
            'month': month,
            'year' : year
        };

        jQuery.post(ajax_object.ajax_url, data, function(response) {
            $cal.html(response);
        });
    });
}