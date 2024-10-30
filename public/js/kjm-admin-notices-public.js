(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	jQuery(document).ready( function($) {
	 
		// notication is present
		/*if ($("#notification-area").length && notices_ajax_script.logged_in == 'no') {
			var notice_id = $('#notification-area #remove-notice').attr('rel');
			if(!$.cookie('notice-' + notice_id)) {
				$('#notification-area').show();
			}
		}*/

		var cookieval = $.cookie('kjmnotice');
		var items = cookieval ? cookieval.split(/,/) : new Array();
		
		/* Each Notice will be evaluated to hide it if already dismissed. */
		$('.kjm-notice > .kjm-content').each(function(){
			
			var post_id = $(this).attr('data-id');
			var dismissed = $.inArray(post_id, items);
			
			if (dismissed != -1) {
				$(this).hide();
			}
		});

		
		$(".remove-notice").click( function() {
			
			var notice_id = $(this).attr('rel');

			//if(notices_ajax_script.logged_in == 'no') {
				// store a cookie so notice is not shown again
				var cookieval = $.cookie('kjmnotice');
				var items = cookieval ? cookieval.split(/,/) : new Array();

				if(cookieval === ''){
					
					$.cookie('kjmnotice', notice_id, { expires: 1 });				
					$('#kjm-notice-'+notice_id).fadeOut();

				} else {

					// Remove same notice id
					var indx = items.indexOf(notice_id);
					if(indx!=-1) items.splice(indx, 1);

					// Add comma seperate value by notice id
					items.push(notice_id);
					$.cookie('kjmnotice', items.join(','), { expires: 1 });
					$('#kjm-notice-' + notice_id).fadeOut();
				}
				
			//}
			
			/*var data = {
				action: 'mark_notice_as_read',
				notice_read: notice_id
			};
			$.post(notices_ajax_script.ajaxurl, data, function(response) {
				$('#notification-area').fadeOut();
			});*/
			return false;
		});
		
	});

})( jQuery );
