<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpCreateRequest
 */
final class EventDumpCreateRequest implements \JsonSerializable
{
    /**
     * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period start time. Data is stored for up to 32 days,
     * depending on your tariff.
     * Example: `2022-07-20 00:00:00`.
     *
     * @var string
     */
    private $startTime;

    /**
     * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period end time (non-inclusive).
     * Example: `2022-07-21 00:00:00`.
     *
     * @var string|null
     */
    private $endTime;

    /**
     * Maximum number of events returned (default is 50). If this value is over 100 000, several files will be
     * created, each having 100 000 events maximum.
     * Example: `50`.
     *
     * @var int|null
     */
    private $limit;

    /**
     * For accounts with projects enabled, the value all_projects=true allows to fetch data for all existing
     * projects.
     * Default: `False`.
     *
     * @var bool|null
     */
    private $allProjects;

    /**
     * An object with the properties of the event dump filter.
     *
     * @var FilterObject|null
     */
    private $filter;

    /**
     * An array of strings containing the names of columns you need in your report, in your preferred order. If the
     * 'dump_fields' array is missing or empty, a default field list and order will be applied. Allowed values, in
     * their default order, are - 'project_id', 'event_time', 'job_id', 'from_email', 'email', 'status',
     * 'delivery_status', 'metadata', 'destination_response', 'user_agent', 'url', 'ip', 'tags'. For maximum
     * security, the 'subject' field is not included by default, but you can add it by explicitly including in the
     * 'dump_fields' array.
     *
     * @var list<string>|null
     */
    private $dumpFields;

    /**
     * Allows you to obtain aggregated statistics for a given time period. The two allowed values are:
     *
     * - __day_status__ - fetch aggregated statistics (the filter value must be missing or empty, as filters are not allowed with this option);
     * - __an empty string__ - used by default, event_dump/create works as if the aggregate parameter is omitted.
     * Example: `day_status`.
     *
     * @var string|null
     */
    private $aggregate;

    /**
     * Field delimiter, can be set to either  ',' or ';', defaults to  ','.
     * Example: `;`.
     *
     * @var string|null
     */
    private $delimiter;

    /**
     * File format, either “csv” (default) or “csv_gzip”.
     * Default: `csv`.
     * Example: `csv`.
     *
     * @var string|null
     */
    private $format;

    public function __construct(string $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(Data::string($data['start_time'] ?? null) ?? '');
        $model->endTime = Data::string($data['end_time'] ?? null);
        $model->limit = Data::int($data['limit'] ?? null);
        $model->allProjects = Data::bool($data['all_projects'] ?? null);
        $model->filter = Data::model(FilterObject::class, $data['filter'] ?? null);
        $model->dumpFields = Data::list($data['dump_fields'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->aggregate = Data::string($data['aggregate'] ?? null);
        $model->delimiter = Data::string($data['delimiter'] ?? null);
        $model->format = Data::string($data['format'] ?? null);

        return $model;
    }

    /**
     * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period start time.
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period start time.
     *
     * @return $this
     */
    public function setStartTime(string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period end time (non-inclusive).
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * Date and time in YYYY-MM-DD hh:mm:ss format, specifying period end time (non-inclusive).
     *
     * @return $this
     */
    public function setEndTime(?string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Maximum number of events returned (default is 50).
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Maximum number of events returned (default is 50).
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * For accounts with projects enabled, the value all_projects=true allows to fetch data for all existing
     * projects.
     */
    public function getAllProjects(): ?bool
    {
        return $this->allProjects;
    }

    /**
     * For accounts with projects enabled, the value all_projects=true allows to fetch data for all existing
     * projects.
     *
     * @return $this
     */
    public function setAllProjects(?bool $allProjects): self
    {
        $this->allProjects = $allProjects;

        return $this;
    }

    /**
     * An object with the properties of the event dump filter.
     */
    public function getFilter(): ?FilterObject
    {
        return $this->filter;
    }

    /**
     * An object with the properties of the event dump filter.
     *
     * @return $this
     */
    public function setFilter(?FilterObject $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * An array of strings containing the names of columns you need in your report, in your preferred order.
     *
     * @return list<string>|null
     */
    public function getDumpFields(): ?array
    {
        return $this->dumpFields;
    }

    /**
     * An array of strings containing the names of columns you need in your report, in your preferred order.
     *
     * @param list<string>|null $dumpFields
     *
     * @return $this
     */
    public function setDumpFields(?array $dumpFields): self
    {
        $this->dumpFields = $dumpFields;

        return $this;
    }

    /**
     * Allows you to obtain aggregated statistics for a given time period.
     */
    public function getAggregate(): ?string
    {
        return $this->aggregate;
    }

    /**
     * Allows you to obtain aggregated statistics for a given time period.
     *
     * @return $this
     */
    public function setAggregate(?string $aggregate): self
    {
        $this->aggregate = $aggregate;

        return $this;
    }

    /**
     * Field delimiter, can be set to either  ',' or ';', defaults to  ','.
     */
    public function getDelimiter(): ?string
    {
        return $this->delimiter;
    }

    /**
     * Field delimiter, can be set to either  ',' or ';', defaults to  ','.
     *
     * @return $this
     */
    public function setDelimiter(?string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * File format, either “csv” (default) or “csv_gzip”.
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * File format, either “csv” (default) or “csv_gzip”.
     *
     * @return $this
     */
    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
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
        ], static function ($value): bool {
            return $value !== null;
        });
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return Data::object($this->toArray());
    }
}
