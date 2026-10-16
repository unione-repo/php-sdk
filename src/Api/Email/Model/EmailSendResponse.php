<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * EmailSendResponse
 */
final class EmailSendResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Job identifier, might be useful for investigating errors.
     * Example: `1ZymBc-00041N-9X`.
     *
     * @var string|null
     */
    private $jobId;

    /**
     * Array of recipients emails successfully accepted for sending.
     *
     * @var list<string>|null
     */
    private $emails;

    /**
     * Object with emails rejected for sending as property names and their statuses as property values, e.g.:
     * {"email1@gmail.com": "temporary_unavailable"}. Possible statuses:
     *
     * - __unsubscribed__ - specified email is unsubscribed;
     * - __invalid__ - the email does not exist or has been entered incorrectly;
     * - __duplicate__ - the email already exists in the request, email duplicating is prevented;
     * - __temporary_unavailable__ - the email address is unavailable. This means that over the next three days sending to this address will return an error. Email may be temporarily unavailable due to several reasons, e.g.:
     *
     * - a previous email has been rejected by the recipient's server for spam;
     * - the recipient's mailbox is full or is not used;
     * - recipient's domain does not accept mail;
     * - sending server was rejected due to blacklisting;
     *
     * - __permanent_unavailable__ - the email address is permanently unavailable or unsubscribed globally.
     * - __complained__ -  the recipient reported spam in the previous emails;
     * - __blocked__ -  sending to the email is prohibited by administration of UniOne.
     * We may added new statuses in the future.
     *
     * @var array<string, string>|null
     */
    private $failedEmails;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->jobId = Data::string($data['job_id'] ?? null);
        $model->emails = Data::list($data['emails'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->failedEmails = Data::map($data['failed_emails'] ?? null, static function ($item) { return Data::string($item) ?? ''; });

        return $model;
    }

    /**
     * "success" string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * "success" string
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Job identifier, might be useful for investigating errors.
     */
    public function getJobId(): ?string
    {
        return $this->jobId;
    }

    /**
     * Job identifier, might be useful for investigating errors.
     *
     * @return $this
     */
    public function setJobId(?string $jobId): self
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Array of recipients emails successfully accepted for sending.
     *
     * @return list<string>|null
     */
    public function getEmails(): ?array
    {
        return $this->emails;
    }

    /**
     * Array of recipients emails successfully accepted for sending.
     *
     * @param list<string>|null $emails
     *
     * @return $this
     */
    public function setEmails(?array $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Object with emails rejected for sending as property names and their statuses as property values, e.g.:
     * {"email1@gmail.com": "temporary_unavailable"}.
     *
     * @return array<string, string>|null
     */
    public function getFailedEmails(): ?array
    {
        return $this->failedEmails;
    }

    /**
     * Object with emails rejected for sending as property names and their statuses as property values, e.g.:
     * {"email1@gmail.com": "temporary_unavailable"}.
     *
     * @param array<string, string>|null $failedEmails
     *
     * @return $this
     */
    public function setFailedEmails(?array $failedEmails): self
    {
        $this->failedEmails = $failedEmails;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'job_id' => $this->jobId,
            'emails' => $this->emails,
            'failed_emails' => Data::object($this->failedEmails),
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
