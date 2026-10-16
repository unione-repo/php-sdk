<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionSetRequest
 */
final class SuppressionSetRequest implements \JsonSerializable
{
    /**
     * Email to add in suppression list.
     * Example: `email@example.com`.
     *
     * @var string
     */
    private $email;

    /**
     * Cause of email being suppressed. One of:
     *
     * - __unsubscribed__ - email is unsubscribed;
     * - __temporary_unavailable__ - the email address is unavailable. This means that over the next three days sending to this address will return an error. Email may be temporarily unavailable due to several reasons, e.g.:
     *
     * - a previous email has been rejected by the recipient's server for spam;
     * - the recipient's mailbox is full or is not used;
     * - recipient's domain does not accept mail;
     * - sending server was rejected due to blacklisting;
     *
     * - __permanent_unavailable__ - the email address is permanently unavailable due to multiple hard bounces;
     * - __complained__ -  the recipient reported spam in the previous emails;
     * Example: `unsubscribed`.
     *
     * @var string
     */
    private $cause;

    /**
     * When suppression was created, in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     * Example: `2021-12-19 10:15:49`.
     *
     * @var string|null
     */
    private $created;

    public function __construct(string $email, string $cause)
    {
        $this->email = $email;
        $this->cause = $cause;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(
            Data::string($data['email'] ?? null) ?? '',
            Data::string($data['cause'] ?? null) ?? ''
        );
        $model->created = Data::string($data['created'] ?? null);

        return $model;
    }

    /**
     * Email to add in suppression list.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Email to add in suppression list.
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Cause of email being suppressed.
     */
    public function getCause(): string
    {
        return $this->cause;
    }

    /**
     * Cause of email being suppressed.
     *
     * @return $this
     */
    public function setCause(string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * When suppression was created, in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * When suppression was created, in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setCreated(?string $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'cause' => $this->cause,
            'created' => $this->created,
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
