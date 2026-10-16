<?php

declare(strict_types=1);

namespace UniOne\Api\EmailValidation;

use UniOne\Api\EmailValidation\Model\EmailValidationSingleRequest;
use UniOne\Api\EmailValidation\Model\EmailValidationSingleResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;

/**
 * Email validation methods. As a result of the check, you’ll get detailed information on email validity. It will
 * help eliminate nonexistent emails, decrease the number of complaints, clean up the subscribers list and
 * eventually enhance your sender reputation score. For example, you may add validation to a subscription form on
 * your site to let users know they’ve just entered an invalid address.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->emailValidation()->single(new EmailValidationSingleRequest('email@example.com'));
 * echo $response->getEmail(), PHP_EOL;
 * ```
 */
final class EmailValidationApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * A maximum of two concurrent requests are allowed; if you send more requests, an error will be returned. Since
     * the verification process should be completed promptly, we've set a time limit on email check. If we encounter
     * a slow email server that does not respond in 5 seconds, you may get an “unknown” status.
     *
     * @see https://docs.unione.io/en/web-api-ref#email-validation-single
     *
     * @throws ApiException
     */
    public function single(EmailValidationSingleRequest $request): EmailValidationSingleResponse
    {
        return EmailValidationSingleResponse::fromArray($this->client->call('/email-validation/single.json', $request->toArray()));
    }
}
