<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpGetResponse
 */
final class EventDumpGetResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * An object with the properties of the event dump.
     *
     * @var EventDumpObject|null
     */
    private $eventDump;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->eventDump = Data::model(EventDumpObject::class, $data['event_dump'] ?? null);

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
     * An object with the properties of the event dump.
     */
    public function getEventDump(): ?EventDumpObject
    {
        return $this->eventDump;
    }

    /**
     * An object with the properties of the event dump.
     *
     * @return $this
     */
    public function setEventDump(?EventDumpObject $eventDump): self
    {
        $this->eventDump = $eventDump;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'event_dump' => null === $this->eventDump ? null : Data::object($this->eventDump->toArray()),
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
