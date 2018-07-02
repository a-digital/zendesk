<?php
/**
 * Zendesk plugin for Craft CMS 3.x
 *
 * Creates a new support ticket in Zendesk using the JSON API
 *
 * @link      https://adigital.agency
 * @copyright Copyright (c) 2018 Matt Shearing
 */

namespace adigital\zendesk\controllers;

use adigital\zendesk\Zendesk;

use Craft;
use craft\web\Controller;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Matt Shearing
 * @package   Zendesk
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'submit'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/zendesk/default
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';

        return $result;
    }

    /**
     * Handle a request going to our plugin's actionsubmit URL,
     * e.g.: actions/zendesk/default/submit
     *
     * @return mixed
     */
    public function actionSubmit()
    {
	    $request = Craft::$app->getRequest();
	    $method = $request->getParam('redirect');
	    $body = $request->getParam('body');
	    if (is_array($body)) {
		    $formattedBody = "";
		    foreach($body as $field => $value) {
			    if (isset($value) && $value <> '') {
				    if (is_numeric($field)) {
					    $formattedBody .= $value."\n";
				    } else {
					    $field = ucwords(preg_replace('~(\p{Ll})(\p{Lu})~u','${1} ${2}', $field));
					    $formattedBody .= $field.": ".$value."\n";
				    }
			    }
		    }
		    $body = $formattedBody;
	    }
	    $data = [
		    'subject' => $request->getParam('subject'),
			'priority' => $request->getParam('priority'),
			'type' => $request->getParam('type'),
			'body' => $body,
			'name' => $request->getParam('name'),
			'email' => $request->getParam('email'),
			'customFields' => []
	    ];
	    if (count($_FILES)) {
		    $token = Zendesk::$plugin->zendeskService->submitAttachments($_FILES);
		    $data['token'] = $token;
	    }
	    if (Craft::$app->getConfig()->getConfigFromFile("zendesk")) {
		    $customFields = Craft::$app->getConfig()->getConfigFromFile("zendesk")["customFields"];
		    foreach($customFields as $field) {
			    if ($request->getParam($field["fieldName"]) <> "") {
			    	$data["customFields"][$field["fieldId"]] = $request->getParam($field["fieldName"]);
			    }
		    }
	    }
	    $ticketId = Zendesk::$plugin->zendeskService->submitTicket($data);
	    if ($ticketId) {
		    $method = $request->getParam('success')."/".$ticketId;
	    } else {
		    $method = $request->getParam('failed');
	    }
	    return $this->redirect($method);
    }
    
    /**
     * Handle a request going to our plugin's actionsubmit URL,
     * e.g.: actions/zendesk/default/support-ticket
     *
     * @return mixed
     */
    public function actionSupportTicket()
    {
	    $request = Craft::$app->getRequest();
	    $method = $request->getParam('redirect');
	    $data = [
		    'subject' => $request->getParam('subject'),
			'priority' => $request->getParam('priority'),
			'type' => $request->getParam('type'),
			'body' => $request->getParam('comment'),
			'name' => $request->getParam('name'),
			'email' => $request->getParam('email'),
			'customFields' => []
	    ];
	    if (count($_FILES)) {
		    $token = Zendesk::$plugin->zendeskService->submitAttachments($_FILES);
		    $data['token'] = $token;
	    }
	    if (Craft::$app->getConfig()->getConfigFromFile("zendesk")) {
		    $customFields = Craft::$app->getConfig()->getConfigFromFile("zendesk")["customFields"];
		    foreach($customFields as $field) {
			    if ($request->getParam($field["fieldName"]) <> "") {
			    	$data["customFields"][$field["fieldId"]] = $request->getParam($field["fieldName"]);
			    }
		    }
	    }
	    $ticketId = Zendesk::$plugin->zendeskService->submitTicket($data);
	    if ($ticketId) {
		    $settings = Zendesk::$plugin->getSettings();
			$response = "<p>Success:</p>";
			$response .= "<p>Thank you for submitting a ticket with us. Your ticket number is ";
			if ($settings->ticketUrl <> '') {
				$response .= "<a href='".$settings->ticketUrl.$ticketId."' target='_blank'>".$ticketId."</a>";
			} else {
				$response .= $ticketId;
			}
			$response .= " and we will get back to you shortly.</p>";
		} else {
			$response = "<p>Error:</p>";
			$response .= "<p>We are sorry but your ticket hasn't been submitted successfully. Please try again or get in touch with us via another method.</p>";
		}
	    return $response;
    }
}
