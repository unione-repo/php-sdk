<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpCreateRequest
 */
final class EventDumpCreateRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period start time. Data is stored for up to 32 days,
         * depending on your tariff.
         * Example: `2022-07-20 00:00:00`.
         */
        public string $startTime,
        /**
         * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period end time (non-inclusive).
         * Example: `2022-07-21 00:00:00`.
         */
        public ?string $endTime = null,
        /**
         * Maximum number of events returned (default is 50). If this value is over 100 000, several files will be
         * created, each having 100 000 events maximum.
         * Example: `50`.
         */
        public ?int $limit = null,
        /**
         * For accounts with projects enabled, the value all_projects=true allows to fetch data for all existing
         * projects.
         * Default: `False`.
         */
        public ?bool $allProjects = null,
        /**
         * An object with the properties of the event dump filter.
         */
        public ?FilterObject $filter = null,
        /**
         * An array of strings containing the names of columns you need in your report, in your preferred order. If the
         * 'dump_fields' array is missing or empty, a default field list and order will be applied. Allowed values, in
         * their default order, are - 'project_id', 'event_time', 'job_id', 'from_email', 'email', 'status',
         * 'delivery_status', 'metadata', 'destination_response', 'user_agent', 'url', 'ip', 'tags'. For maximum
         * security, the 'subject' field is not included by default, but you can add it by explicitly including in the
         * 'dump_fields' array.
         * @var list<string>|null
         */
        public ?array $dumpFields = null,
        /**
         * Allows you to obtain aggregated statistics for a given time period. The two allowed values are:
         *
         * - __day_status__ - fetch aggregated statistics (the filter value must be missing or empty, as filters are not allowed with this option);
         * - __an empty string__ - used by default, event_dump/create works as if the aggregate parameter is omitted.
         * Example: `day_status`.
         */
        public ?string $aggregate = null,
        /**
         * Field delimiter, can be set to either  ',' or ';', defaults to  ','.
         * Example: `;`.
         */
        public ?string $delimiter = null,
        /**
         * File format, either “csv” (default) or “csv_gzip”.
         * Default: `csv`.
         * Example: `csv`.
         */
        public ?string $format = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            startTime: Data::string($data['start_time'] ?? null) ?? '',
            endTime: Data::string($data['end_time'] ?? null),
            limit: Data::int($data['limit'] ?? null),
            allProjects: Data::bool($data['all_projects'] ?? null),
            filter: Data::model(FilterObject::class, $data['filter'] ?? null),
            dumpFields: Data::list($data['dump_fields'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            aggregate: Data::string($data['aggregate'] ?? null),
            delimiter: Data::string($data['delimiter'] ?? null),
            format: Data::string($data['format'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'limit' => $this->limit,
            'all_projects' => $this->allProjects,
            'filter' => null === $this->filter ? null : Data::object($this->filter->toArray()),
            'dump_fields' => $this->dumpFields,
            'aggregate' => $this->aggregate,
            'delimiter' => $this->delimiter,
            'format' => $this->format,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
