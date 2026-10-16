<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionGetResponse
 */
final class SuppressionGetResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * The email for which suppression details were requested.
     *
     * @var string|null
     */
    private $email;

    /**
     * Array of suppression objects.
     *
     * @var list<SuppressionGetObject>|null
     */
    private $suppressions;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->suppressions = Data::list($data['suppressions'] ?? null, static function ($item) { return SuppressionGetObject::fromArray(Data::array($item) ?? []); });

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
     * The email for which suppression details were requested.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * The email for which suppression details were requested.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Array of suppression objects.
     *
     * @return list<SuppressionGetObject>|null
     */
    public function getSuppressions(): ?array
    {
        return $this->suppressions;
    }

    /**
     * Array of suppression objects.
     *
     * @param list<SuppressionGetObject>|null $suppressions
     *
     * @return $this
     */
    public function setSuppressions(?array $suppressions): self
    {
        $this->suppressions = $suppressions;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'email' => $this->email,
            'suppressions' => null === $this->suppressions ? null : \array_map(static function (SuppressionGetObject $item) { return Data::object($item->toArray()); }, $this->suppressions),
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
