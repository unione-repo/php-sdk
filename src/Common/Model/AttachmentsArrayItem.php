<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

use UniOne\Client\Data;

/**
 * AttachmentsArrayItem
 */
final class AttachmentsArrayItem implements \JsonSerializable
{
    /**
     * Attachment type, see [MIME](https://en.wikipedia.org/wiki/MIME). If unsure, use "application/octet-stream".
     * Example: `text/plain`.
     *
     * @var string
     */
    private $type;

    /**
     * Attachment name in the format: "name.extension". When multiple attachments are passed, their names must be
     * unique. The symbol ‘/’ is not allowed in attachment names.
     * Example: `readme.txt`.
     *
     * @var string
     */
    private $name;

    /**
     * File contents in [base64](https://en.wikipedia.org/wiki/Base64). Maximum file size 7MB (9786710 bytes in
     * base64).
     * Example: `SGVsbG8sIHdvcmxkIQ==`.
     *
     * @var string
     */
    private $content;

    public function __construct(string $type, string $name, string $content)
    {
        $this->type = $type;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data['type'] ?? null) ?? '',
            Data::string($data['name'] ?? null) ?? '',
            Data::string($data['content'] ?? null) ?? ''
        );
    }

    /**
     * Attachment type, see [MIME](https://en.wikipedia.org/wiki/MIME).
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Attachment type, see [MIME](https://en.wikipedia.org/wiki/MIME).
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Attachment name in the format: "name.extension".
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Attachment name in the format: "name.extension".
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * File contents in [base64](https://en.wikipedia.org/wiki/Base64).
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * File contents in [base64](https://en.wikipedia.org/wiki/Base64).
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'type' => $this->type,
            'name' => $this->name,
            'content' => $this->content,
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
