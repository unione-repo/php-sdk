<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainListRequest
 */
final class DomainListRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Optional domain name if you want to get the status of single domain only.
         * Example: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Limits the number of domains returned. Default is 50.
         * Default: `50`.
         */
        public ?int $limit = null,
        /**
         * Index of the first domain in the list, starting with 0.
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
            domain: Data::string($data['domain'] ?? null),
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
            'domain' => $this->domain,
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
