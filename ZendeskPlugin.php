<?php
/**
 * Zendesk plugin for Craft CMS
 *
 * Creates a new support ticket in Zendesk using the JSON API
 *
 * --snip--
 * Craft plugins are very much like little applications in and of themselves. We’ve made it as simple as we can,
 * but the training wheels are off. A little prior knowledge is going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL, as well as some semi-
 * advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 * --snip--
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */

namespace Craft;

class ZendeskPlugin extends BasePlugin
{
    /**
     * Called after the plugin class is instantiated; do any one-time initialization here such as hooks and events:
     *
     * craft()->on('entries.saveEntry', function(Event $event) {
     *    // ...
     * });
     *
     * or loading any third party Composer packages via:
     *
     * require_once __DIR__ . '/vendor/autoload.php';
     *
     * @return mixed
     */
    public function init()
    {
    }

    /**
     * Returns the user-facing name.
     *
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Zendesk');
    }

    /**
     * Plugins can have descriptions of themselves displayed on the Plugins page by adding a getDescription() method
     * on the primary plugin class:
     *
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Creates a new support ticket in Zendesk using the JSON API');
    }

    /**
     * Plugins can have links to their documentation on the Plugins page by adding a getDocumentationUrl() method on
     * the primary plugin class:
     *
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/a-digital/zendesk/blob/craft2/README.md';
    }

    /**
     * Plugins can now take part in Craft’s update notifications, and display release notes on the Updates page, by
     * providing a JSON feed that describes new releases, and adding a getReleaseFeedUrl() method on the primary
     * plugin class.
     *
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://github.com/a-digital/zendesk/blob/craft2/releases.json';
    }

    /**
     * Returns the version number.
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.0.1';
    }

    /**
     * As of Craft 2.5, Craft no longer takes the whole site down every time a plugin’s version number changes, in
     * case there are any new migrations that need to be run. Instead plugins must explicitly tell Craft that they
     * have new migrations by returning a new (higher) schema version number with a getSchemaVersion() method on
     * their primary plugin class:
     *
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * Returns the developer’s name.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'Matt Shearing';
    }

    /**
     * Returns the developer’s website URL.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'adigital.agency';
    }
    
    /**
     * Hook Register CP Routes
     */
    public function registerCpRoutes()
    {
        return array(
            'zendesk/submit' => array('action' => "zendesk/submit")
        );
    }

    /**
     * Returns whether the plugin should get its own tab in the CP header.
     *
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }
    
    /**
     * Returns an array whose keys define the setting names, and values define the parameters
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'api_key' => array(AttributeType::String, 'label' => 'Your Zendesk API key', 'default' => ''),
            'user' => array(AttributeType::String, 'label' => 'Email address of account owner', 'default' => ''),
            'url' => array(AttributeType::String, 'label' => 'The api url for zendesk', 'default' => ''),
            'widgetName' => array(AttributeType::String, 'label' => 'A custom title for the support form', 'default' => ''),
            'ticketUrl' => array(AttributeType::String, 'label' => 'An individual tickets url minus the ticketId', 'default' => '')
        );
    }
    
    /**
     * Returns the HTML that displays your plugin’s settings.
     *
     * @return mixed
     */
    public function getSettingsHtml()
    {
       return craft()->templates->render('zendesk/Zendesk_Settings', array(
           'settings' => $this->getSettings()
       ));
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
        // Modify $settings here...

        return $settings;
    }
    
    public function registerSiteRoutes()
	{
	    return array(
	        'zendesk/actionSupportTicket' => array('action' => 'zendesk/supportTicket')
	    );
	}

    /**
     * Called right before your plugin’s row gets stored in the plugins database table, and tables have been created
     * for it based on its records.
     */
    public function onBeforeInstall()
    {
    }

    /**
     * Called right after your plugin’s row has been stored in the plugins database table, and tables have been
     * created for it based on its records.
     */
    public function onAfterInstall()
    {
    }

    /**
     * Called right before your plugin’s record-based tables have been deleted, and its row in the plugins table
     * has been deleted.
     */
    public function onBeforeUninstall()
    {
    }

    /**
     * Called right after your plugin’s record-based tables have been deleted, and its row in the plugins table
     * has been deleted.
     */
    public function onAfterUninstall()
    {
    }
}