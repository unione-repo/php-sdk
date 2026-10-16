<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * EventDumpGetRequest
 */
final class EventDumpGetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Dump identifier received by the method
         * [event-dump/create](https://docs.unione.io/en/web-api-ref#event-dump-create).
         * Example: `Gqfasjh34tlasd`.
         */
        public string $dumpId,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dumpId: Data::string($data['dump_id'] ?? null) ?? '',
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'dump_id' => $this->dumpId,
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
