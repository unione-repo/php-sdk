<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedSetResponse
 */
final class ObsoleteUnsubscribedSetResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * The unsubscribed email.
     *
     * @var string|null
     */
    private $address;

    /**
     * Unsubscription process details:
     *
     * - "unsubscribed" if email has just been unsubscribed,
     * - "was inactive" if it was inactive due some reason,
     * - "was unsubscribed" if it already was unsubscribed before the call,
     * - "added and unsubscribed" if it's a new email without status history and it was added and then unsubscribed immediately.
     * Values: `ObsoleteUnsubscribedSetMessage` constants.
     *
     * @var string|null
     */
    private $message;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->address = Data::string($data['address'] ?? null);
        $model->message = Data::string($data['message'] ?? null);

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
     * The unsubscribed email.
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * The unsubscribed email.
     *
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Unsubscription process details:
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Unsubscription process details:
     *
     * @param string|null $message Values: `ObsoleteUnsubscribedSetMessage` constants.
     *
     * @return $this
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

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
            'message' => $this->message,
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
