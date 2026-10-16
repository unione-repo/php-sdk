<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookListResponse
 */
final class WebhookListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Array of webhooks objects.
     *
     * @var list<WebhookObject>|null
     */
    private $objects;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->objects = Data::list($data['objects'] ?? null, static function ($item) { return WebhookObject::fromArray(Data::array($item) ?? []); });

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
     * Array of webhooks objects.
     *
     * @return list<WebhookObject>|null
     */
    public function getObjects(): ?array
    {
        return $this->objects;
    }

    /**
     * Array of webhooks objects.
     *
     * @param list<WebhookObject>|null $objects
     *
     * @return $this
     */
    public function setObjects(?array $objects): self
    {
        $this->objects = $objects;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'objects' => null === $this->objects ? null : \array_map(static function (WebhookObject $item) { return Data::object($item->toArray()); }, $this->objects),
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
