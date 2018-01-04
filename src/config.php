<?php
/**
 * Zendesk plugin for Craft CMS 3.x
 *
 * Creates a new support ticket in Zendesk using the JSON API
 *
 * @link      https://adigital.agency
 * @copyright Copyright (c) 2018 Matt Shearing
 */

/**
 * Zendesk config.php
 *
 * This file exists only as a template for the Zendesk settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'zendesk.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [

    // This controls blah blah blah
    "customFields" => [
	    [
		    "fieldId" => "158366",
		    "fieldLabel" => "Service",
		    "fieldName" => "service",
		    "fieldType" => "select",
		    "fieldValues" => [
			    [
				    "label" => "Website",
				    "value" => "website"
			    ],
			    [
				    "label" => "Email",
				    "value" => "email"
			    ],
			    [
				    "label" => "Other",
				    "value" => "other"
			    ]
		    ]
	    ],
	    [
		    "fieldId" => "35086088",
		    "fieldLabel" => "Source",
		    "fieldName" => "source",
		    "fieldType" => "hidden",
		    "fieldValue" => "Dashboard Widget"
	    ]
    ]

];
