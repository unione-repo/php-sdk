<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookListRequest
 */
final class WebhookListRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Limits the number of webhooks returned. 50 is recommended.
         */
        public ?int $limit = null,
        /**
         * Index of the first webhook in the list, starting with 0.
         * Default: `0`.
         */
        public ?int $offset = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            limit: Data::int($data['limit'] ?? null),
            offset: Data::int($data['offset'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'limit' => $this->limit,
            'offset' => $this->offset,
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
