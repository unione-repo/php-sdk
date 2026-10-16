<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * Object with suppression details.
 */
final class SuppressionGetObject implements \JsonSerializable
{
    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     * Example: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

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
     * - __blocked__ -  sending to the email is prohibited by administration of UniOne.
     * We may add some new causes in the future.
     * Example: `unsubscribed`.
     *
     * @var string|null
     */
    private $cause;

    /**
     * Source of email being suppressed. One of:
     *
     * - __user__ - suppressed by user with    [suppression/set](https://docs.unione.io/en/web-api-ref#suppression-set);
     * - __system__ - sending to the email is prohibited by system, for example due to multiple hard bounces;
     * - __subscriber__ - the recipient reported spam or unsubscribed in the previous emails.
     * Example: `user`.
     *
     * @var string|null
     */
    private $source;

    /**
     * Is it possible to delete this suppression by calling suppression/delete method.
     *
     * @var bool|null
     */
    private $isDeletable;

    /**
     * When suppression was created, in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     * Example: `2021-12-19 10:15:49`.
     *
     * @var string|null
     */
    private $created;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->cause = Data::string($data['cause'] ?? null);
        $model->source = Data::string($data['source'] ?? null);
        $model->isDeletable = Data::bool($data['is_deletable'] ?? null);
        $model->created = Data::string($data['created'] ?? null);

        return $model;
    }

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Cause of email being suppressed.
     */
    public function getCause(): ?string
    {
        return $this->cause;
    }

    /**
     * Cause of email being suppressed.
     *
     * @return $this
     */
    public function setCause(?string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Source of email being suppressed.
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * Source of email being suppressed.
     *
     * @return $this
     */
    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Is it possible to delete this suppression by calling suppression/delete method.
     */
    public function getIsDeletable(): ?bool
    {
        return $this->isDeletable;
    }

    /**
     * Is it possible to delete this suppression by calling suppression/delete method.
     *
     * @return $this
     */
    public function setIsDeletable(?bool $isDeletable): self
    {
        $this->isDeletable = $isDeletable;

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
            'project_id' => $this->projectId,
            'cause' => $this->cause,
            'source' => $this->source,
            'is_deletable' => $this->isDeletable,
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
