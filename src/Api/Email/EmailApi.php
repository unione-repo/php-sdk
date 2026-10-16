<?php

declare(strict_types=1);

namespace UniOne\Api\Email;

use UniOne\Api\Email\Model\EmailSendRequest;
use UniOne\Api\Email\Model\EmailSendResponse;
use UniOne\Api\Email\Model\EmailSubscribeRequest;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * This group of methods is related with email sending.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->email()->send(new EmailSendRequest(
 *     message: new MessageObject(
 *         recipients: [
 *             new MessageObjectRecipientsItem(
 *                 email: 'user@example.com',
 *                 substitutions: [
 *                     'CustomerId' => '12452',
 *                     'to_name' => 'John Smith',
 *                 ],
 *                 metadata: [
 *                     'campaign_id' => 'c77f4f4e-3561-49f7-9f07-c35be01b4f43',
 *                     'customer_hash' => 'b253ac7',
 *                 ],
 *             ),
 *         ],
 *         templateId: '00000000-0000-0000-0000-000000000000',
 *         globalLanguage: 'en',
 *         templateEngine: TemplateEngine::Velocity,
 *         body: new BodyObject(
 *             html: '<b>Hello, {{to_name}}</b>',
 *             plaintext: 'Hello, {{to_name}}',
 *             amp: '<!doctype html><html amp4email><head> <meta charset="utf-8"><script async src="https://cdn.ampproject.org/v0.js"></script> <style amp4email-boilerplate>body{visibility:hidden}</style></head><body> Hello, AMP4EMAIL world.</body></html>',
 *         ),
 *         subject: 'UniOne test email ',
 *         fromEmail: 'email@example.com',
 *         fromName: 'John Smith',
 *         replyTo: 'email@example.com',
 *         replyToName: 'John Smith',
 *         idempotenceKey: 'SG1VsbG68sIH2dvc5mx890kIQ',
 *     ),
 * ));
 * echo $response->jobId, PHP_EOL;
 * ```
 */
final class EmailApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Sends an email or a bunch of emails
     *
     * While sending you can provide substitutions (merge tags), use a template, turn on read or click tracking, etc.
     *
     * Restrictions:
     * * maximum request size is 10 MB
     * * maximum number of recipients is 500
     * * The symbol '/' is not allowed in attachment names
     *
     * If the list of recipients contains invalid, non-existent, duplicate, or unsubscribed emails, those emails will
     * be returned in the output parameter failed_emails, and the email will be sent to all other valid emails
     * addresses. If all the emails addresses fall into failed_emails, sending will not be carried out and API error
     * 204 will be returned.
     *
     * @see https://docs.unione.io/en/web-api-ref#email-send
     *
     * @throws ApiException
     */
    public function send(EmailSendRequest $request): EmailSendResponse
    {
        return EmailSendResponse::fromArray($this->client->call('/email/send.json', $request->toArray()));
    }

    /**
     * Sends an email with (re)subscribe link.
     *
     * This method allows subscription renewal by a former subscriber who has previously unsubscribed, or who is
     * blocked because of complaints. This method sends an email with a new subscription link to a former subscriber.
     * Once the recipient clicks the link, their subscription status is restored.
     * There is a default restriction that limits this method to being used once a day. If you need to resubscribe
     * more often, please ask support about it.
     *
     * @see https://docs.unione.io/en/web-api-ref#email-subscribe
     *
     * @throws ApiException
     */
    public function subscribe(EmailSubscribeRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/email/subscribe.json', $request->toArray()));
    }
}
