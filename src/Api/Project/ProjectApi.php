<?php

declare(strict_types=1);

namespace UniOne\Api\Project;

use UniOne\Api\Project\Model\ProjectCreateRequest;
use UniOne\Api\Project\Model\ProjectCreateResponse;
use UniOne\Api\Project\Model\ProjectDeleteRequest;
use UniOne\Api\Project\Model\ProjectListRequest;
use UniOne\Api\Project\Model\ProjectListResponse;
use UniOne\Api\Project\Model\ProjectUpdateRequest;
use UniOne\Api\Project\Model\ProjectUpdateResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * Projects allow you to group several independent domains, webhooks, templates, and unsubscription lists
 * together. It's very useful if you have your own clients and manage their data from a single UniOne account.
 * Each project receives its own API key, and all API calls with that API key only deal with the data of that
 * project. This way, you can assign a separate project for each client and be sure that they won't conflict;
 * e.g. unsubscribing from one project won't affect another.
 *
 * Projects methods are disabled by default due to antispam measures. To enable them, [contact
 * support](https://cp.unione.io/en/support).
 *
 * Please note that sending domains are confirmed and used on per-project basis by default. But it's possible to
 * allow projects to send emails from domains confirmed for main account - just [ask
 * support](https://cp.unione.io/en/support) to enable it.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->project()->create(new ProjectCreateRequest(
 *     (new ProjectObject('Project 1A'))
 *         ->setCountry('ES')
 *         ->setBackendDomainId(1234)
 *         ->setUnsubscribePageId(1)
 * ));
 * echo $response->getProjectId(), PHP_EOL;
 * ```
 */
final class ProjectApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Creates a new project.
     *
     * @see https://docs.unione.io/en/web-api-ref#project-create
     *
     * @throws ApiException
     */
    public function create(ProjectCreateRequest $request): ProjectCreateResponse
    {
        return ProjectCreateResponse::fromArray($this->client->call('/project/create.json', $request->toArray()));
    }

    /**
     * Updates a project.
     *
     * @see https://docs.unione.io/en/web-api-ref#project-update
     *
     * @throws ApiException
     */
    public function update(ProjectUpdateRequest $request): ProjectUpdateResponse
    {
        return ProjectUpdateResponse::fromArray($this->client->call('/project/update.json', $request->toArray()));
    }

    /**
     * Lists projects.
     *
     * @see https://docs.unione.io/en/web-api-ref#project-list
     *
     * @throws ApiException
     */
    public function list(ProjectListRequest $request): ProjectListResponse
    {
        return ProjectListResponse::fromArray($this->client->call('/project/list.json', $request->toArray()));
    }

    /**
     * Deletes a project.
     *
     * The project will be moved to the "trash bin" before being permanently deleted. You can restore the project by
     * contacting support.
     *
     * @see https://docs.unione.io/en/web-api-ref#project-delete
     *
     * @throws ApiException
     */
    public function delete(ProjectDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/project/delete.json', $request->toArray()));
    }
}
