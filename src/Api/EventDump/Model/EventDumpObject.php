<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * An object with the properties of the event dump.
 */
final class EventDumpObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Dump ID received by the method [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create).
         * Example: `Gqfasjh34tlasd`.
         */
        public ?string $dumpId = null,
        /**
         * Task status, possible values are:
         *
         * - __queued__ - the task is in the queue, processing is not started yet;
         * - __in_process__ - the request is being processed;
         * - __ready__ - the task is finished, dump file is ready for download;
         * - __failed__ -  processing failed due to an internal error.
         * Example: `in_process`.
         */
        public ?string $dumpStatus = null,
        /**
         * An array of objects, each representing a file, ready for download. You may start downloading everything listed
         * in “files” even if "dump_status" is still "in_process". If there are no events, according to the specified
         * parameters, an empty array will be returned.
         * @var list<EventDumpFilesObject>|null
         */
        public ?array $files = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dumpId: Data::string($data['dump_id'] ?? null),
            dumpStatus: Data::string($data['dump_status'] ?? null),
            files: Data::list($data['files'] ?? null, static fn ($item) => EventDumpFilesObject::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'dump_id' => $this->dumpId,
            'dump_status' => $this->dumpStatus,
            'files' => null === $this->files ? null : \array_map(static fn (EventDumpFilesObject $item) => Data::object($item->toArray()), $this->files),
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
