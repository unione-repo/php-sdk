<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainListRequest
 */
final class DomainListRequest implements \JsonSerializable
{
    /**
     * Optional domain name if you want to get the status of single domain only.
     * Example: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Limits the number of domains returned. Default is 50.
     * Default: `50`.
     *
     * @var int|null
     */
    private $limit;

    /**
     * Index of the first domain in the list, starting with 0.
     * Default: `0`.
     *
     * @var int|null
     */
    private $offset;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->domain = Data::string($data['domain'] ?? null);
        $model->limit = Data::int($data['limit'] ?? null);
        $model->offset = Data::int($data['offset'] ?? null);

        return $model;
    }

    /**
     * Optional domain name if you want to get the status of single domain only.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Optional domain name if you want to get the status of single domain only.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Limits the number of domains returned.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Limits the number of domains returned.
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Index of the first domain in the list, starting with 0.
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Index of the first domain in the list, starting with 0.
     *
     * @return $this
     */
    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
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
