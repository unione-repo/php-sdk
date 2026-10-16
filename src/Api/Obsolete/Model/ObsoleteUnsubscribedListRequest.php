<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedListRequest
 */
final class ObsoleteUnsubscribedListRequest implements \JsonSerializable
{
    /**
     * Date in the format YYYY-MM-DD to get all unsubscribed emails from the "date_from" to the present day. If the
     * parameter is not specified, the default period is today (from 00:00 UTC).
     * Example: `2020-10-14`.
     *
     * @var string|null
     */
    private $dateFrom;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->dateFrom = Data::string($data['date_from'] ?? null);

        return $model;
    }

    /**
     * Date in the format YYYY-MM-DD to get all unsubscribed emails from the "date_from" to the present day.
     */
    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    /**
     * Date in the format YYYY-MM-DD to get all unsubscribed emails from the "date_from" to the present day.
     *
     * @return $this
     */
    public function setDateFrom(?string $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'date_from' => $this->dateFrom,
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
