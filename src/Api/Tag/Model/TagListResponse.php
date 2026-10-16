<?php

declare(strict_types=1);

namespace UniOne\Api\Tag\Model;

use UniOne\Client\Data;

/**
 * TagListResponse
 */
final class TagListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * An array of objects containing data for user-defined tags.
     *
     * @var list<TagsResponseObject>|null
     */
    private $tags;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->tags = Data::list($data['tags'] ?? null, static function ($item) { return TagsResponseObject::fromArray(Data::array($item) ?? []); });

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
     * An array of objects containing data for user-defined tags.
     *
     * @return list<TagsResponseObject>|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * An array of objects containing data for user-defined tags.
     *
     * @param list<TagsResponseObject>|null $tags
     *
     * @return $this
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'tags' => null === $this->tags ? null : \array_map(static function (TagsResponseObject $item) { return Data::object($item->toArray()); }, $this->tags),
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
