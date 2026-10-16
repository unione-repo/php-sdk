<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * Object describing DKIM record value and status.
 */
final class DomainListResponseDomainsItemDkim implements \JsonSerializable
{
    /**
     * DKIM signature for the domain. This property contains only the key part, you should prepend it with "k=rsa,
     * p=" part for the record to be valid (see
     * [domain/get-dns-records](https://docs.unione.io/en/web-api-ref#domain-get-dns-records)).
     * Example: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
     *
     * @var string|null
     */
    private $key;

    /**
     * Only domains with "active" DKIM record are allowed as sender domains.
     * Values: `DkimStatus` constants.
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
        $model->key = Data::string($data['key'] ?? null);
        $model->status = Data::string($data['status'] ?? null);

        return $model;
    }

    /**
     * DKIM signature for the domain.
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * DKIM signature for the domain.
     *
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Only domains with "active" DKIM record are allowed as sender domains.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Only domains with "active" DKIM record are allowed as sender domains.
     *
     * @param string|null $status Values: `DkimStatus` constants.
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
            'key' => $this->key,
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
