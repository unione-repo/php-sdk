<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook;

use UniOne\Api\Webhook\Model\WebhookCallback;
use UniOne\Api\Webhook\Model\WebhookDeleteRequest;
use UniOne\Api\Webhook\Model\WebhookGetRequest;
use UniOne\Api\Webhook\Model\WebhookGetResponse;
use UniOne\Api\Webhook\Model\WebhookListRequest;
use UniOne\Api\Webhook\Model\WebhookListResponse;
use UniOne\Api\Webhook\Model\WebhookSetRequest;
use UniOne\Api\Webhook\Model\WebhookSetResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * UniOne lets you recieve notifications about email status changes or spam blocks. You provide an URL and every
 * time a watched event occurs we will notify you by submitting a request with JSON data to this URL.
 *
 * You can configure the format of webhook calls (JSON or gzipped JSON), which events you want to be notified of,
 * whether or not you let us groups several events in one request, do you want to receive extra details like SMTP
 * answer or recipient's user agent, etc.
 *
 * Please note that your webhook handler should be able to process at least 5 parallel requests, up to 100 events
 * each (but you can configure the maximum number of parallel connections up to 100, which is recommended).
 *
 * If the URL of your webhook handler is not available (the response is not HTTP 200 OK within 3 seconds
 * timeout), the system will repeat requests each 10 minutes during 24 hours, passing extra parameter
 * retry_count. If there were at least 10 events during last 24 hours and all the webhook requests about these
 * events have failed then we consider webhook handler broken and change it's status to inactive automatically. A
 * notification about that is sent to an email [configured in control
 * panel](https://cp.unione.io/en/user/alerting/technical/).
 *
 * The format of webhook request and details of each event are described
 * [here](https://docs.unione.io/en/web-api-ref#callback-format).
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->webhook()->set(new WebhookSetRequest('https://yourhost.example.com/unione-webhook'));
 * var_dump($response->getObject());
 * ```
 */
final class WebhookApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Sets or edits a [webhook](https://docs.unione.io/en/web-api-ref#webhook), i.e. an event notification handler.
     *
     * @see https://docs.unione.io/en/web-api-ref#webhook-set
     *
     * @throws ApiException
     */
    public function set(WebhookSetRequest $request): WebhookSetResponse
    {
        return WebhookSetResponse::fromArray($this->client->call('/webhook/set.json', $request->toArray()));
    }

    /**
     * Gets properties of a [webhook](https://docs.unione.io/en/web-api-ref#webhook).
     *
     * @see https://docs.unione.io/en/web-api-ref#webhook-get
     *
     * @throws ApiException
     */
    public function get(WebhookGetRequest $request): WebhookGetResponse
    {
        return WebhookGetResponse::fromArray($this->client->call('/webhook/get.json', $request->toArray()));
    }

    /**
     * List all or some [webhooks](https://docs.unione.io/en/web-api-ref#webhook) (event notification handlers) of a
     * user or a project.
     *
     * @see https://docs.unione.io/en/web-api-ref#webhook-list
     *
     * @throws ApiException
     */
    public function list(WebhookListRequest $request): WebhookListResponse
    {
        return WebhookListResponse::fromArray($this->client->call('/webhook/list.json', $request->toArray()));
    }

    /**
     * Deletes an event notification handler
     *
     * You can also temporarily deactivate webhook without deleting it by setting it's status to "disabled" in
     * [webhook/set](https://docs.unione.io/en/web-api-ref#webhook-set) method.
     *
     * @see https://docs.unione.io/en/web-api-ref#webhook-delete
     *
     * @throws ApiException
     */
    public function delete(WebhookDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/webhook/delete.json', $request->toArray()));
    }

    /**
     * Webhook callback format description.
     *
     * @param string $json Raw body of the incoming request.
     *
     * @throws \UnexpectedValueException when the body is not a JSON object
     */
    public static function parseCallback(string $json): WebhookCallback
    {
        $data = \json_decode($json, true);
        if (!\is_array($data)) {
            throw new \UnexpectedValueException('Invalid JSON: ' . \json_last_error_msg());
        }

        return WebhookCallback::fromArray($data);
    }
}
