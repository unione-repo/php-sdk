<?php

declare(strict_types=1);

namespace UniOne\Api\System;

use UniOne\Api\System\Model\SystemInfoResponse;
use UniOne\Api\System\Model\SystemPingResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;

/**
 * System operations.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->system()->ping();
 * echo $response->getUserId(), PHP_EOL;
 * ```
 */
final class SystemApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Checks API key validity and returns user ID.
     *
     * @see https://docs.unione.io/en/web-api-ref#system-ping
     *
     * @throws ApiException
     */
    public function ping(): SystemPingResponse
    {
        return SystemPingResponse::fromArray($this->client->call('/system/ping.json'));
    }

    /**
     * Gets user or project info by API key.
     *
     * @see https://docs.unione.io/en/web-api-ref#system-info
     *
     * @throws ApiException
     */
    public function info(): SystemInfoResponse
    {
        return SystemInfoResponse::fromArray($this->client->call('/system/info.json'));
    }
}
