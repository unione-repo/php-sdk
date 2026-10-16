<?php

declare(strict_types=1);

namespace UniOne\Api\EmailValidation\Model;

use UniOne\Client\Data;

/**
 * EmailValidationSingleResponse
 */
final class EmailValidationSingleResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Email address to be checked.
         */
        public ?string $email = null,
        /**
         * Possible statuses:
         *
         * - "valid" - the address is valid,
         * - "invalid" - the address is invalid,
         * - "suspicious" - the address looks suspicious,
         * - "unknown" - could not perform validation, the domain’s mail server has not responded within the time limit.
         * Example: `suspicious`.
         */
        public ?string $result = null,
        /**
         * Possible statuses:
         *
         * - "no_mx_record" - no MX record found for the target domain,
         * - "syntax_error" - the address syntax is invalid,
         * - "possible_typo" - the address is likely to have a typo,
         * - "mailbox_not_found" - the address does not exist,
         * - "global_suppression" - the address has been marked as unreachable due to multiple previous delivery errors,
         * - "disposable" - this is a disposable one-time email address which is usually valid for a few minutes only,
         * - "role" - the address is not likely to belong to an actual person, but rather to a certain business staff role,
         * - "abuse" - the address is known to be a source of a large number of complaints, sometimes issued automatically,
         * - "spamtrap" - this email is a spam trap, it is published openly but never used for actual emails. Sending messages to such addresses has a huge negative impact on reputation score,
         * - "smtp_connection_failed" - the domain’s SMTP server does not respond; the address may contain a typo.
         * Example: `disposable`.
         */
        public ?string $cause = null,
        /**
         * Validity score, from 0 to 100 (0 – invalid, 100 – valid).
         * Example: `10`.
         */
        public ?int $validity = null,
        /**
         * Local part (everything preceding the @ sign).
         * Example: `user`.
         */
        public ?string $localPart = null,
        /**
         * Domain name part.
         * Example: `example.com`.
         */
        public ?string $domain = null,
        /**
         * True if the address’ domain does have an MX record, false if does not.
         * Example: `True`.
         */
        public ?bool $mxFound = null,
        /**
         * Preferred MX record for the domain.
         * Example: `10`.
         */
        public ?string $mxRecord = null,
        /**
         * For addresses which are likely to have typing errors (cause=possible_typo), a suggested variant with a fixed
         * typo.
         * Example: `user@example.com`.
         */
        public ?string $didYouMean = null,
        /**
         * Email check date and time, YYYY-MM-DD hh:mm:ss UTC.
         * Example: `2023-01-01 22:14:59`.
         */
        public ?string $processedAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            email: Data::string($data['email'] ?? null),
            result: Data::string($data['result'] ?? null),
            cause: Data::string($data['cause'] ?? null),
            validity: Data::int($data['validity'] ?? null),
            localPart: Data::string($data['local_part'] ?? null),
            domain: Data::string($data['domain'] ?? null),
            mxFound: Data::bool($data['mx_found'] ?? null),
            mxRecord: Data::string($data['mx_record'] ?? null),
            didYouMean: Data::string($data['did_you_mean'] ?? null),
            processedAt: Data::string($data['processed_at'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'email' => $this->email,
            'result' => $this->result,
            'cause' => $this->cause,
            'validity' => $this->validity,
            'local_part' => $this->localPart,
            'domain' => $this->domain,
            'mx_found' => $this->mxFound,
            'mx_record' => $this->mxRecord,
            'did_you_mean' => $this->didYouMean,
            'processed_at' => $this->processedAt,
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
