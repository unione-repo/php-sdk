<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailStatus;

/**
 * Object with different event properties depending on "event_name". Below you can see all the properties,
 * "transactional_email_status"-related first and then "transactional_spam_block"-related.
 */
final class WebhookCallbackEventsByUserItemEventsItemEventData implements \JsonSerializable
{
    public function __construct(
        /**
         * Job identifier returned earlier by [email/send](https://docs.unione.io/en/web-api-ref#email-send) method.
         * Property exists only if event_name="transactional_email_status".
         * Example: `1ZymBc-00041N-9X`.
         */
        public ?string $jobId = null,
        /**
         * Metadata passed in [email/send](https://docs.unione.io/en/web-api-ref#email-send) method in
         * recipients.metadata or global_metadata properties. This property exists only if
         * event_name="transactional_email_status".
         * @var array<string, string>|null
         */
        public ?array $metadata = null,
        /**
         * Recipient's email. This property exists only if event_name="transactional_email_status".
         */
        public ?string $email = null,
        /**
         * Email delivery status. This property exists only if event_name="transactional_email_status". Possible values
         * are:
         *
         * __accepted__ — the message has been accepted, but not sent yet.
         * __sent__ — the message has been sent, but not delivered yet.
         * __delivered__ — the message has been delivered. It can be changed to “opened”, “clicked”, “unsubscribed”,
         * “subscribed” or “spam”.
         * __opened__ — the message has been delivered and read. It can be changed to “clicked”, “unsubscribed”,
         * “subscribed” or “spam”.
         * __clicked__ — the message has been delivered, read, and at least one of the links in email has been clicked.
         * It can be changed to “unsubscribed”, “subscribed” or “spam”.
         * __unsubscribed__ — the message has been delivered to the recipient and read, but then the recipient
         * unsubscribed. It can be changed to “subscribed”.
         * __subscribed__ — the message has been delivered to the recipient and read, but then the recipient unsubscribed
         * and subscribed again. It can be changed to “unsubscribed”.
         * __soft_bounced__ — temporary delivery failure. UniOne will try to deliver the message during 48 hours. In case
         * of success the status changes to “delivered”, in case of failure to deliver during 48 hours message status
         * changes to “hard_bounced”.
         * __hard_bounced__ — failed to deliver the message, there will be no delivery attempts. It's a final status.
         * There are a lot of possible reasons, you can use SMTP response from delivery_info.destination_response field
         * or UniOne internal reason classification from delivery_info.delivery_status field to analyze the reason.
         * __spam__ — the message has been delivered, but it was reported as spam by the recipient. UniOne can receive
         * and process the spam complaint from several domains, including msn.com, outlook.com, hotmail.com, live.com,
         * ukr.net, yahoo.com, aol.com using [FBL](https://en.wikipedia.org/wiki/Feedback_loop_(email)).
         */
        public EmailStatus|string|null $status = null,
        /**
         * Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This property exists only if
         * event_name="transactional_email_status".
         * Example: `2020-12-24 16:05:58`.
         */
        public ?string $eventTime = null,
        /**
         * URL for "opened" and "clicked" statuses. This property exists only if event_name="transactional_email_status".
         */
        public ?string $url = null,
        /**
         * Object with detailed delivery info.Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This
         * property exists only if webhook has delivery_info proeprty set to 1 and
         * event_name="transactional_email_status".
         */
        public ?WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo $deliveryInfo = null,
        /**
         * Spam block date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This property exists only if
         * event_name="transactional_spam_block".
         * Example: `2020-12-24 16:05:58`.
         */
        public ?string $blockTime = null,
        /**
         * Spam block type, either single or multiple sending SMTP. For single sending SMTP block in common pool UniOne
         * retries several other SMTPs. This property exists only if event_name="transactional_spam_block".
         */
        public BlockType|string|null $blockType = null,
        /**
         * Domain that blocked sending. This property exists only if event_name="transactional_spam_block".
         * Example: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Number of sending SMTPs blocked. This property exists only if event_name="transactional_spam_block".
         */
        public ?int $sMTPBlocksCount = null,
        /**
         * Whether it's a block or unblock event. This property exists only if event_name="transactional_spam_block".
         */
        public DomainStatus|string|null $domainStatus = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            jobId: Data::string($data['job_id'] ?? null),
            metadata: Data::map($data['metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            email: Data::string($data['email'] ?? null),
            status: Data::enum(EmailStatus::class, Data::string($data['status'] ?? null)),
            eventTime: Data::string($data['event_time'] ?? null),
            url: Data::string($data['url'] ?? null),
            deliveryInfo: Data::model(WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo::class, $data['delivery_info'] ?? null),
            blockTime: Data::string($data['block_time'] ?? null),
            blockType: Data::enum(BlockType::class, Data::string($data['block_type'] ?? null)),
            domain: Data::string($data['domain'] ?? null),
            sMTPBlocksCount: Data::int($data['SMTP_blocks_count'] ?? null),
            domainStatus: Data::enum(DomainStatus::class, Data::string($data['domain_status'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'job_id' => $this->jobId,
            'metadata' => Data::object($this->metadata),
            'email' => $this->email,
            'status' => Data::value($this->status),
            'event_time' => $this->eventTime,
            'url' => $this->url,
            'delivery_info' => null === $this->deliveryInfo ? null : Data::object($this->deliveryInfo->toArray()),
            'block_time' => $this->blockTime,
            'block_type' => Data::value($this->blockType),
            'domain' => $this->domain,
            'SMTP_blocks_count' => $this->sMTPBlocksCount,
            'domain_status' => Data::value($this->domainStatus),
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
