<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * EmailSubscribeRequest
 */
final class EmailSubscribeRequest implements \JsonSerializable
{
    /**
     * Sender’s email on a confirmed domain. (Field alias "email_address_from" is supported, too).
     * Example: `email@example.com`.
     *
     * @var string
     */
    private $fromEmail;

    /**
     * Sender’s name. (Field alias "name_from" is supported, too).
     * Example: `Example`.
     *
     * @var string
     */
    private $fromName;

    /**
     * Recipient’s email. (Field alias "email_address_to" is supported, too).
     * Example: `email@example.com`.
     *
     * @var string
     */
    private $toEmail;

    public function __construct(string $fromEmail, string $fromName, string $toEmail)
    {
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
        $this->toEmail = $toEmail;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data['from_email'] ?? null) ?? '',
            Data::string($data['from_name'] ?? null) ?? '',
            Data::string($data['to_email'] ?? null) ?? ''
        );
    }

    /**
     * Sender’s email on a confirmed domain. (Field alias "email_address_from" is supported, too).
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * Sender’s email on a confirmed domain. (Field alias "email_address_from" is supported, too).
     *
     * @return $this
     */
    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Sender’s name. (Field alias "name_from" is supported, too).
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * Sender’s name. (Field alias "name_from" is supported, too).
     *
     * @return $this
     */
    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Recipient’s email. (Field alias "email_address_to" is supported, too).
     */
    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    /**
     * Recipient’s email. (Field alias "email_address_to" is supported, too).
     *
     * @return $this
     */
    public function setToEmail(string $toEmail): self
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'to_email' => $this->toEmail,
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
