<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * Object describing DKIM record value and status.
 */
final class DomainListResponseDomainsItemDkim implements \JsonSerializable
{
    public function __construct(
        /**
         * DKIM signature for the domain. This property contains only the key part, you should prepend it with "k=rsa,
         * p=" part for the record to be valid (see
         * [domain/get-dns-records](https://docs.unione.io/en/web-api-ref#domain-get-dns-records)).
         * Example: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
         */
        public ?string $key = null,
        /**
         * Only domains with "active" DKIM record are allowed as sender domains.
         */
        public DkimStatus|string|null $status = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            key: Data::string($data['key'] ?? null),
            status: Data::enum(DkimStatus::class, Data::string($data['status'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'key' => $this->key,
            'status' => Data::value($this->status),
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
