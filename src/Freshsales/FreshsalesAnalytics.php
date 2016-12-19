<?php

/**
 */

require(dirname(__FILE__) . '/freshsales/Client.php');

/**
 * Class Freshsales
 */
class FreshsalesAnalytics
{
    /**
     * @var
     */
    private static $client;

    /**
     * Initializes the default client to use.
     *
     */
    public static function init($properties) {
        self::assert(!empty($properties['domain']), "Freshsales::init() requires domain");
        self::assert(!empty($properties['app_token']), "Freshsales::init() requires app token");
        self::$client = new Client($properties);
    }

    /**
     * @param array $properties
     * @throws Exception
     */
    public static function identify(array $properties) {
        self::checkClient();
        self::assert(!is_null($properties), "Freshsales::identify() properties should not be null)");
        self::assert(!empty($properties['identifier']), "Freshsales::identify() requires identifier)");
        return self::$client->identify($properties);

    }

    /**
     * @param array $properties
     * @return mixed
     * @throws Exception
     */
    public static function trackEvent(array $properties){
        self::checkClient();
        self::assert(!is_null($properties), "Freshsales::trackEvent() properties should not be null)");
        self::assert(!empty($properties['identifier']), "Freshsales::trackEvent() requires identifier)");
        self::assert(!empty($properties['name']), "Freshsales::trackEvent() expects an event name)");
        return self::$client->trackEvent($properties);

    }

    /**
     * @param array $properties
     * @return mixed
     * @throws Exception
     */
    public static function trackPageView(array $properties){
        self::checkClient();
        self::assert(!is_null($properties), "Freshsales::trackPageView() properties should not be null)");
        self::assert(!empty($properties['identifier']), "Freshsales::trackPageView() requires identifier)");
        self::assert(!empty($properties['url']), "Freshsales::trackPageView expects Page View URL)");
        return self::$client->trackPageView($properties);

    }

    /**
     * Check the client.
     *
     * @throws Exception
     */
    private static function checkClient(){
        if (null != self::$client) return;
        throw new Exception("Freshsales::init() must be called before any other tracking method.");
    }

    /**
     * Assert `value` or throw.
     *
     * @param array $value
     * @param string $msg
     * @throws Exception
     */
    private static function assert($value, $msg){
        if (!$value) throw new Exception($msg);
    }

}