<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete;

use UniOne\Api\Obsolete\Model\ObsoleteUnsubscribedCheckRequest;
use UniOne\Api\Obsolete\Model\ObsoleteUnsubscribedCheckResponse;
use UniOne\Api\Obsolete\Model\ObsoleteUnsubscribedListRequest;
use UniOne\Api\Obsolete\Model\ObsoleteUnsubscribedListResponse;
use UniOne\Api\Obsolete\Model\ObsoleteUnsubscribedSetRequest;
use UniOne\Api\Obsolete\Model\ObsoleteUnsubscribedSetResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;

/**
 * Obsolete methods dealing with unsubscribes. We recommend using the more flexible
 * [suppression](https://docs.unione.io/en/web-api-ref#suppression) methods instead. Note that you can't
 * resubscribe an unsubscribed recipient using WebAPI, but you can send him an email with subscription link using
 * email/subscribe method.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->obsolete()->unsubscribedSet(new ObsoleteUnsubscribedSetRequest('email@example.com'));
 * echo $response->getAddress(), PHP_EOL;
 * ```
 */
final class ObsoleteApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Registers a new unsubscribed email.
     *
     * After registering an email as unsubscribed all future attempts to send a message to this email will be
     * rejected. Please note that there's no way to remove an email from unsubscribed thru the API. But you can send
     * an email with a link to resubscribe using
     * [email/subscribe](https://docs.unione.io/en/web-api-ref#email-subscribe) method or remove "unsubscribed"
     * status manually on [Email Search page](https://cp.unione.io/en/user/email) in control panel (but only a
     * limited number of unsubscribed email per day can be removed).
     *
     * @see https://docs.unione.io/en/web-api-ref#unsubscribed-set
     *
     * @throws ApiException
     */
    public function unsubscribedSet(ObsoleteUnsubscribedSetRequest $request): ObsoleteUnsubscribedSetResponse
    {
        return ObsoleteUnsubscribedSetResponse::fromArray($this->client->call('/unsubscribed/set.json', $request->toArray()));
    }

    /**
     * Checks if an email is unsubscribed.
     *
     * @see https://docs.unione.io/en/web-api-ref#unsubscribed-check
     *
     * @throws ApiException
     */
    public function unsubscribedCheck(ObsoleteUnsubscribedCheckRequest $request): ObsoleteUnsubscribedCheckResponse
    {
        return ObsoleteUnsubscribedCheckResponse::fromArray($this->client->call('/unsubscribed/check.json', $request->toArray()));
    }

    /**
     * Returns a list of all unsubscribed emails since provided date.
     *
     * @see https://docs.unione.io/en/web-api-ref#unsubscribed-list
     *
     * @throws ApiException
     */
    public function unsubscribedList(ObsoleteUnsubscribedListRequest $request): ObsoleteUnsubscribedListResponse
    {
        return ObsoleteUnsubscribedListResponse::fromArray($this->client->call('/unsubscribed/list.json', $request->toArray()));
    }
}
