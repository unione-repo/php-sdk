<?php

declare(strict_types=1);

namespace UniOne\Api\Template;

use UniOne\Api\Template\Model\TemplateDeleteRequest;
use UniOne\Api\Template\Model\TemplateGetRequest;
use UniOne\Api\Template\Model\TemplateGetResponse;
use UniOne\Api\Template\Model\TemplateListRequest;
use UniOne\Api\Template\Model\TemplateListResponse;
use UniOne\Api\Template\Model\TemplateSetRequest;
use UniOne\Api\Template\Model\TemplateSetResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * You have the option of storing a template on the UniOne side and then using it by id, which is highly
 * recommended for sending repetitive messages or high volume traffic. UniOne supports two different [template
 * engines](https://docs.unione.io/en/template-engines).
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->template()->set(new TemplateSetRequest(
 *     template: new TemplateObject(
 *         name: 'name',
 *         editorType: EditorType::Html,
 *         templateEngine: TemplateEngine::Velocity,
 *         subject: 'UniOne test email ',
 *         fromEmail: 'user@example.com',
 *         fromName: 'John Smith',
 *         replyTo: 'email@example.com',
 *         replyToName: 'John Smith',
 *     ),
 * ));
 * var_dump($response->template);
 * ```
 */
final class TemplateApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Creates or updates an email template.
     *
     * Restrictions:
     * * The maximum request size is 10 MB.
     * * The number of templates is limited to 10000.
     *
     * @see https://docs.unione.io/en/web-api-ref#template-set
     *
     * @throws ApiException
     */
    public function set(TemplateSetRequest $request): TemplateSetResponse
    {
        return TemplateSetResponse::fromArray($this->client->call('/template/set.json', $request->toArray()));
    }

    /**
     * Gets template properties by it's id.
     *
     * @see https://docs.unione.io/en/web-api-ref#template-get
     *
     * @throws ApiException
     */
    public function get(TemplateGetRequest $request): TemplateGetResponse
    {
        return TemplateGetResponse::fromArray($this->client->call('/template/get.json', $request->toArray()));
    }

    /**
     * Returns the list of all or some templates of the account.
     *
     * You can iterate thru large list using "offset" and "limit" parameters. When less than "limit" templates are
     * returned then the end of list is reached.
     *
     * @see https://docs.unione.io/en/web-api-ref#template-list
     *
     * @throws ApiException
     */
    public function list(TemplateListRequest $request): TemplateListResponse
    {
        return TemplateListResponse::fromArray($this->client->call('/template/list.json', $request->toArray()));
    }

    /**
     * Deletes a template by id.
     *
     * @see https://docs.unione.io/en/web-api-ref#template-delete
     *
     * @throws ApiException
     */
    public function delete(TemplateDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/template/delete.json', $request->toArray()));
    }
}
