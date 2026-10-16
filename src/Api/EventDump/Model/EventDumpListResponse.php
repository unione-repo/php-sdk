<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpListResponse
 */
final class EventDumpListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * An array of objects describing event dumps. Each object is similar to 'event_dump' object returned by the
     * [event-dump/get](https://docs.unione.io/en/web-api-ref#event-dump-get) method.
     *
     * @var list<EventDumpObject>|null
     */
    private $eventDumps;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->eventDumps = Data::list($data['event_dumps'] ?? null, static function ($item) { return EventDumpObject::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * "success" string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * "success" string
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * An array of objects describing event dumps.
     *
     * @return list<EventDumpObject>|null
     */
    public function getEventDumps(): ?array
    {
        return $this->eventDumps;
    }

    /**
     * An array of objects describing event dumps.
     *
     * @param list<EventDumpObject>|null $eventDumps
     *
     * @return $this
     */
    public function setEventDumps(?array $eventDumps): self
    {
        $this->eventDumps = $eventDumps;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'event_dumps' => null === $this->eventDumps ? null : \array_map(static function (EventDumpObject $item) { return Data::object($item->toArray()); }, $this->eventDumps),
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
