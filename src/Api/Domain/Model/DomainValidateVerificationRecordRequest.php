<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainValidateVerificationRecordRequest
 */
final class DomainValidateVerificationRecordRequest implements \JsonSerializable
{
    /**
     * Domain to validate verification record for.
     * Example: `example.com`.
     *
     * @var string
     */
    private $domain;

    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::string($data['domain'] ?? null) ?? '');
    }

    /**
     * Domain to validate verification record for.
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Domain to validate verification record for.
     *
     * @return $this
     */
    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'domain' => $this->domain,
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
