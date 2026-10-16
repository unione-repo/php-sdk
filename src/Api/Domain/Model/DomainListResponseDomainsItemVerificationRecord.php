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
    /**
     * Record to be added "as is" to verify ownership of this domain.
     * Example: `unione-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
     *
     * @var string|null
     */
    private $value;

    /**
     * Only domains with "confirmed" verification record are allowed as sender domains.
     * Values: `VerificationRecordStatus` constants.
     *
     * @var string|null
     */
    private $status;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->value = Data::string($data['value'] ?? null);
        $model->status = Data::string($data['status'] ?? null);

        return $model;
    }

    /**
     * Record to be added "as is" to verify ownership of this domain.
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Record to be added "as is" to verify ownership of this domain.
     *
     * @return $this
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Only domains with "confirmed" verification record are allowed as sender domains.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Only domains with "confirmed" verification record are allowed as sender domains.
     *
     * @param string|null $status Values: `VerificationRecordStatus` constants.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'value' => $this->value,
            'status' => $this->status,
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
