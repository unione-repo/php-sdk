<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionListResponse
 */
final class SuppressionListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Array of suppression objects.
     *
     * @var list<SuppressionListObject>|null
     */
    private $suppressions;

    /**
     * The parameter indicates from which position the selection is to be started. Must be empty or omitted for the
     * first data chunk. In order to get subsequent chunks, you must set the "cursor" parameter in your request,
     * using the value received in response to the previous request.
     * Example: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
     *
     * @var string|null
     */
    private $cursor;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->suppressions = Data::list($data['suppressions'] ?? null, static function ($item) { return SuppressionListObject::fromArray(Data::array($item) ?? []); });
        $model->cursor = Data::string($data['cursor'] ?? null);

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
     * Array of suppression objects.
     *
     * @return list<SuppressionListObject>|null
     */
    public function getSuppressions(): ?array
    {
        return $this->suppressions;
    }

    /**
     * Array of suppression objects.
     *
     * @param list<SuppressionListObject>|null $suppressions
     *
     * @return $this
     */
    public function setSuppressions(?array $suppressions): self
    {
        $this->suppressions = $suppressions;

        return $this;
    }

    /**
     * The parameter indicates from which position the selection is to be started.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * The parameter indicates from which position the selection is to be started.
     *
     * @return $this
     */
    public function setCursor(?string $cursor): self
    {
        $this->cursor = $cursor;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'suppressions' => null === $this->suppressions ? null : \array_map(static function (SuppressionListObject $item) { return Data::object($item->toArray()); }, $this->suppressions),
            'cursor' => $this->cursor,
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
