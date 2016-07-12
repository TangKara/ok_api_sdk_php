<?php
/**
 * Created by PhpStorm.
 * User: qin
 * Date: 7/11/16
 * Time: 7:45 PM
 */

namespace OK\ApiSdk;


use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use OK\ApiSdk\Di\Logger\LoggerInterface;
use OK\ApiSdk\Model\ApiResult;

class Client
{
    /**
     * @var LoggerInterface
     */
    static public $defaultLogger;

    /**
     * @var ClientInterface
     */
    public $httpClient;

    /**
     * @var RequestBuilder
     */
    public $requestBuilder;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();
        $this->requestBuilder = new RequestBuilder();
    }

    /**
     * @param LoggerInterface $logger
     */
    static public function setDefaultLogger($logger)
    {
        self::$defaultLogger = $logger;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param $api
     * @param $version
     * @param mixed $params
     *
     * @return ApiResult
     */
    public function callApi($api, $version, $params = null)
    {
        $request = $this->requestBuilder->build($api, $version, $params);
        $response = $this->httpClient->send($request);

        if ($response->getStatusCode() !== 200) {
            //server side error
            return null;
        }

        $jsonObj = json_decode($response->getBody());
        if (json_last_error()) {
            //response body is invalid json
            return null;
        }
        return $jsonObj;
    }
}