<?php

/**
 */
class CurlTransport
{
    /**
     * @var
     */
    private $domain;
    /**
     * @var
     */
    private $appToken;

    /**
     * CurlTransport constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->domain = $properties['domain'];
        $this->appToken = $properties['app_token'];
    }

    /**
     * @param $action
     * @param $message
     * @throws Exception
     */
    public function post($action, $message)
    {
        $url = $this->constructUrl($action);
        $message['application_token'] = $this->appToken;
        $message['sdk'] = 'php';
        $body = json_encode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Content-Length: ' . strlen($body))
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_status != 200) {
            throw new Exception("Freshsales encountered an error. CODE: " . $http_status . " Response: " . $response);
        }
    }

    /**
     * Construct URL from domain and action
     * @param $action
     * @return string Constructed URL
     */
    private function constructUrl($action)
    {
        $url = $this->domain . '/track/'  . $action;
        return $url;
    }
}
