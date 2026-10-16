<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression;

use UniOne\Api\Suppression\Model\SuppressionDeleteRequest;
use UniOne\Api\Suppression\Model\SuppressionGetRequest;
use UniOne\Api\Suppression\Model\SuppressionGetResponse;
use UniOne\Api\Suppression\Model\SuppressionListRequest;
use UniOne\Api\Suppression\Model\SuppressionListResponse;
use UniOne\Api\Suppression\Model\SuppressionSetRequest;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * Methods for managing suppression lists. An email can be added to suppression list because of unsubscription,
 * bounce or complain.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->suppression()->set(new SuppressionSetRequest(
 *     email: 'email@example.com',
 *     cause: 'unsubscribed',
 *     created: '2021-12-19 10:15:49',
 * ));
 * ```
 */
final class SuppressionApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Adds an email address to the suppression list. You can always remove this address from the suppression list
     * later using the [suppression/delete](https://docs.unione.io/en/web-api-ref#suppression-delete) method.
     *
     * @see https://docs.unione.io/en/web-api-ref#suppression-set
     *
     * @throws ApiException
     */
    public function set(SuppressionSetRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/suppression/set.json', $request->toArray()));
    }

    /**
     * Gets a reason and date of email suppression.
     *
     * @see https://docs.unione.io/en/web-api-ref#suppression-get
     *
     * @throws ApiException
     */
    public function get(SuppressionGetRequest $request): SuppressionGetResponse
    {
        return SuppressionGetResponse::fromArray($this->client->call('/suppression/get.json', $request->toArray()));
    }

    /**
     * Returns a suppression list since provided date.
     *
     * @see https://docs.unione.io/en/web-api-ref#suppression-list
     *
     * @throws ApiException
     */
    public function list(SuppressionListRequest $request): SuppressionListResponse
    {
        return SuppressionListResponse::fromArray($this->client->call('/suppression/list.json', $request->toArray()));
    }

    /**
     * Deletes an email from suppression list (only records with is_deletable=true). If there are no entries of this
     * email in the suppression list, API error 3003 is returned. If such entries exist but no one can be deleted,
     * API error 3004 is returned. If daily limit of deletes exceeded, API error 906 is returned.
     *
     * @see https://docs.unione.io/en/web-api-ref#suppression-delete
     *
     * @throws ApiException
     */
    public function delete(SuppressionDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/suppression/delete.json', $request->toArray()));
    }
}
