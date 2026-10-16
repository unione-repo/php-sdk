<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionSetRequest
 */
final class SuppressionSetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Email to add in suppression list.
         * Example: `email@example.com`.
         */
        public string $email,
        /**
         * Cause of email being suppressed. One of:
         *
         * - __unsubscribed__ - email is unsubscribed;
         * - __temporary_unavailable__ - the email address is unavailable. This means that over the next three days sending to this address will return an error. Email may be temporarily unavailable due to several reasons, e.g.:
         *
         * - a previous email has been rejected by the recipient's server for spam;
         * - the recipient's mailbox is full or is not used;
         * - recipient's domain does not accept mail;
         * - sending server was rejected due to blacklisting;
         *
         * - __permanent_unavailable__ - the email address is permanently unavailable due to multiple hard bounces;
         * - __complained__ -  the recipient reported spam in the previous emails;
         * Example: `unsubscribed`.
         */
        public string $cause,
        /**
         * When suppression was created, in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
         * Example: `2021-12-19 10:15:49`.
         */
        public ?string $created = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Data::string($data['email'] ?? null) ?? '',
            cause: Data::string($data['cause'] ?? null) ?? '',
            created: Data::string($data['created'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'cause' => $this->cause,
            'created' => $this->created,
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
