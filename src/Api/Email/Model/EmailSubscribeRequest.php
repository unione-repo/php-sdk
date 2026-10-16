<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * EmailSubscribeRequest
 */
final class EmailSubscribeRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Sender’s email on a confirmed domain. (Field alias "email_address_from" is supported, too).
         * Example: `email@example.com`.
         */
        public string $fromEmail,
        /**
         * Sender’s name. (Field alias "name_from" is supported, too).
         * Example: `Example`.
         */
        public string $fromName,
        /**
         * Recipient’s email. (Field alias "email_address_to" is supported, too).
         * Example: `email@example.com`.
         */
        public string $toEmail,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            fromEmail: Data::string($data['from_email'] ?? null) ?? '',
            fromName: Data::string($data['from_name'] ?? null) ?? '',
            toEmail: Data::string($data['to_email'] ?? null) ?? '',
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'to_email' => $this->toEmail,
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
