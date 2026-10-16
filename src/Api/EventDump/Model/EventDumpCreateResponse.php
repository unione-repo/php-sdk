<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpCreateResponse
 */
final class EventDumpCreateResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Dump identifier, used to call the [event-dump/get](https://docs.unione.io/en/web-api-ref#event-dump-get)
     * method.
     *
     * @var string|null
     */
    private $dumpId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->dumpId = Data::string($data['dump_id'] ?? null);

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
     * Dump identifier, used to call the [event-dump/get](https://docs.unione.io/en/web-api-ref#event-dump-get)
     * method.
     */
    public function getDumpId(): ?string
    {
        return $this->dumpId;
    }

    /**
     * Dump identifier, used to call the [event-dump/get](https://docs.unione.io/en/web-api-ref#event-dump-get)
     * method.
     *
     * @return $this
     */
    public function setDumpId(?string $dumpId): self
    {
        $this->dumpId = $dumpId;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'dump_id' => $this->dumpId,
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
