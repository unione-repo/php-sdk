<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainGetDnsRecordsResponse
 */
final class DomainGetDnsRecordsResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Domain to get DNS records for.
     * Example: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Record to be added "as is" to verify ownership of this domain.
     * Example: `unione-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
     *
     * @var string|null
     */
    private $verificationRecord;

    /**
     * DKIM signature for the domain. This property contains only the key part, you should prepend it with "v=DKIM1;
     * k=rsa; p=" for the TXT record to be valid.
     * Example: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
     *
     * @var string|null
     */
    private $dkim;

    /**
     * Target of the CNAME record for the "_dmarc" host of the domain.
     * Example: `example.com.dmarc.unione.io.`.
     *
     * @var string|null
     */
    private $dmarc;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->verificationRecord = Data::string($data['verification-record'] ?? null);
        $model->dkim = Data::string($data['dkim'] ?? null);
        $model->dmarc = Data::string($data['dmarc'] ?? null);

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
     * Domain to get DNS records for.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Domain to get DNS records for.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Record to be added "as is" to verify ownership of this domain.
     */
    public function getVerificationRecord(): ?string
    {
        return $this->verificationRecord;
    }

    /**
     * Record to be added "as is" to verify ownership of this domain.
     *
     * @return $this
     */
    public function setVerificationRecord(?string $verificationRecord): self
    {
        $this->verificationRecord = $verificationRecord;

        return $this;
    }

    /**
     * DKIM signature for the domain.
     */
    public function getDkim(): ?string
    {
        return $this->dkim;
    }

    /**
     * DKIM signature for the domain.
     *
     * @return $this
     */
    public function setDkim(?string $dkim): self
    {
        $this->dkim = $dkim;

        return $this;
    }

    /**
     * Target of the CNAME record for the "_dmarc" host of the domain.
     */
    public function getDmarc(): ?string
    {
        return $this->dmarc;
    }

    /**
     * Target of the CNAME record for the "_dmarc" host of the domain.
     *
     * @return $this
     */
    public function setDmarc(?string $dmarc): self
    {
        $this->dmarc = $dmarc;

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
            'verification-record' => $this->verificationRecord,
            'dkim' => $this->dkim,
            'dmarc' => $this->dmarc,
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
