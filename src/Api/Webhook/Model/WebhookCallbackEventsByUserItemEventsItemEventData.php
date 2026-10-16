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
    /**
     * Job identifier returned earlier by [email/send](https://docs.unione.io/en/web-api-ref#email-send) method.
     * Property exists only if event_name="transactional_email_status".
     * Example: `1ZymBc-00041N-9X`.
     *
     * @var string|null
     */
    private $jobId;

    /**
     * Metadata passed in [email/send](https://docs.unione.io/en/web-api-ref#email-send) method in
     * recipients.metadata or global_metadata properties. This property exists only if
     * event_name="transactional_email_status".
     *
     * @var array<string, string>|null
     */
    private $metadata;

    /**
     * Recipient's email. This property exists only if event_name="transactional_email_status".
     *
     * @var string|null
     */
    private $email;

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
     * Values: `EmailStatus` constants.
     *
     * @var string|null
     */
    private $status;

    /**
     * Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This property exists only if
     * event_name="transactional_email_status".
     * Example: `2020-12-24 16:05:58`.
     *
     * @var string|null
     */
    private $eventTime;

    /**
     * URL for "opened" and "clicked" statuses. This property exists only if event_name="transactional_email_status".
     *
     * @var string|null
     */
    private $url;

    /**
     * Object with detailed delivery info.Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This
     * property exists only if webhook has delivery_info proeprty set to 1 and
     * event_name="transactional_email_status".
     *
     * @var WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo|null
     */
    private $deliveryInfo;

    /**
     * Spam block date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This property exists only if
     * event_name="transactional_spam_block".
     * Example: `2020-12-24 16:05:58`.
     *
     * @var string|null
     */
    private $blockTime;

    /**
     * Spam block type, either single or multiple sending SMTP. For single sending SMTP block in common pool UniOne
     * retries several other SMTPs. This property exists only if event_name="transactional_spam_block".
     * Values: `BlockType` constants.
     *
     * @var string|null
     */
    private $blockType;

    /**
     * Domain that blocked sending. This property exists only if event_name="transactional_spam_block".
     * Example: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Number of sending SMTPs blocked. This property exists only if event_name="transactional_spam_block".
     *
     * @var int|null
     */
    private $sMTPBlocksCount;

    /**
     * Whether it's a block or unblock event. This property exists only if event_name="transactional_spam_block".
     * Values: `DomainStatus` constants.
     *
     * @var string|null
     */
    private $domainStatus;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->jobId = Data::string($data['job_id'] ?? null);
        $model->metadata = Data::map($data['metadata'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->email = Data::string($data['email'] ?? null);
        $model->status = Data::string($data['status'] ?? null);
        $model->eventTime = Data::string($data['event_time'] ?? null);
        $model->url = Data::string($data['url'] ?? null);
        $model->deliveryInfo = Data::model(WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo::class, $data['delivery_info'] ?? null);
        $model->blockTime = Data::string($data['block_time'] ?? null);
        $model->blockType = Data::string($data['block_type'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->sMTPBlocksCount = Data::int($data['SMTP_blocks_count'] ?? null);
        $model->domainStatus = Data::string($data['domain_status'] ?? null);

        return $model;
    }

    /**
     * Job identifier returned earlier by [email/send](https://docs.unione.io/en/web-api-ref#email-send) method.
     */
    public function getJobId(): ?string
    {
        return $this->jobId;
    }

    /**
     * Job identifier returned earlier by [email/send](https://docs.unione.io/en/web-api-ref#email-send) method.
     *
     * @return $this
     */
    public function setJobId(?string $jobId): self
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Metadata passed in [email/send](https://docs.unione.io/en/web-api-ref#email-send) method in
     * recipients.metadata or global_metadata properties.
     *
     * @return array<string, string>|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * Metadata passed in [email/send](https://docs.unione.io/en/web-api-ref#email-send) method in
     * recipients.metadata or global_metadata properties.
     *
     * @param array<string, string>|null $metadata
     *
     * @return $this
     */
    public function setMetadata(?array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Recipient's email.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Recipient's email.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Email delivery status.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Email delivery status.
     *
     * @param string|null $status Values: `EmailStatus` constants.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getEventTime(): ?string
    {
        return $this->eventTime;
    }

    /**
     * Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setEventTime(?string $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    /**
     * URL for "opened" and "clicked" statuses.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * URL for "opened" and "clicked" statuses.
     *
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Object with detailed delivery info.Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getDeliveryInfo(): ?WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo
    {
        return $this->deliveryInfo;
    }

    /**
     * Object with detailed delivery info.Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setDeliveryInfo(?WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo $deliveryInfo): self
    {
        $this->deliveryInfo = $deliveryInfo;

        return $this;
    }

    /**
     * Spam block date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getBlockTime(): ?string
    {
        return $this->blockTime;
    }

    /**
     * Spam block date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setBlockTime(?string $blockTime): self
    {
        $this->blockTime = $blockTime;

        return $this;
    }

    /**
     * Spam block type, either single or multiple sending SMTP.
     *
     * @return string|null
     */
    public function getBlockType(): ?string
    {
        return $this->blockType;
    }

    /**
     * Spam block type, either single or multiple sending SMTP.
     *
     * @param string|null $blockType Values: `BlockType` constants.
     *
     * @return $this
     */
    public function setBlockType(?string $blockType): self
    {
        $this->blockType = $blockType;

        return $this;
    }

    /**
     * Domain that blocked sending.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Domain that blocked sending.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Number of sending SMTPs blocked.
     */
    public function getSMTPBlocksCount(): ?int
    {
        return $this->sMTPBlocksCount;
    }

    /**
     * Number of sending SMTPs blocked.
     *
     * @return $this
     */
    public function setSMTPBlocksCount(?int $sMTPBlocksCount): self
    {
        $this->sMTPBlocksCount = $sMTPBlocksCount;

        return $this;
    }

    /**
     * Whether it's a block or unblock event.
     *
     * @return string|null
     */
    public function getDomainStatus(): ?string
    {
        return $this->domainStatus;
    }

    /**
     * Whether it's a block or unblock event.
     *
     * @param string|null $domainStatus Values: `DomainStatus` constants.
     *
     * @return $this
     */
    public function setDomainStatus(?string $domainStatus): self
    {
        $this->domainStatus = $domainStatus;

        return $this;
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
            'status' => $this->status,
            'event_time' => $this->eventTime,
            'url' => $this->url,
            'delivery_info' => null === $this->deliveryInfo ? null : Data::object($this->deliveryInfo->toArray()),
            'block_time' => $this->blockTime,
            'block_type' => $this->blockType,
            'domain' => $this->domain,
            'SMTP_blocks_count' => $this->sMTPBlocksCount,
            'domain_status' => $this->domainStatus,
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
