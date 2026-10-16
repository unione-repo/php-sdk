<?php

declare(strict_types=1);

namespace UniOne\Api\EmailValidation\Model;

use UniOne\Client\Data;

/**
 * EmailValidationSingleResponse
 */
final class EmailValidationSingleResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Email address to be checked.
     *
     * @var string|null
     */
    private $email;

    /**
     * Possible statuses:
     *
     * - "valid" - the address is valid,
     * - "invalid" - the address is invalid,
     * - "suspicious" - the address looks suspicious,
     * - "unknown" - could not perform validation, the domain’s mail server has not responded within the time limit.
     * Example: `suspicious`.
     *
     * @var string|null
     */
    private $result;

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
     *
     * @var string|null
     */
    private $cause;

    /**
     * Validity score, from 0 to 100 (0 – invalid, 100 – valid).
     * Example: `10`.
     *
     * @var int|null
     */
    private $validity;

    /**
     * Local part (everything preceding the @ sign).
     * Example: `user`.
     *
     * @var string|null
     */
    private $localPart;

    /**
     * Domain name part.
     * Example: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * True if the address’ domain does have an MX record, false if does not.
     * Example: `True`.
     *
     * @var bool|null
     */
    private $mxFound;

    /**
     * Preferred MX record for the domain.
     * Example: `10`.
     *
     * @var string|null
     */
    private $mxRecord;

    /**
     * For addresses which are likely to have typing errors (cause=possible_typo), a suggested variant with a fixed
     * typo.
     * Example: `user@example.com`.
     *
     * @var string|null
     */
    private $didYouMean;

    /**
     * Email check date and time, YYYY-MM-DD hh:mm:ss UTC.
     * Example: `2023-01-01 22:14:59`.
     *
     * @var string|null
     */
    private $processedAt;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->result = Data::string($data['result'] ?? null);
        $model->cause = Data::string($data['cause'] ?? null);
        $model->validity = Data::int($data['validity'] ?? null);
        $model->localPart = Data::string($data['local_part'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->mxFound = Data::bool($data['mx_found'] ?? null);
        $model->mxRecord = Data::string($data['mx_record'] ?? null);
        $model->didYouMean = Data::string($data['did_you_mean'] ?? null);
        $model->processedAt = Data::string($data['processed_at'] ?? null);

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
     * Email address to be checked.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email address to be checked.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Possible statuses:
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * Possible statuses:
     *
     * @return $this
     */
    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Possible statuses:
     */
    public function getCause(): ?string
    {
        return $this->cause;
    }

    /**
     * Possible statuses:
     *
     * @return $this
     */
    public function setCause(?string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Validity score, from 0 to 100 (0 – invalid, 100 – valid).
     */
    public function getValidity(): ?int
    {
        return $this->validity;
    }

    /**
     * Validity score, from 0 to 100 (0 – invalid, 100 – valid).
     *
     * @return $this
     */
    public function setValidity(?int $validity): self
    {
        $this->validity = $validity;

        return $this;
    }

    /**
     * Local part (everything preceding the @ sign).
     */
    public function getLocalPart(): ?string
    {
        return $this->localPart;
    }

    /**
     * Local part (everything preceding the @ sign).
     *
     * @return $this
     */
    public function setLocalPart(?string $localPart): self
    {
        $this->localPart = $localPart;

        return $this;
    }

    /**
     * Domain name part.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Domain name part.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * True if the address’ domain does have an MX record, false if does not.
     */
    public function getMxFound(): ?bool
    {
        return $this->mxFound;
    }

    /**
     * True if the address’ domain does have an MX record, false if does not.
     *
     * @return $this
     */
    public function setMxFound(?bool $mxFound): self
    {
        $this->mxFound = $mxFound;

        return $this;
    }

    /**
     * Preferred MX record for the domain.
     */
    public function getMxRecord(): ?string
    {
        return $this->mxRecord;
    }

    /**
     * Preferred MX record for the domain.
     *
     * @return $this
     */
    public function setMxRecord(?string $mxRecord): self
    {
        $this->mxRecord = $mxRecord;

        return $this;
    }

    /**
     * For addresses which are likely to have typing errors (cause=possible_typo), a suggested variant with a fixed
     * typo.
     */
    public function getDidYouMean(): ?string
    {
        return $this->didYouMean;
    }

    /**
     * For addresses which are likely to have typing errors (cause=possible_typo), a suggested variant with a fixed
     * typo.
     *
     * @return $this
     */
    public function setDidYouMean(?string $didYouMean): self
    {
        $this->didYouMean = $didYouMean;

        return $this;
    }

    /**
     * Email check date and time, YYYY-MM-DD hh:mm:ss UTC.
     */
    public function getProcessedAt(): ?string
    {
        return $this->processedAt;
    }

    /**
     * Email check date and time, YYYY-MM-DD hh:mm:ss UTC.
     *
     * @return $this
     */
    public function setProcessedAt(?string $processedAt): self
    {
        $this->processedAt = $processedAt;

        return $this;
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
