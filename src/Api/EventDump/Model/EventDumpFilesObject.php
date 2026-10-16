<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;

/**
 * An object with the properties of the event dump file.
 */
final class EventDumpFilesObject implements \JsonSerializable
{
    /**
     * Use this unique URL to download the requested dump file (either .csv or .csv.gz, depending on your request).
     * Example: `https://eu1.unione.io/event-dump/Agejmh63Efmngaow4tDFGqwqt-1.csv`.
     *
     * @var string|null
     */
    private $url;

    /**
     * File size.
     * Example: `512345`.
     *
     * @var int|null
     */
    private $size;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->url = Data::string($data['url'] ?? null);
        $model->size = Data::int($data['size'] ?? null);

        return $model;
    }

    /**
     * Use this unique URL to download the requested dump file (either .csv or .csv.gz, depending on your request).
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Use this unique URL to download the requested dump file (either .csv or .csv.gz, depending on your request).
     *
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * File size.
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * File size.
     *
     * @return $this
     */
    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'url' => $this->url,
            'size' => $this->size,
        ], static function ($value): bool {
            return $value !== null;
        });
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return Data::object($this->toArray());
    }
}
