<?php
/**
 * Zendesk plugin for Craft CMS
 *
 * Zendesk Service
 *
 * --snip--
 * All of your plugin’s business logic should go in services, including saving data, retrieving data, etc. They
 * provide APIs that your controllers, template variables, and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 * --snip--
 *
 * @author    Matt Shearing
 * @copyright Copyright (c) 2018 Matt Shearing
 * @link      adigital.agency
 * @package   Zendesk
 * @since     1.0.0
 */

namespace Craft;

class ZendeskService extends BaseApplicationComponent
{
    /**
     * This function can literally be anything you want, and you can have as many service functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     craft()->zendesk->exampleService()
     */
    public function submitTicket($data)
    {
		//build up the json array
		$create = array(
			'ticket' => array(
				'subject' => $data['subject'],
				'priority' => $data['priority'],
				'status' => 'new',
				'type' => $data['type'],
				'comment' => array(
					'body' => $data['body']
				),
				'custom_fields' => $data["customFields"],
				'requester' => array(
					'name' => $data['name'],
					'email' => $data['email']
				)
			)
		);
		if (isset($data["token"]) && $data["token"] <> '') {
			$create["ticket"]["comment"]["uploads"] = array($data["token"]);
		}
		$create = json_encode($create);
		$headers = array('Content-type: application/json');

		//send all this to zendesk using our curl wrapper
		$output = craft()->zendesk->curlWrap("/tickets.json", $create, $headers);
		
		//get the ticket ID - also checks the new ticket was created successfully
		$ticketId = $output->ticket->id;
		
		//if return exists and we've a ticket ID - it must have been created successfully :-)
		if ($output && $ticketId) {
			return $ticketId;
		}
		return false;
    }
    
    public function submitAttachments($attachments)
    {
	    $token = false;
	    foreach($attachments["attachments"]["name"] as $key => $filename) {
		    $file = $attachments["attachments"]["tmp_name"][$key];
		    
		    $filedata = file_get_contents($file);
		    $url = '/uploads.json?filename=' . str_replace(" ", "_", $filename);
		    if (isset($token) && $token <> '') {
			    $url .= '&token=' . $token;
		    }
		    $headers = array('Content-Type: application/binary', 'Accept: application/json; charset=utf-8');
		    $output = craft()->zendesk->curlWrap($url, $filedata, $headers);
		    if ($key === 0) {
			    $token = $output->upload->token;
		    }
	    }
	    
		return $token;
    }
    
    public function curlWrap($url, $data, $headers)
	{
		$settings = craft()->plugins->getPlugin('zendesk')->getSettings();
		$zdApiKey = $settings->api_key;
		$zdUser = $settings->user;
		$zdUrl = $settings->url;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_URL, $zdUrl.$url);
		curl_setopt($ch, CURLOPT_USERPWD, $zdUser."/token:".$zdApiKey);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		
		$decoded = json_decode($output);
		return $decoded;
	}
}