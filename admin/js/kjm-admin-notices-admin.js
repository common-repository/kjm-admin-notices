(function( $ ) {
	'use strict';
	
		/* Code by Marc-Antoine Minville */

		jQuery(document).ready(function() {
			 
			 /* Admin Panel Controls styling */
			
			/* Parent rows are different from childs rows. */
			jQuery('.kjm-admin-notices-wrap tr.parent').css('border-bottom', '1px solid #bbb').css('border-top', '1px solid #ccc').css('background', 'linear-gradient(to bottom, #E6E6E6, #C4C4C4) #dfdfdf').css('text-shadow', '1px 1px 1px rgba(255,255,255, 0.1)');
			
			/* Each row will be evaluated to color it or hide it. */
			jQuery('.kjm-admin-notices-wrap tr.parent input[type="checkbox"]').each(function(){
				if (!this.checked) {
					jQuery('.kjm-admin-notices-wrap tr.child.'+this.name+'').hide();
					jQuery(this).parent().parent().parent().css('opacity', '0.3').css('background', 'linear-gradient(to bottom, #E6E6E6, #E6E6E6) #E6E6E6');
				} else {
					jQuery('.kjm-admin-notices-wrap tr.child.'+this.name+'').css('background-color', '#DCEDF2');
					jQuery(this).parent().parent().parent().css('opacity', '1').css('background', 'linear-gradient(to bottom, #E6E6E6, #C4C4C4) #dfdfdf');
				}
			});
			
			/* On click of a parent checkbox, whole childs are hidden. */
			jQuery('.kjm-admin-notices-wrap tr.parent input[type="checkbox"]').click(function(){
				var name = this.name; 
				var checked = this.checked;
				var color = checked ? '#D3E9F0': '#FFD3C9';
				
				if (checked) {
					jQuery(this).parent().parent().parent().css('opacity', '1').css('background', 'linear-gradient(to bottom, #E6E6E6, #C4C4C4) #dfdfdf');
				} else {
					jQuery(this).parent().parent().parent().css('opacity', '0.3').css('background', 'linear-gradient(to bottom, #E6E6E6, #E6E6E6) #E6E6E6');
				}
				
				jQuery('.kjm-admin-notices-wrap tr.child.'+name+'').css('background-color', color).fadeToggle(500, "swing", function(){
					
					if (checked) {
						jQuery(this).css('background-color', '#DCEDF2');
						//jQuery(this).animate({'background-color': 'transparent'}, 200);
					} else {
						
					}
				});
				
			});
			
			// Plugin-specific functions.
			$( '.notice.is-dismissible' ).on('click', '.notice-dismiss', function ( event ) {
				event.preventDefault();
				var nfe = $(this).parents('div:first');
				if ($(this).hasClass("kjm-notice-dismiss") == true) nfe.fadeOut();
				var nfn = nfe.attr('data-notice-id');
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					async: false,
					data: { action: 'kjm_dismiss_notice_ajax', notice: nfn, _wpnonce: kjm_admin_notices_admin.ajax_nonce }
				});
			});
			
			function kjm_admin_notices_process_checkboxes() {
				
				// Check All / None Button.
				// Remove attribute disabled from all role checked.
				//$('#kjm_admin_notices_show_notice_to_all').removeAttr("disabled");

				$('#kjm_admin_notices_show_notice_to_all').change(function () {
					$('#kjm_admin_notices_show_notice_to .others').prop("checked", this.checked);
					if ($('#kjm_admin_notices_show_notice_to_all').prop("checked") === true) {
						$('#kjm_admin_notices_show_notice_to .others').prop("disabled", true);
					} else {
						$('#kjm_admin_notices_show_notice_to .others').prop("disabled", false);
					}
				});

				// Check the particular notice All role checked or not.
				if($('#kjm_admin_notices_show_notice_to_all').prop("checked") === false){
					$('#kjm_admin_notices_show_notice_to .others').removeAttr("disabled");				
				}else{
					$("#kjm_admin_notices_show_notice_to .others").attr( "disabled", "disabled" );
				}
				
			}
			// First verification on load.
			if($('#kjm_admin_notices_show_notice_to_all').prop("checked") === true){
				$('#kjm_admin_notices_show_notice_to .others').prop("checked", true);				
			}
			if (kjm_admin_notices_admin.sent !== '1') {
				kjm_admin_notices_process_checkboxes();
			}
				
			// Validate Notice Category in Add Or Edit Post-type: kjm_notice, Allow only one checkebox to be checked.
			jQuery('#taxonomy-kjm_notice_cat input:checkbox').on('change', function() {                        
				jQuery('#taxonomy-kjm_notice_cat input:checkbox').not(this).prop('checked', false);  
			});


			$( '.colorpicker' ).wpColorPicker();
			
			
			/* Unpublished status */

			if (kjm_admin_notices_admin.screen === 'single') {

				if ($('select#post_status option[value="archive"]').length === 0) {
					var selected = (kjm_admin_notices_admin.postStatus === 'archive') ? 'selected' : '',
									option   = '<option value="archive"' + selected + '>' + kjm_admin_notices_admin.archive + '</option>';

						$('select#post_status option:last').after(option);
				}

				if (kjm_admin_notices_admin.postStatus === 'archive') {
					$('#post-status-display').html(kjm_admin_notices_admin.archive);
							$('#save-post').attr('value', kjm_admin_notices_admin.saveArchive);
				}

					$('.save-post-status').on('click', function() {
							if ($('select#post_status').val() === 'archive') {
									$('#save-post').attr('value', kjm_admin_notices_admin.saveArchive);
							}
					});
			}

			if (kjm_admin_notices_admin.screen === 'list') {
				$('.wp-list-table').on('click', 'tr:not(.status-archive) .editinline', function(e) {
							var option = '<option value="archive">' + kjm_admin_notices_admin.archive + '</option>';

						$(e.delegateTarget).find('.inline-edit-row .inline-edit-status select').append(option);
				});
					
				$('.wp-list-table').on('click', 'tr.status-archive .editinline', function(e) {
							var option = '<option value="archive" selected>' + kjm_admin_notices_admin.archive + '</option>';

						$(e.delegateTarget).find('.inline-edit-row .inline-edit-status select').append(option);
				});

				$('#doaction').on('click', function() {
							var condition = $('#bulk-action-selector-top').val() === 'edit';

							condition = condition && $('#bulk-edit .inline-edit-status select option[value="archive"]').length === 0;

					if (condition) {
									var option = '<option value="archive">' + kjm_admin_notices_admin.archive + '</option>';

						$('#bulk-edit .inline-edit-status select').append(option);
					}
				});
			}
    

		});

})( jQuery );
