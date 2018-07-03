/**
 * Zendesk plugin for Craft CMS
 *
 * Zendesk_FormWidget JS
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      http://adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */

$(document).ready(function(){
	$("#zendeskWidgetForm").submit(function(e){
		var formBody = $(this).parent();
		var response;
		var submission = new FormData(this);
		$(this).find("input[name='zendeskTicketSubmit']").hide();
		$(this).find("div[name='loadingSpinner']").show();
		$.ajax({
			url : "/actions/zendesk/supportTicket",
			type: "POST",
			data : submission,
			processData: false,
			contentType: false,
			success:function(data, textStatus, jqXHR){
				response = data;
				formBody.html(response);
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log(errorThrown);
				console.log(textStatus);
				response = "<p>Error: We are sorry but your ticket was not submitted correctly.</p>";
				formBody.html(response);
			}
		});
		e.preventDefault();
	});
});