/**
 * Zendesk plugin for Craft CMS
 *
 * ZendeskWidget Widget JS
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      https://adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */

$(document).ready(function(){
	$("#zendeskWidgetForm input[name='zendeskTicketSubmit']").click(function(e){
		var formBody = $(this).parent().parent();
		var response;
		var fields = {};
		$("#zendeskWidgetForm input[type='text']").each(function(){
			fields[$(this).attr("name")] = $(this).val();
		});
		$("#zendeskWidgetForm input[type='hidden']").each(function(){
			fields[$(this).attr("name")] = $(this).val();
		});
		$("#zendeskWidgetForm select").each(function(){
			fields[$(this).attr("name")] = $(this).val();
		});
		$("#zendeskWidgetForm textarea").each(function(){
			fields[$(this).attr("name")] = $(this).val();
		});
		$("#zendeskWidgetForm input[type='file']").each(function(){
			fields[$(this).attr("name")] = $(this).val();
		});
		$.post("/actions/zendesk/default/support-ticket", fields).done(function(data){
			response = data;
		}).fail(function(){
			response = "<p>Error: We are sorry but your ticket was not submitted correctly.</p>";
		}).always(function(){
			formBody.html(response);
		});
		e.preventDefault();
	});
});