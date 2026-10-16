<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainListResponseDomainsItem
 */
final class DomainListResponseDomainsItem implements \JsonSerializable
{
    /**
     * Domain name.
     * Example: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Object describing verification record value and status.
     *
     * @var DomainListResponseDomainsItemVerificationRecord|null
     */
    private $verificationRecord;

    /**
     * Object describing DKIM record value and status.
     *
     * @var DomainListResponseDomainsItemDkim|null
     */
    private $dkim;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->domain = Data::string($data['domain'] ?? null);
        $model->verificationRecord = Data::model(DomainListResponseDomainsItemVerificationRecord::class, $data['verification-record'] ?? null);
        $model->dkim = Data::model(DomainListResponseDomainsItemDkim::class, $data['dkim'] ?? null);

        return $model;
    }

    /**
     * Domain name.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Domain name.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Object describing verification record value and status.
     */
    public function getVerificationRecord(): ?DomainListResponseDomainsItemVerificationRecord
    {
        return $this->verificationRecord;
    }

    /**
     * Object describing verification record value and status.
     *
     * @return $this
     */
    public function setVerificationRecord(?DomainListResponseDomainsItemVerificationRecord $verificationRecord): self
    {
        $this->verificationRecord = $verificationRecord;

        return $this;
    }

    /**
     * Object describing DKIM record value and status.
     */
    public function getDkim(): ?DomainListResponseDomainsItemDkim
    {
        return $this->dkim;
    }

    /**
     * Object describing DKIM record value and status.
     *
     * @return $this
     */
    public function setDkim(?DomainListResponseDomainsItemDkim $dkim): self
    {
        $this->dkim = $dkim;

        return $this;
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
