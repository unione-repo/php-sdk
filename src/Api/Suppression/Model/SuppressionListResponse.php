<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionListResponse
 */
final class SuppressionListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Array of suppression objects.
         * @var list<SuppressionListObject>|null
         */
        public ?array $suppressions = null,
        /**
         * The parameter indicates from which position the selection is to be started. Must be empty or omitted for the
         * first data chunk. In order to get subsequent chunks, you must set the "cursor" parameter in your request,
         * using the value received in response to the previous request.
         * Example: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
         */
        public ?string $cursor = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            suppressions: Data::list($data['suppressions'] ?? null, static fn ($item) => SuppressionListObject::fromArray(Data::array($item) ?? [])),
            cursor: Data::string($data['cursor'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'suppressions' => null === $this->suppressions ? null : \array_map(static fn (SuppressionListObject $item) => Data::object($item->toArray()), $this->suppressions),
            'cursor' => $this->cursor,
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
