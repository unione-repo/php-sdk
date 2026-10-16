<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedListResponseUnsubscribedItem
 */
final class ObsoleteUnsubscribedListResponseUnsubscribedItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Unsubscribed email.
         */
        public ?string $address = null,
        /**
         * Date and time when a recipient unsubscribed, in UTC timezone and "YYYY-MM-DD hh:mm:ss" format.
         * Example: `2020-10-15 22:14:59`.
         */
        public ?string $unsubscribedOn = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            address: Data::string($data['address'] ?? null),
            unsubscribedOn: Data::string($data['unsubscribed_on'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'address' => $this->address,
            'unsubscribed_on' => $this->unsubscribedOn,
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
