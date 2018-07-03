# Zendesk plugin for Craft CMS

Creates a new support ticket in Zendesk using the JSON API

![Screenshot](resources/screenshots/plugin_logo.png)

## Installation

To install Zendesk, follow these steps:

1. Download & unzip the file and place the `zendesk` directory into your `craft/plugins` directory
2.  -OR- do a `git clone ???` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins
4. The plugin folder should be named `zendesk` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

Zendesk works on Craft 2.4.x and Craft 2.5.x.

## Zendesk Overview

This plugin can work either as a dashboard widget on your clients website, or you can post to it from a frontend form on your own website.

## Configuring Zendesk

You will need your Zendesk api key, user account, and api url to be entered. This has been built for the Zendesk V2 API. The rest of the settings are optional. You can give the widget a custom name e.g. Ask A Digital. You can also add a url where tickets can be viewed so that requesters can click through upon successfully submission of a ticket to view it straight away.

A config.php is included with an example of 2 custom fields we have set up for our integration of Zendesk. Move this file to the main config folder within Craft and rename the file to zendesk.php if you wish to include your own custom fields to be posted from the dashboard widget.

## Using Zendesk

Below is a very basic example of a front end form which will be able to submit a ticket through this plugin to Zendesk. If you wish to add your own custom fields to this form, just define them in the plugins config file and then add the inputs to the form. Make sure that you are matching the input name attribute with the config fieldName value.

```
<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<input type="hidden" name="action" value="zendesk/submit">
	<input type="hidden" name="redirect" value="/support/thank-you">
	<input type="hidden" name="success" value="/support/thank-you">
	<input type="hidden" name="failed" value="/support/failed">
	{{ getCsrfInput() }}
	
	Name: <input type="text" name="name">
	Email: <input type="text" name="email">
	Type: <select name="type">
		<option value="question">Question</option>
		<option value="incident">Incident</option>
		<option value="problem">Problem</option>
		<option value="task">Task</option>
	</select>
	Priority: <select name="priority">
		<option value="low">Low</option>
		<option value="normal">Normal</option>
		<option value="high">High</option>
		<option value="urgent">Urgent</option>
	</select>
	Subject: <input type="text" name="subject">
	Body: <input type="text" name="body">
	Attachment(s): <input type="file" name="attachments[]" multiple>
	
	<button type="submit">Raise Ticket</button>
</form>
```

Brought to you by [Matt Shearing](https://adigital.agency)
