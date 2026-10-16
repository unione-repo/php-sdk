<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookListRequest
 */
final class WebhookListRequest implements \JsonSerializable
{
    /**
     * Limits the number of webhooks returned. 50 is recommended.
     *
     * @var int|null
     */
    private $limit;

    /**
     * Index of the first webhook in the list, starting with 0.
     * Default: `0`.
     *
     * @var int|null
     */
    private $offset;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->limit = Data::int($data['limit'] ?? null);
        $model->offset = Data::int($data['offset'] ?? null);

        return $model;
    }

    /**
     * Limits the number of webhooks returned. 50 is recommended.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Limits the number of webhooks returned. 50 is recommended.
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Index of the first webhook in the list, starting with 0.
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Index of the first webhook in the list, starting with 0.
     *
     * @return $this
     */
    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'limit' => $this->limit,
            'offset' => $this->offset,
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
