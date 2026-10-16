<?php

declare(strict_types=1);

namespace UniOne;

use UniOne\Client\Configuration;
use UniOne\Client\Transport\TransportInterface;

/**
 * Shortcut to create the UniOne API client.
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 * ```
 */
final class UniOne
{
    /**
     * @param string $apiKey User or project API key.
     * @param string|null $host API host (Configuration::HOST_* constant, e.g. 'us1.unione.io') or a full base URL, null: Configuration::DEFAULT_BASE_URL.
     * @param TransportInterface|null $transport HTTP transport, null: cURL (Psr18Transport for PSR-18 clients).
     */
    public static function client(
        string $apiKey,
        ?string $host = null,
        ?TransportInterface $transport = null,
        float $timeout = 30.0,
    ): UniOneClient {
        return new UniOneClient(
            new Configuration($apiKey, null === $host ? Configuration::DEFAULT_BASE_URL : Configuration::baseUrlFor($host), $timeout),
            $transport,
        );
    }
}
