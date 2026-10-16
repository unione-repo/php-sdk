<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainListResponse
 */
final class DomainListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Array of objects describing domains.
         * @var list<DomainListResponseDomainsItem>|null
         */
        public ?array $domains = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            domains: Data::list($data['domains'] ?? null, static fn ($item) => DomainListResponseDomainsItem::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'domains' => null === $this->domains ? null : \array_map(static fn (DomainListResponseDomainsItem $item) => Data::object($item->toArray()), $this->domains),
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
