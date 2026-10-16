<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

use UniOne\Client\Data;

/**
 * InlineAttachmentsArrayItem
 */
final class InlineAttachmentsArrayItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Attachment type, see [MIME](https://en.wikipedia.org/wiki/MIME). If unsure, use "application/octet-stream".
         * Example: `image/gif`.
         */
        public string $type,
        /**
         * Attachment content id. For example, "name"="IMAGECID1" should be referenced in HTML like <img
         * src="cid:IMAGECID1">.
         * Example: `IMAGECID1`.
         */
        public string $name,
        /**
         * File contents in [base64](https://en.wikipedia.org/wiki/Base64). Maximum file size 7MB (9786710 bytes in
         * base64).
         * Example: `R0lGODdhAwADAIABAP+rAP///ywAAAAAAwADAAACBIQRBwUAOw==`.
         */
        public string $content,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: Data::string($data['type'] ?? null) ?? '',
            name: Data::string($data['name'] ?? null) ?? '',
            content: Data::string($data['content'] ?? null) ?? '',
        );
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
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
