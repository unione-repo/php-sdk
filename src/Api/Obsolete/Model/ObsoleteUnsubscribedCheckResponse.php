<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedCheckResponse
 */
final class ObsoleteUnsubscribedCheckResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Email that was checked.
     *
     * @var string|null
     */
    private $address;

    /**
     * true if unsubscribed, false if not.
     *
     * @var bool|null
     */
    private $isUnsubscribed;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->address = Data::string($data['address'] ?? null);
        $model->isUnsubscribed = Data::bool($data['is_unsubscribed'] ?? null);

        return $model;
    }

    /**
     * "success" string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * "success" string
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Email that was checked.
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Email that was checked.
     *
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * true if unsubscribed, false if not.
     */
    public function getIsUnsubscribed(): ?bool
    {
        return $this->isUnsubscribed;
    }

    /**
     * true if unsubscribed, false if not.
     *
     * @return $this
     */
    public function setIsUnsubscribed(?bool $isUnsubscribed): self
    {
        $this->isUnsubscribed = $isUnsubscribed;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'address' => $this->address,
            'is_unsubscribed' => $this->isUnsubscribed,
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
