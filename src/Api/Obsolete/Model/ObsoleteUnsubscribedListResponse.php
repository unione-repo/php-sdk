<?php

declare(strict_types=1);

namespace UniOne\Api\Obsolete\Model;

use UniOne\Client\Data;

/**
 * ObsoleteUnsubscribedListResponse
 */
final class ObsoleteUnsubscribedListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Array of object describing unsubscribed emails.
     *
     * @var list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null
     */
    private $unsubscribed;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->unsubscribed = Data::list($data['unsubscribed'] ?? null, static function ($item) { return ObsoleteUnsubscribedListResponseUnsubscribedItem::fromArray(Data::array($item) ?? []); });

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
     * Array of object describing unsubscribed emails.
     *
     * @return list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null
     */
    public function getUnsubscribed(): ?array
    {
        return $this->unsubscribed;
    }

    /**
     * Array of object describing unsubscribed emails.
     *
     * @param list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null $unsubscribed
     *
     * @return $this
     */
    public function setUnsubscribed(?array $unsubscribed): self
    {
        $this->unsubscribed = $unsubscribed;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'unsubscribed' => null === $this->unsubscribed ? null : \array_map(static function (ObsoleteUnsubscribedListResponseUnsubscribedItem $item) { return Data::object($item->toArray()); }, $this->unsubscribed),
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
