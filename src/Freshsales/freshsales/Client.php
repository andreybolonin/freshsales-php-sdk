<?php

/**
 */

require(__DIR__ . '/CurlTransport.php');

/**
 * Class Client
 */
class Client
{

    /**
     * @var CurlTransport
     */
    private $curlTrans;

    /**
     * Client constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->curlTrans = new CurlTransport($properties);
    }

    /**
     * Identify user
     * @param array $properties
     * @throws Exception
     */
    public function identify(array $properties)
    {
        $message = array();
        $message['identifier'] = $properties['identifier'];
        // unset identifier from properties
        unset($properties['identifier']);
        $message['visitor'] = $this->convert_array_to_object($properties);
        // post message
        $this->curlTrans->post('visitors', $message);
    }

    /**
     * Track Event
     * @param array $properties
     * @throws Exception
     */
    public function trackEvent(array $properties)
    {
        $message = array();
        $message['identifier'] = $properties['identifier'];
        // unset identifier from properties
        unset($properties['identifier']);
        $message['event'] = $this->convert_array_to_object($properties);
        // post message
        $this->curlTrans->post('events', $message);
    }

    /**
     * Track Page View
     * @param array $properties
     * @throws Exception
     */
    public function trackPageView(array $properties)
    {
        $message = array();
        $pageView = new stdClass();
        $pageView->url = $properties['url'];
        $message['identifier'] = $properties['identifier'];
        // unset identifier from properties
        unset($properties['identifier']);
        $message['page_view'] = $pageView;
        // post message
        $this->curlTrans->post('page_views', $message);
    }

    /**
     * Utility method to convert array members to an object
     * @param array $prop
     * @return stdClass
     */
    private function convert_array_to_object(array $prop){
        $object = new stdClass();
        foreach ($prop as $key => $value)
        {
            $object->$key = $value;
        }
        return $object;
    }

}