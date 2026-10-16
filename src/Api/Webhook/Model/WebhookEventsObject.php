<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailStatus;

/**
 * Object containing events to notify of.
 */
final class WebhookEventsObject implements \JsonSerializable
{
    /**
     * If present then spam block events will be reported. Should contain single array element with "*" string.
     *
     * @var list<string>|null
     */
    private $spamBlock;

    /**
     * If present then email status change events will be reported. Contains names of statuses to notify of.
     * Values: `EmailStatus` constants.
     *
     * @var list<string>|null
     */
    private $emailStatus;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->spamBlock = Data::list($data['spam_block'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->emailStatus = Data::list($data['email_status'] ?? null, static function ($item) { return Data::string($item) ?? ''; });

        return $model;
    }

    /**
     * If present then spam block events will be reported.
     *
     * @return list<string>|null
     */
    public function getSpamBlock(): ?array
    {
        return $this->spamBlock;
    }

    /**
     * If present then spam block events will be reported.
     *
     * @param list<string>|null $spamBlock
     *
     * @return $this
     */
    public function setSpamBlock(?array $spamBlock): self
    {
        $this->spamBlock = $spamBlock;

        return $this;
    }

    /**
     * If present then email status change events will be reported.
     *
     * @return list<string>|null
     */
    public function getEmailStatus(): ?array
    {
        return $this->emailStatus;
    }

    /**
     * If present then email status change events will be reported.
     *
     * @param list<string>|null $emailStatus Values: `EmailStatus` constants.
     *
     * @return $this
     */
    public function setEmailStatus(?array $emailStatus): self
    {
        $this->emailStatus = $emailStatus;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'spam_block' => $this->spamBlock,
            'email_status' => $this->emailStatus,
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
