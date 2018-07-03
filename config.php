<?php
/**
 * Zendesk plugin for Craft CMS
 *
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
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      http://adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */

return array(

    // This controls blah blah blah
    "customFields" => array(
	    array(
		    "fieldId" => "158366",
		    "fieldLabel" => "Service",
		    "fieldName" => "service",
		    "fieldType" => "select",
		    "fieldValues" => array(
			    array(
				    "label" => "Website",
				    "value" => "website"
			    ),
			    array(
				    "label" => "Email",
				    "value" => "email"
			    ),
			    array(
				    "label" => "Other",
				    "value" => "other"
			    )
		    )
	    ),
	    array(
		    "fieldId" => "35086088",
		    "fieldLabel" => "Source",
		    "fieldName" => "source",
		    "fieldType" => "hidden",
		    "fieldValue" => "Dashboard Widget"
	    )
    )

);
