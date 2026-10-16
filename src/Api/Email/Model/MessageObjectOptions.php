<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * Additional message options.
 */
final class MessageObjectOptions implements \JsonSerializable
{
    public function __construct(
        /**
         * Date and time in "YYYY-MM-DD hh:mm:ss" format in the UTC timezone. Allows schedule sending up to 24 hours in
         * advance.
         * Example: `2021-11-19 10:00:00`.
         */
        public ?string $sendAt = null,
        /**
         * Custom unsubscribe link. Read more [here](https://docs.unione.io/en/unsubscribe-link).
         * Example: `https://example.org/unsubscribe/&#7b;&#7b;CustomerId&#7c;&#7c;`.
         */
        public ?string $unsubscribeUrl = null,
        /**
         * Backend-domain identifier to send message with. If custom_backend_id is not set, default one for your
         * account/project will be used. You can pay for one or more dedicated IPs and use this option.
         */
        public ?int $customBackendId = null,
        /**
         * SMTP pool identifier to send message with. Usually you don't need to pass this parameter because correct
         * smtp_pool_id is selected automatically based on the default one for your account/project or according to
         * custom_backend_id parameter.
         */
        public ?string $smtpPoolId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sendAt: Data::string($data['send_at'] ?? null),
            unsubscribeUrl: Data::string($data['unsubscribe_url'] ?? null),
            customBackendId: Data::int($data['custom_backend_id'] ?? null),
            smtpPoolId: Data::string($data['smtp_pool_id'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'send_at' => $this->sendAt,
            'unsubscribe_url' => $this->unsubscribeUrl,
            'custom_backend_id' => $this->customBackendId,
            'smtp_pool_id' => $this->smtpPoolId,
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
