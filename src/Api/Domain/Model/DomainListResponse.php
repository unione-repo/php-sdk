<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainListResponse
 */
final class DomainListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Array of objects describing domains.
     *
     * @var list<DomainListResponseDomainsItem>|null
     */
    private $domains;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->domains = Data::list($data['domains'] ?? null, static function ($item) { return DomainListResponseDomainsItem::fromArray(Data::array($item) ?? []); });

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
     * Array of objects describing domains.
     *
     * @return list<DomainListResponseDomainsItem>|null
     */
    public function getDomains(): ?array
    {
        return $this->domains;
    }

    /**
     * Array of objects describing domains.
     *
     * @param list<DomainListResponseDomainsItem>|null $domains
     *
     * @return $this
     */
    public function setDomains(?array $domains): self
    {
        $this->domains = $domains;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'domains' => null === $this->domains ? null : \array_map(static function (DomainListResponseDomainsItem $item) { return Data::object($item->toArray()); }, $this->domains),
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
