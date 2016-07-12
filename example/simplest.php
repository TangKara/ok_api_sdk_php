<?php
/**
 * Created by PhpStorm.
 * User: qin
 * Date: 7/12/16
 * Time: 11:17 AM
 */

use OK\ApiSdk\Client;

function main()
{
    $client = new Client();
    $client->requestBuilder->config->setAppVersionValue("1.0")->setAppMarketIdValue("678")
        ->setGatewayHost("api.OpsKitchen.com")->setDisableSSL(true);
    $client->requestBuilder->credential->setAppKey("101")->setSecret("7INWkF/qSkkXrFwZ");

    try {
        $response = $client->callApi("ops.meta.os.list", "1.0");
        print_r($response);
    } catch (\Exception $e) {
        print_r($e);
    }
}

main();