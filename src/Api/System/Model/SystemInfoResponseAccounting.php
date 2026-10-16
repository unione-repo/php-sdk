<?php

declare(strict_types=1);

namespace UniOne\Api\System\Model;

use UniOne\Client\Data;

/**
 * Object with accounting period properties. Present only if the API key used for request is the user API key.
 */
final class SystemInfoResponseAccounting implements \JsonSerializable
{
    /**
     * Date and time of accounting period start in UTC in "YYYY-MM-DD hh:mm:ss" format.
     * Example: `2016-08-29 09:12:33`.
     *
     * @var string|null
     */
    private $periodStart;

    /**
     * Date and time of accounting period end in UTC in "YYYY-MM-DD hh:mm:ss" format.
     * Example: `2016-09-29 09:12:33`.
     *
     * @var string|null
     */
    private $periodEnd;

    /**
     * Number of emails included into accounting period.
     *
     * @var int|null
     */
    private $emailsIncluded;

    /**
     * Number of emails sent during accounting period. Can be bigger than emails_included in case of overage.
     *
     * @var int|null
     */
    private $emailsSent;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->periodStart = Data::string($data['period_start'] ?? null);
        $model->periodEnd = Data::string($data['period_end'] ?? null);
        $model->emailsIncluded = Data::int($data['emails_included'] ?? null);
        $model->emailsSent = Data::int($data['emails_sent'] ?? null);

        return $model;
    }

    /**
     * Date and time of accounting period start in UTC in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getPeriodStart(): ?string
    {
        return $this->periodStart;
    }

    /**
     * Date and time of accounting period start in UTC in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setPeriodStart(?string $periodStart): self
    {
        $this->periodStart = $periodStart;

        return $this;
    }

    /**
     * Date and time of accounting period end in UTC in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getPeriodEnd(): ?string
    {
        return $this->periodEnd;
    }

    /**
     * Date and time of accounting period end in UTC in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setPeriodEnd(?string $periodEnd): self
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    /**
     * Number of emails included into accounting period.
     */
    public function getEmailsIncluded(): ?int
    {
        return $this->emailsIncluded;
    }

    /**
     * Number of emails included into accounting period.
     *
     * @return $this
     */
    public function setEmailsIncluded(?int $emailsIncluded): self
    {
        $this->emailsIncluded = $emailsIncluded;

        return $this;
    }

    /**
     * Number of emails sent during accounting period.
     */
    public function getEmailsSent(): ?int
    {
        return $this->emailsSent;
    }

    /**
     * Number of emails sent during accounting period.
     *
     * @return $this
     */
    public function setEmailsSent(?int $emailsSent): self
    {
        $this->emailsSent = $emailsSent;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'period_start' => $this->periodStart,
            'period_end' => $this->periodEnd,
            'emails_included' => $this->emailsIncluded,
            'emails_sent' => $this->emailsSent,
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
