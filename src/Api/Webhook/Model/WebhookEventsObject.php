<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailStatus;

/**
 * Object containing events to notify of.
 */
final class WebhookEventsObject implements \JsonSerializable
{
    public function __construct(
        /**
         * If present then spam block events will be reported. Should contain single array element with "*" string.
         * @var list<string>|null
         */
        public ?array $spamBlock = null,
        /**
         * If present then email status change events will be reported. Contains names of statuses to notify of.
         * @var list<EmailStatus|string>|null
         */
        public ?array $emailStatus = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            spamBlock: Data::list($data['spam_block'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            emailStatus: Data::list($data['email_status'] ?? null, static fn ($item) => Data::enum(EmailStatus::class, Data::string($item) ?? '')),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'spam_block' => $this->spamBlock,
            'email_status' => Data::value($this->emailStatus),
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
