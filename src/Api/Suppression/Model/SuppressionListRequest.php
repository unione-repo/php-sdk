<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionListRequest
 */
final class SuppressionListRequest implements \JsonSerializable
{
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
     * Date in the format YYYY-MM-DD hh:mm:ss to get suppression list from the "start_time" to the present day.
     * Ignored if "cursor" is not empty.
     * Example: `2020-10-14 17:00:00`.
     *
     * @var string|null
     */
    private $startTime;

    /**
     * The parameter indicates from which position the selection is to be started. Must be empty or omitted for the
     * first data chunk. In order to get subsequent chunks, you must set the "cursor" parameter in your request,
     * using the value received in response to the previous request.
     * Example: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
     *
     * @var string|null
     */
    private $cursor;

    /**
     * Limits the number of records to be returned at one time, default is 50.
     * Example: `50`.
     *
     * @var int|null
     */
    private $limit;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->cause = Data::string($data['cause'] ?? null);
        $model->source = Data::string($data['source'] ?? null);
        $model->startTime = Data::string($data['start_time'] ?? null);
        $model->cursor = Data::string($data['cursor'] ?? null);
        $model->limit = Data::int($data['limit'] ?? null);

        return $model;
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
     * Date in the format YYYY-MM-DD hh:mm:ss to get suppression list from the "start_time" to the present day.
     */
    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    /**
     * Date in the format YYYY-MM-DD hh:mm:ss to get suppression list from the "start_time" to the present day.
     *
     * @return $this
     */
    public function setStartTime(?string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * The parameter indicates from which position the selection is to be started.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * The parameter indicates from which position the selection is to be started.
     *
     * @return $this
     */
    public function setCursor(?string $cursor): self
    {
        $this->cursor = $cursor;

        return $this;
    }

    /**
     * Limits the number of records to be returned at one time, default is 50.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Limits the number of records to be returned at one time, default is 50.
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'cause' => $this->cause,
            'source' => $this->source,
            'start_time' => $this->startTime,
            'cursor' => $this->cursor,
            'limit' => $this->limit,
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
