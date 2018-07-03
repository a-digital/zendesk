<?php
/**
 * Zendesk plugin for Craft CMS
 *
 * Zendesk Controller
 *
 * --snip--
 * Generally speaking, controllers are the middlemen between the front end of the CP/website and your plugin’s
 * services. They contain action methods which handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering post data, saving it on a model,
 * passing the model off to a service, and then responding to the request appropriately depending on the service
 * method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what the method does (for example,
 * actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 * --snip--
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */

namespace Craft;

class ZendeskController extends BaseController
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = array('actionIndex', 'actionSubmit'
        );

    /**
     * Handle a request going to our plugin's index action URL, e.g.: actions/zendesk
     */
    public function actionIndex()
    {
    }
    
    /**
     * Handle a request going to our plugin's actionsubmit URL,
     * e.g.: actions/zendesk/submit
     *
     * @return mixed
     */
    public function actionSubmit()
    {
		$this->requirePostRequest();
		$request = craft()->request;
	    $method = $request->getPost('redirect');
	    $body = $request->getPost('body');
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
	    $data = array(
		    'subject' => $request->getPost('subject'),
			'priority' => $request->getPost('priority'),
			'type' => $request->getPost('type'),
			'body' => $body,
			'name' => $request->getPost('name'),
			'email' => $request->getPost('email'),
			'customFields' => array()
	    );
	    if (count($_FILES)) {
		    $token = craft()->zendesk->submitAttachments($_FILES);
		    $data['token'] = $token;
	    }
	    if (craft()->config->get("customFields", "zendesk")) {
		    $customFields = craft()->config->get("customFields", "zendesk");
		    foreach($customFields as $field) {
			    if ($request->getPost($field["fieldName"]) <> "") {
			    	$data["customFields"][$field["fieldId"]] = $request->getPost($field["fieldName"]);
			    }
		    }
	    }
	    $ticketId = craft()->zendesk->submitTicket($data);
	    if ($ticketId) {
		    $method = $request->getPost('success')."/".$ticketId;
	    } else {
		    $method = $request->getPost('failed');
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
	    $this->requirePostRequest();
	    $request = craft()->request;
	    $method = craft()->request->getPost('redirect');
	    $data = array(
		    'subject' => $request->getPost('subject'),
			'priority' => $request->getPost('priority'),
			'type' => $request->getPost('type'),
			'body' => $request->getPost('comment'),
			'name' => $request->getPost('name'),
			'email' => $request->getPost('email'),
			'customFields' => array()
	    );
	    if (count($_FILES)) {
		    $token = craft()->zendesk->submitAttachments($_FILES);
		    $data['token'] = $token;
	    }
	    if (craft()->config->get("customFields", "zendesk")) {
		    $customFields = craft()->config->get("customFields", "zendesk");
		    foreach($customFields as $field) {
			    if ($request->getPost($field["fieldName"]) <> "") {
			    	$data["customFields"][$field["fieldId"]] = $request->getPost($field["fieldName"]);
			    }
		    }
	    }
		$ticketId = craft()->zendesk->submitTicket($data);
		if ($ticketId) {
		    $settings = craft()->plugins->getPlugin('zendesk')->getSettings();
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
	    echo $response;
	    exit;
    }
}