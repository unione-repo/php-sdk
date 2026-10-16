<?php

declare(strict_types=1);

namespace UniOne\Api\ConfirmedEmail\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\VerificationRecordStatus;

/**
 * ConfirmedEmail
 */
final class ConfirmedEmail implements \JsonSerializable
{
    /**
     * Example: `dev@example.com`.
     *
     * @var string|null
     */
    private $email;

    /**
     * Confirmation status of the email address.
     * Values: `VerificationRecordStatus` constants.
     *
     * @var string|null
     */
    private $status;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->email = Data::string($data['email'] ?? null);
        $model->status = Data::string($data['status'] ?? null);

        return $model;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Confirmation status of the email address.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Confirmation status of the email address.
     *
     * @param string|null $status Values: `VerificationRecordStatus` constants.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'status' => $this->status,
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
