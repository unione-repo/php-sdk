<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainGetSandboxDomainResponse
 */
final class DomainGetSandboxDomainResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Sandbox domain name.
     * Example: `sandbox-123456-a1b2c3.unione.io`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);

        return $model;
    }

    /**
     * "success" string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * "success" string
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Sandbox domain name.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Sandbox domain name.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
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
            'status' => $this->status,
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
