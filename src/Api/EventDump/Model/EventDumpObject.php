<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * An object with the properties of the event dump.
 */
final class EventDumpObject implements \JsonSerializable
{
    /**
     * Dump ID received by the method [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create).
     * Example: `Gqfasjh34tlasd`.
     *
     * @var string|null
     */
    private $dumpId;

    /**
     * Task status, possible values are:
     *
     * - __queued__ - the task is in the queue, processing is not started yet;
     * - __in_process__ - the request is being processed;
     * - __ready__ - the task is finished, dump file is ready for download;
     * - __failed__ -  processing failed due to an internal error.
     * Example: `in_process`.
     *
     * @var string|null
     */
    private $dumpStatus;

    /**
     * An array of objects, each representing a file, ready for download. You may start downloading everything listed
     * in “files” even if "dump_status" is still "in_process". If there are no events, according to the specified
     * parameters, an empty array will be returned.
     *
     * @var list<EventDumpFilesObject>|null
     */
    private $files;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->dumpId = Data::string($data['dump_id'] ?? null);
        $model->dumpStatus = Data::string($data['dump_status'] ?? null);
        $model->files = Data::list($data['files'] ?? null, static function ($item) { return EventDumpFilesObject::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * Dump ID received by the method [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create).
     */
    public function getDumpId(): ?string
    {
        return $this->dumpId;
    }

    /**
     * Dump ID received by the method [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create).
     *
     * @return $this
     */
    public function setDumpId(?string $dumpId): self
    {
        $this->dumpId = $dumpId;

        return $this;
    }

    /**
     * Task status, possible values are:
     */
    public function getDumpStatus(): ?string
    {
        return $this->dumpStatus;
    }

    /**
     * Task status, possible values are:
     *
     * @return $this
     */
    public function setDumpStatus(?string $dumpStatus): self
    {
        $this->dumpStatus = $dumpStatus;

        return $this;
    }

    /**
     * An array of objects, each representing a file, ready for download.
     *
     * @return list<EventDumpFilesObject>|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * An array of objects, each representing a file, ready for download.
     *
     * @param list<EventDumpFilesObject>|null $files
     *
     * @return $this
     */
    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'dump_id' => $this->dumpId,
            'dump_status' => $this->dumpStatus,
            'files' => null === $this->files ? null : \array_map(static function (EventDumpFilesObject $item) { return Data::object($item->toArray()); }, $this->files),
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
