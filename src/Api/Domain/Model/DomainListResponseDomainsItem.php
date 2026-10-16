<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainListResponseDomainsItem
 */
final class DomainListResponseDomainsItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Domain name.
         * Example: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Object describing verification record value and status.
         */
        public ?DomainListResponseDomainsItemVerificationRecord $verificationRecord = null,
        /**
         * Object describing DKIM record value and status.
         */
        public ?DomainListResponseDomainsItemDkim $dkim = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            domain: Data::string($data['domain'] ?? null),
            verificationRecord: Data::model(DomainListResponseDomainsItemVerificationRecord::class, $data['verification-record'] ?? null),
            dkim: Data::model(DomainListResponseDomainsItemDkim::class, $data['dkim'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'domain' => $this->domain,
            'verification-record' => null === $this->verificationRecord ? null : Data::object($this->verificationRecord->toArray()),
            'dkim' => null === $this->dkim ? null : Data::object($this->dkim->toArray()),
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
