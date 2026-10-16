<?php

declare(strict_types=1);

namespace UniOne\Api\System\Model;

use UniOne\Client\Data;

/**
 * Object with accounting period properties. Present only if the API key used for request is the user API key.
 */
final class SystemInfoResponseAccounting implements \JsonSerializable
{
    public function __construct(
        /**
         * Date and time of accounting period start in UTC in "YYYY-MM-DD hh:mm:ss" format.
         * Example: `2016-08-29 09:12:33`.
         */
        public ?string $periodStart = null,
        /**
         * Date and time of accounting period end in UTC in "YYYY-MM-DD hh:mm:ss" format.
         * Example: `2016-09-29 09:12:33`.
         */
        public ?string $periodEnd = null,
        /**
         * Number of emails included into accounting period.
         */
        public ?int $emailsIncluded = null,
        /**
         * Number of emails sent during accounting period. Can be bigger than emails_included in case of overage.
         */
        public ?int $emailsSent = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            periodStart: Data::string($data['period_start'] ?? null),
            periodEnd: Data::string($data['period_end'] ?? null),
            emailsIncluded: Data::int($data['emails_included'] ?? null),
            emailsSent: Data::int($data['emails_sent'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'period_start' => $this->periodStart,
            'period_end' => $this->periodEnd,
            'emails_included' => $this->emailsIncluded,
            'emails_sent' => $this->emailsSent,
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
