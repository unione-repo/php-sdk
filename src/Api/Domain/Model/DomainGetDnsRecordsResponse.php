<?php

declare(strict_types=1);

namespace UniOne\Api\Domain\Model;

use UniOne\Client\Data;

/**
 * DomainGetDnsRecordsResponse
 */
final class DomainGetDnsRecordsResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Domain to get DNS records for.
         * Example: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Record to be added "as is" to verify ownership of this domain.
         * Example: `unione-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
         */
        public ?string $verificationRecord = null,
        /**
         * DKIM signature for the domain. This property contains only the key part, you should prepend it with "v=DKIM1;
         * k=rsa; p=" for the TXT record to be valid.
         * Example: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
         */
        public ?string $dkim = null,
        /**
         * Target of the CNAME record for the "_dmarc" host of the domain.
         * Example: `example.com.dmarc.unione.io.`.
         */
        public ?string $dmarc = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            domain: Data::string($data['domain'] ?? null),
            verificationRecord: Data::string($data['verification-record'] ?? null),
            dkim: Data::string($data['dkim'] ?? null),
            dmarc: Data::string($data['dmarc'] ?? null),
        );
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
