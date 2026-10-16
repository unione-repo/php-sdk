<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\VerificationRecordStatus;

/**
 * Object describing verification record value and status.
 */
final class DomainListResponseDomainsItemVerificationRecord implements \JsonSerializable
{
    public function __construct(
        /**
         * Record to be added "as is" to verify ownership of this domain.
         * Example: `unione-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
         */
        public ?string $value = null,
        /**
         * Only domains with "confirmed" verification record are allowed as sender domains.
         */
        public VerificationRecordStatus|string|null $status = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            value: Data::string($data['value'] ?? null),
            status: Data::enum(VerificationRecordStatus::class, Data::string($data['status'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'value' => $this->value,
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
