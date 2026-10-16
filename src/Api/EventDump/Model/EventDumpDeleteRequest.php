<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpDeleteRequest
 */
final class EventDumpDeleteRequest implements \JsonSerializable
{
    /**
     * Dump identifier, obtained via the [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create)
     * method.
     * Example: `Gqfasjh34tlasd`.
     *
     * @var string
     */
    private $dumpId;

    public function __construct(string $dumpId)
    {
        $this->dumpId = $dumpId;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::string($data['dump_id'] ?? null) ?? '');
    }

    /**
     * Dump identifier, obtained via the [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create)
     * method.
     */
    public function getDumpId(): string
    {
        return $this->dumpId;
    }

    /**
     * Dump identifier, obtained via the [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create)
     * method.
     *
     * @return $this
     */
    public function setDumpId(string $dumpId): self
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
