<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedListResponseUnsubscribedItem
 */
final class ObsoleteUnsubscribedListResponseUnsubscribedItem implements \JsonSerializable
{
    /**
     * Unsubscribed email.
     *
     * @var string|null
     */
    private $address;

    /**
     * Date and time when a recipient unsubscribed, in UTC timezone and "YYYY-MM-DD hh:mm:ss" format.
     * Example: `2020-10-15 22:14:59`.
     *
     * @var string|null
     */
    private $unsubscribedOn;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->address = Data::string($data['address'] ?? null);
        $model->unsubscribedOn = Data::string($data['unsubscribed_on'] ?? null);

        return $model;
    }

    /**
     * Unsubscribed email.
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Unsubscribed email.
     *
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Date and time when a recipient unsubscribed, in UTC timezone and "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getUnsubscribedOn(): ?string
    {
        return $this->unsubscribedOn;
    }

    /**
     * Date and time when a recipient unsubscribed, in UTC timezone and "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setUnsubscribedOn(?string $unsubscribedOn): self
    {
        $this->unsubscribedOn = $unsubscribedOn;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'address' => $this->address,
            'unsubscribed_on' => $this->unsubscribedOn,
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
