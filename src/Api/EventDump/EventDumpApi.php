<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump;

use UniOne\Api\EventDump\Model\EventDumpCreateRequest;
use UniOne\Api\EventDump\Model\EventDumpCreateResponse;
use UniOne\Api\EventDump\Model\EventDumpDeleteRequest;
use UniOne\Api\EventDump\Model\EventDumpGetRequest;
use UniOne\Api\EventDump\Model\EventDumpGetResponse;
use UniOne\Api\EventDump\Model\EventDumpListResponse;
use UniOne\Client\ApiClient;
use UniOne\Client\ApiException;
use UniOne\Common\Model\SuccessResponse;

/**
 * These methods are used to obtain a list of events for a given period of time. The data is stored for up to 45
 * days, depending on your tariff, i. e. you may fetch all event data starting from 00:00:00 31 days ago and up
 * to current time. For custom tarifs with big sending volumes event dumps are available only for the last 7
 * days.
 *
 * Example:
 *
 * ```php
 * $client = UniOne::client('YOUR_API_KEY');
 *
 * $response = $client->eventDump()->create((new EventDumpCreateRequest('2022-07-20 00:00:00'))
 *     ->setEndTime('2022-07-21 00:00:00')
 *     ->setLimit(50)
 *     ->setDumpFields(['string1'])
 *     ->setAggregate('day_status')
 *     ->setDelimiter(';')
 *     ->setFormat('csv'));
 * echo $response->getDumpId(), PHP_EOL;
 * ```
 */
final class EventDumpApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * This asynchronous method initiates the preparation of data dump in CSV format. The number of dump files
     * created or stored is limited to 10; to order more files, you have to delete one of the previous ones or wait
     * until they will be deleted automatically. A newly created dump file is kept for 8 hours. If the request period
     * is more than a day or there are too many events then several files will be generated and each file will
     * contain no more than 100,000 events. File contains columns with the following information - 'event_time',
     * 'job_id', 'from_email', 'email', 'status', 'delivery_status', 'metadata', 'destination_response',
     * 'user_agent', 'url', 'ip', 'tags' and 'project_id' (for accounts with projects enabled). You can change the
     * fields and include 'subject' field using 'dump_fileds' parameter.
     *
     * @see https://docs.unione.io/en/web-api-ref#event-dump-create
     *
     * @throws ApiException
     */
    public function create(EventDumpCreateRequest $request): EventDumpCreateResponse
    {
        return EventDumpCreateResponse::fromArray($this->client->call('/event-dump/create.json', $request->toArray()));
    }

    /**
     * Returns dump properties for a given identifier
     *
     * @see https://docs.unione.io/en/web-api-ref#event-dump-get
     *
     * @throws ApiException
     */
    public function get(EventDumpGetRequest $request): EventDumpGetResponse
    {
        return EventDumpGetResponse::fromArray($this->client->call('/event-dump/get.json', $request->toArray()));
    }

    /**
     * This method does not require any parameters; returns the full list of existing dumps.
     *
     * @see https://docs.unione.io/en/web-api-ref#event-dump-list
     *
     * @throws ApiException
     */
    public function list(): EventDumpListResponse
    {
        return EventDumpListResponse::fromArray($this->client->call('/event-dump/list.json'));
    }

    /**
     * Removes dump from queue or storage.
     *
     * @see https://docs.unione.io/en/web-api-ref#event-dump-delete
     *
     * @throws ApiException
     */
    public function delete(EventDumpDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/event-dump/delete.json', $request->toArray()));
    }
}
