<?php

declare(strict_types=1);

namespace UniOne\Api\ConfirmedEmail;

use UniOne\Api\ConfirmedEmail\Model\ConfirmedEmailCreateResponse;
use UniOne\Api\ConfirmedEmail\Model\ConfirmedEmailDeleteResponse;
use UniOne\Api\ConfirmedEmail\Model\ConfirmedEmailListResponse;
use UniOne\Api\ConfirmedEmail\Model\ConfirmedEmailRequest;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;

/**
 * Manage email addresses confirmed for sandbox-domain sending. These methods are available only with a main
 * account API key.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->confirmedEmail()->create(new ConfirmedEmailRequest(
 *     email: 'dev@example.com',
 * ));
 * var_dump($response->confirmedEmail);
 * ```
 */
final class ConfirmedEmailApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Adds an email address and sends a confirmation link.
     *
     * @see https://docs.unione.io/en/web-api-ref#confirmed-email-create
     *
     * @throws ApiException
     */
    public function create(ConfirmedEmailRequest $request): ConfirmedEmailCreateResponse
    {
        return ConfirmedEmailCreateResponse::fromArray($this->client->call('/confirmed-email/create.json', $request->toArray()));
    }

    /**
     * Lists confirmed and unconfirmed email addresses for the account.
     *
     * @see https://docs.unione.io/en/web-api-ref#confirmed-email-list
     *
     * @throws ApiException
     */
    public function list(): ConfirmedEmailListResponse
    {
        return ConfirmedEmailListResponse::fromArray($this->client->call('/confirmed-email/list.json'));
    }

    /**
     * Deletes an email address from the account's confirmed email list.
     *
     * @see https://docs.unione.io/en/web-api-ref#confirmed-email-delete
     *
     * @throws ApiException
     */
    public function delete(ConfirmedEmailRequest $request): ConfirmedEmailDeleteResponse
    {
        return ConfirmedEmailDeleteResponse::fromArray($this->client->call('/confirmed-email/delete.json', $request->toArray()));
    }
}
