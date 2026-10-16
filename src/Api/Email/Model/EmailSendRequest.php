<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * EmailSendRequest
 */
final class EmailSendRequest implements \JsonSerializable
{
    /**
     * Object containing all message properties.
     *
     * @var MessageObject
     */
    private $message;

    public function __construct(MessageObject $message)
    {
        $this->message = $message;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(MessageObject::fromArray(Data::array($data['message'] ?? null) ?? []));
    }

    /**
     * Object containing all message properties.
     */
    public function getMessage(): MessageObject
    {
        return $this->message;
    }

    /**
     * Object containing all message properties.
     *
     * @return $this
     */
    public function setMessage(MessageObject $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'message' => Data::object($this->message->toArray()),
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
