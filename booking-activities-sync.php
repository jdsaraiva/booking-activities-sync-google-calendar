<?php
/**
 * Plugin Name: Booking Activies class to Google's Calendar
 * Description: Don't miss out your classes, add the events from Booking Activities to Google's calendar.
 * Version: 1
 * Author: Dessain Saraiva
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

wp_register_style( 'booking-sync', plugins_url('style.css',__FILE__ ));
wp_enqueue_style('booking-sync');

function booking_activities_sync_func() {

	function wpb_hook_javascript_footer() {
		?>
		<script>

            document.addEventListener('click', function (event) {

                // If the clicked element doesn't have the right selector, bail
                if (!event.target.matches('.bookacti-submit-form')) return;

	            let title = jQuery(".bookacti-booking-event-title").text().replace(/ /g, '+');

                let startDateElement = jQuery(".bookacti-picked-event").attr("data-event-start");
                let a = new Date(startDateElement);
                let startDate = a.toISOString().replace(/[-:.]/g,'');
                    startDate = startDate.replace("000", "");

                let endDateElement = jQuery(".bookacti-picked-event").attr("data-event-end");
                    let b = new Date(endDateElement);
                    let endDate = b.toISOString().replace(/[-:.]/g,'');
                        endDate = endDate.replace("000", "");

                    let url = "https://calendar.google.com/calendar/r/eventedit?text=" + title + "&details=Aula%20na%20tua%20Box&location=local&dates=" + startDate + "/" + endDate;

                    // Add the link after the confirmation button
                    if(title)
                        jQuery('#syncBtn').html('<div class="bookacti-submit-calendar"><a target="_blank" href="' + url +  '">Adicionar aula ao calendário</a></div>');

            }, false);

		</script>
		<?php
	}
	add_action('wp_footer', 'wpb_hook_javascript_footer');

	return "<div id='syncBtn'></div>";

}

add_shortcode( 'booking_activities_sync', 'booking_activities_sync_func' );
