<?php

declare(strict_types=1);

namespace UniOne\Api\System\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailCounterMode;

/**
 * Object with email counter properties. Present only if the API key used for request is the user API key.
 */
final class ProjectAccountingObject implements \JsonSerializable
{
    /**
     * Project's email counter value. It increases on every email sent.
     *
     * @var int|null
     */
    private $emailCounter;

    /**
     * Allows you to limit the number of emails sent by the project. The sending stops when the limit is reached. Any
     * non-negative 64-bit integer is acceptable. 0 means no limit.
     *
     * @var int|null
     */
    private $emailCounterLimit;

    /**
     * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
     * the counter never resets automatically.
     * Default: `default`.
     * Values: `EmailCounterMode` constants.
     *
     * @var string|null
     */
    private $emailCounterMode;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->emailCounter = Data::int($data['email_counter'] ?? null);
        $model->emailCounterLimit = Data::int($data['email_counter_limit'] ?? null);
        $model->emailCounterMode = Data::string($data['email_counter_mode'] ?? null);

        return $model;
    }

    /**
     * Project's email counter value.
     */
    public function getEmailCounter(): ?int
    {
        return $this->emailCounter;
    }

    /**
     * Project's email counter value.
     *
     * @return $this
     */
    public function setEmailCounter(?int $emailCounter): self
    {
        $this->emailCounter = $emailCounter;

        return $this;
    }

    /**
     * Allows you to limit the number of emails sent by the project.
     */
    public function getEmailCounterLimit(): ?int
    {
        return $this->emailCounterLimit;
    }

    /**
     * Allows you to limit the number of emails sent by the project.
     *
     * @return $this
     */
    public function setEmailCounterLimit(?int $emailCounterLimit): self
    {
        $this->emailCounterLimit = $emailCounterLimit;

        return $this;
    }

    /**
     * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
     * the counter never resets automatically.
     *
     * @return string|null
     */
    public function getEmailCounterMode(): ?string
    {
        return $this->emailCounterMode;
    }

    /**
     * 'default' - the counter resets to zero automatically at the beginning of each accounting period. 'permanent' -
     * the counter never resets automatically.
     *
     * @param string|null $emailCounterMode Values: `EmailCounterMode` constants.
     *
     * @return $this
     */
    public function setEmailCounterMode(?string $emailCounterMode): self
    {
        $this->emailCounterMode = $emailCounterMode;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => $this->emailCounterMode,
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
