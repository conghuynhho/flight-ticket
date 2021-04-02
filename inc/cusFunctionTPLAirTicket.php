<?php
	/*Create shortcode TEMPLATE VE-MAY-BAY */
	function createShortCodeTPLAirTicket() {
		ob_start();
			require(TEMPLATEPATH . '/template-part-layouts/template-ve-may-bay.php');
		return ob_get_clean();
	}
	add_shortcode('FORM_VE_MAY_BAY', 'createShortCodeTPLAirTicket');

	/* ISSET POST INPUT */

	function postInput($string) {
        return isset($_POST[$string]) ? $_POST[$string] : '';
    }