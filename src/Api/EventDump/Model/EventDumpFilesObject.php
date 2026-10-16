<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * An object with the properties of the event dump file.
 */
final class EventDumpFilesObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Use this unique URL to download the requested dump file (either .csv or .csv.gz, depending on your request).
         * Example: `https://eu1.unione.io/event-dump/Agejmh63Efmngaow4tDFGqwqt-1.csv`.
         */
        public ?string $url = null,
        /**
         * File size.
         * Example: `512345`.
         */
        public ?int $size = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: Data::string($data['url'] ?? null),
            size: Data::int($data['size'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'url' => $this->url,
            'size' => $this->size,
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
