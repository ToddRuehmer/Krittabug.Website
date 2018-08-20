// JavaScript Document
jQuery(document).on("change keyup paste keydown","#mailchimp_api_key", function(e) {
		var val = jQuery(this).val();
		if( val !== "" )
			jQuery("#auth-mailchimp").removeAttr('disabled');
		else
			jQuery("#auth-mailchimp").attr('disabled','true');
});

jQuery(document).on( "click", "#auth-mailchimp", function(e){
	e.preventDefault();
	jQuery(".smile-absolute-loader").css('visibility','visible');
	var auth_token = jQuery("#mailchimp_api_key").val();
	var action = 'update_mailchimp_authentication';
	var data = {action:action,authentication_token:auth_token};
	jQuery.ajax({
		url: ajaxurl,
		data: data,
		type: 'POST',
		dataType: 'JSON',
		success: function(result){
			if(result.status == "success" ){
				jQuery(".bsf-cnlist-mailer-help").hide();
				jQuery("#save-btn").removeAttr('disabled');
				jQuery("#mailchimp_api_key").closest('.bsf-cnlist-form-row').hide();
				jQuery("#auth-mailchimp").closest('.bsf-cnlist-form-row').hide();
				jQuery(".mailchimp-list").html(result.message);
			} else {
				jQuery(".mailchimp-list").html('<span class="bsf-mailer-error">'+result.message+'</span>');
			}
			jQuery(".smile-absolute-loader").css('visibility','hidden');
		}
	});
	e.preventDefault();
});

jQuery(document).on( "click", "#disconnect-mailchimp", function(){
															
	if(confirm("Are you sure? If you disconnect, your previous campaigns syncing with mailchimp will be disconnected as well.")) {
		var action = 'disconnect_mailchimp';
		var data = {action:action};
		jQuery(".smile-absolute-loader").css('visibility','visible');
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			type: 'POST',
			dataType: 'JSON',
			success: function(result){

				jQuery("#save-btn").attr('disabled','true');
				if(result.message == "disconnected" ){

					jQuery("#mailchimp_api_key").val('');
					jQuery(".mailchimp-list").html('');
					jQuery("#disconnect-mailchimp").replaceWith('<button id="auth-mailchimp" class="button button-secondary auth-button" disabled="true">Authenticate MailChimp</button><span class="spinner" style="float: none;"></span>');
					jQuery("#auth-mailchimp").attr('disabled','true');

				}

				jQuery('.bsf-cnlist-form-row').fadeIn('300');
				jQuery(".bsf-cnlist-mailer-help").show();
				jQuery(".smile-absolute-loader").css('visibility','hidden');
			}
		});
	}
	else {
		return false;
	}
});