<?php

declare(strict_types=1);

namespace UniOne\Api\System\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailCounterMode;

/**
 * Object with email counter properties. Present only if the API key used for request is the user API key.
 */
final class ProjectAccountingObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Project's email counter value. It increases on every email sent.
         */
        public ?int $emailCounter = null,
        /**
         * Allows you to limit the number of emails sent by the project. The sending stops when the limit is reached. Any
         * non-negative 64-bit integer is acceptable. 0 means no limit.
         */
        public ?int $emailCounterLimit = null,
        /**
         * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
         * the counter never resets automatically.
         * Default: `default`.
         */
        public EmailCounterMode|string|null $emailCounterMode = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            emailCounter: Data::int($data['email_counter'] ?? null),
            emailCounterLimit: Data::int($data['email_counter_limit'] ?? null),
            emailCounterMode: Data::enum(EmailCounterMode::class, Data::string($data['email_counter_mode'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => Data::value($this->emailCounterMode),
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
