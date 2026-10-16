<?php

declare(strict_types=1);

namespace UniOne\Api\Tag;

use UniOne\Api\Tag\Model\TagDeleteRequest;
use UniOne\Api\Tag\Model\TagListResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * This family of methods is used to manage user-defined tags. Tags are used to categorize letters based on your
 * own criteria, e. g. to create a distinction between marketing and transactional letters or group together all
 * notifications for a particular order type. UniOne allows you to assign tags to all outgoing emails, and the
 * tags you’ve set may then be used to filter and analyze delivery statistics.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->tag()->list();
 * var_dump($response->getTags());
 * ```
 */
final class TagApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * This method returns the full list of user-defined tags. Does not receive any parameters.
     *
     * @see https://docs.unione.io/en/web-api-ref#tag-list
     *
     * @throws ApiException
     */
    public function list(): TagListResponse
    {
        return TagListResponse::fromArray($this->client->call('/tag/list.json'));
    }

    /**
     * Removes tag.
     *
     * @see https://docs.unione.io/en/web-api-ref#tag-delete
     *
     * @throws ApiException
     */
    public function delete(TagDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/tag/delete.json', $request->toArray()));
    }
}
