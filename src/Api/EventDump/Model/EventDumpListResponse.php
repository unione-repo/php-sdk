<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpListResponse
 */
final class EventDumpListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * An array of objects describing event dumps. Each object is similar to 'event_dump' object returned by the
         * [event-dump/get](https://docs.unione.io/en/web-api-ref#event-dump-get) method.
         * @var list<EventDumpObject>|null
         */
        public ?array $eventDumps = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            eventDumps: Data::list($data['event_dumps'] ?? null, static fn ($item) => EventDumpObject::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'event_dumps' => null === $this->eventDumps ? null : \array_map(static fn (EventDumpObject $item) => Data::object($item->toArray()), $this->eventDumps),
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
