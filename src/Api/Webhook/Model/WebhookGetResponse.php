<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookGetResponse
 */
final class WebhookGetResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Object with all the webhook properties.
     *
     * @var WebhookObject|null
     */
    private $object;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->object = Data::model(WebhookObject::class, $data['object'] ?? null);

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
     * Object with all the webhook properties.
     */
    public function getObject(): ?WebhookObject
    {
        return $this->object;
    }

    /**
     * Object with all the webhook properties.
     *
     * @return $this
     */
    public function setObject(?WebhookObject $object): self
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'object' => null === $this->object ? null : Data::object($this->object->toArray()),
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
