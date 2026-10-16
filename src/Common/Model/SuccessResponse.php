<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

use UniOne\Client\Data;

/**
 * SuccessResponse
 */
final class SuccessResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);

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
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
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
