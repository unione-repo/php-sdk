<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionListRequest
 */
final class SuppressionListRequest implements \JsonSerializable
{
    public function __construct(
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
         */
        public ?string $cause = null,
        /**
         * Source of email being suppressed. One of:
         *
         * - __user__ - suppressed by user with    [suppression/set](https://docs.unione.io/en/web-api-ref#suppression-set);
         * - __system__ - sending to the email is prohibited by system, for example due to multiple hard bounces;
         * - __subscriber__ - the recipient reported spam or unsubscribed in the previous emails.
         * Example: `user`.
         */
        public ?string $source = null,
        /**
         * Date in the format YYYY-MM-DD hh:mm:ss to get suppression list from the "start_time" to the present day.
         * Ignored if "cursor" is not empty.
         * Example: `2020-10-14 17:00:00`.
         */
        public ?string $startTime = null,
        /**
         * The parameter indicates from which position the selection is to be started. Must be empty or omitted for the
         * first data chunk. In order to get subsequent chunks, you must set the "cursor" parameter in your request,
         * using the value received in response to the previous request.
         * Example: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
         */
        public ?string $cursor = null,
        /**
         * Limits the number of records to be returned at one time, default is 50.
         * Example: `50`.
         */
        public ?int $limit = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            cause: Data::string($data['cause'] ?? null),
            source: Data::string($data['source'] ?? null),
            startTime: Data::string($data['start_time'] ?? null),
            cursor: Data::string($data['cursor'] ?? null),
            limit: Data::int($data['limit'] ?? null),
        );
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
