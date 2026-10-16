<?php

declare(strict_types=1);

namespace UniOne\Api\Email\Model;

use UniOne\Client\Data;

/**
 * EmailSendResponse
 */
final class EmailSendResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Job identifier, might be useful for investigating errors.
         * Example: `1ZymBc-00041N-9X`.
         */
        public ?string $jobId = null,
        /**
         * Array of recipients emails successfully accepted for sending.
         * @var list<string>|null
         */
        public ?array $emails = null,
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
         * @var array<string, string>|null
         */
        public ?array $failedEmails = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            jobId: Data::string($data['job_id'] ?? null),
            emails: Data::list($data['emails'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            failedEmails: Data::map($data['failed_emails'] ?? null, static fn ($item) => Data::string($item) ?? ''),
        );
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
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
