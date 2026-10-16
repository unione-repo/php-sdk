<?php

declare(strict_types=1);

namespace UniOne\Api\Tag\Model;

use UniOne\Client\Data;

/**
 * An object with the properties of the user tags.
 */
final class TagsResponseObject implements \JsonSerializable
{
    /**
     * Unique tag id.
     * Example: `54`.
     *
     * @var int|null
     */
    private $tagId;

    /**
     * Tag name.
     * Example: `example-tag1`.
     *
     * @var string|null
     */
    private $tag;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->tagId = Data::int($data['tag_id'] ?? null);
        $model->tag = Data::string($data['tag'] ?? null);

        return $model;
    }

    /**
     * Unique tag id.
     */
    public function getTagId(): ?int
    {
        return $this->tagId;
    }

    /**
     * Unique tag id.
     *
     * @return $this
     */
    public function setTagId(?int $tagId): self
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Tag name.
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * Tag name.
     *
     * @return $this
     */
    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'tag_id' => $this->tagId,
            'tag' => $this->tag,
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
