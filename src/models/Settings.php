<?php
/**
 * Zendesk plugin for Craft CMS 3.x
 *
 * Creates a new support ticket in Zendesk using the JSON API
 *
 * @link      https://adigital.agency
 * @copyright Copyright (c) 2018 Matt Shearing
 */

namespace adigital\zendesk\models;

use craft\base\Model;

/**
 * Zendesk Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Matt Shearing
 * @package   Zendesk
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public string $api_key = '';
    public string $user = '';
    public string $url = '';
    public string $widgetName = '';
    public string $ticketUrl = '';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ['api_key', 'string'],
            ['user', 'string'],
            ['url', 'string'],
            ['widgetName', 'string'],
            ['ticketUrl', 'string']
        ];
    }
}
