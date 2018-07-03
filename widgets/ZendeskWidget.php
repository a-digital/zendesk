<?php
/**
 * Zendesk plugin for Craft CMS
 *
 * Zendesk_Form Widget
 *
 * --snip--
 * Dashboard widgets allow you to display information in the Admin CP Dashboard.  Adding new types of widgets to
 * the dashboard couldn’t be easier in Craft
 *
 * https://craftcms.com/docs/plugins/widgets
 * --snip--
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      http://adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */
namespace Craft;
class ZendeskWidget extends BaseWidget
{
	// Public Properties
    // =========================================================================

    /**
     * @var string The message to display
     */
    public $name = '';
    public $email = '';
    
    public function init()
    {
        parent::init();
        
        if ($this->name === '') {
	        $this->name = craft()->userSession->getUser()->name;
        }
        if ($this->email === '') {
	        $this->email = craft()->userSession->getUser()->email;
        }
    }

    // Public Methods
    // =========================================================================
    /**
     * Returns the name of the widget name.
     *
     * @return mixed
     */
    public function getName()
    {
        $settings = craft()->plugins->getPlugin('zendesk')->getSettings();
	    $widgetName = "Raise a ticket";
	    if ($settings->widgetName) {
		    $widgetName = $settings->widgetName;
	    }
        return Craft::t($widgetName);
    }
    /**
     * getBodyHtml() does just what it says: it returns your widget’s body HTML. We recommend that you store the
     * actual HTML in a template, and load it via craft()->templates->render().
     *
     * @return mixed
     */
    public function getBodyHtml()
    {
        // Include our Javascript & CSS
        craft()->templates->includeCssResource('zendesk/css/widgets/ZendeskWidget.css');
        craft()->templates->includeJsResource('zendesk/js/widgets/ZendeskWidget.js');
        /* -- Variables to pass down to our rendered template */
        $variables = array();
        $variables['settings'] = $this->getSettings();
        $variables['name'] = $this->name;
        $variables['email'] = $this->email;
        $variables['customFields'] = craft()->config->get("customFields", "zendesk");
        return craft()->templates->render('zendesk/widgets/ZendeskWidget_Body', $variables);
    }
    /**
     * Defines the attributes that model your Widget's available settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'name' => array(AttributeType::String, 'label' => 'Name', 'default' => ''),
            'email' => array(AttributeType::String, 'label' => 'Email', 'default' => ''),
        );
    }
    /**
     * Returns the HTML that displays your Widget's settings.
     *
     * @return mixed
     */
    public function getSettingsHtml()
    {

/* -- Variables to pass down to our rendered template */

        $variables = array();
        $variables['settings'] = $this->getSettings();
        return craft()->templates->render('zendesk/widgets/ZendeskWidget_Settings',$variables);
    }

    /**
     * If you need to do any processing on your settings’ post data before they’re saved to the database, you can
     * do it with the prepSettings() method:
     *
     * @param mixed $settings  The Widget's settings
     *
     * @return mixed
     */
    public function prepSettings($settings)
    {

/* -- Modify $settings here... */

        return $settings;
    }
}