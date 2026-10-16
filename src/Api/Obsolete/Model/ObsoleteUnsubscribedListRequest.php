<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedListRequest
 */
final class ObsoleteUnsubscribedListRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Date in the format YYYY-MM-DD to get all unsubscribed emails from the "date_from" to the present day. If the
         * parameter is not specified, the default period is today (from 00:00 UTC).
         * Example: `2020-10-14`.
         */
        public ?string $dateFrom = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateFrom: Data::string($data['date_from'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'date_from' => $this->dateFrom,
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
