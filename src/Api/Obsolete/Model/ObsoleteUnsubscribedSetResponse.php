<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedSetResponse
 */
final class ObsoleteUnsubscribedSetResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * The unsubscribed email.
         */
        public ?string $address = null,
        /**
         * Unsubscription process details:
         *
         * - "unsubscribed" if email has just been unsubscribed,
         * - "was inactive" if it was inactive due some reason,
         * - "was unsubscribed" if it already was unsubscribed before the call,
         * - "added and unsubscribed" if it's a new email without status history and it was added and then unsubscribed immediately.
         */
        public ObsoleteUnsubscribedSetMessage|string|null $message = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            address: Data::string($data['address'] ?? null),
            message: Data::enum(ObsoleteUnsubscribedSetMessage::class, Data::string($data['message'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'address' => $this->address,
            'message' => Data::value($this->message),
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
