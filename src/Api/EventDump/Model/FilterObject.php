<?php

declare(strict_types=1);

namespace UniOne\Api\EventDump\Model;

use UniOne\Client\Data;
use UniOne\Common\Model\EmailStatus;

/**
 * An object with the properties of the event dump filter.
 */
final class FilterObject implements \JsonSerializable
{
    /**
     * Job identifier returned earlier by [email/send](https://docs.unione.io/en/web-api-ref#email-send) method.
     * Example: `1ZymBc-00041N-9X`.
     *
     * @var string|null
     */
    private $jobId;

    /**
     * Email status. Possible values are:
     *
     * __accepted__ — the message has been accepted, but not sent yet.
     * __sent__ — the message has been sent, but not delivered yet.
     * __delivered__ — the message has been delivered.
     * __opened__ — the message has been delivered and read.
     * __clicked__ — the message has been delivered, read, and at least one of the links in email has been clicked.
     * __unsubscribed__ — the message has been delivered to the recipient and read, but then the recipient
     * unsubscribed.
     * __subscribed__ — the message has been delivered to the recipient and read, but then the recipient unsubscribed
     * and subscribed again.
     * __soft_bounced__ — temporary delivery failure. UniOne will try to deliver the message during 48 hours.
     * __hard_bounced__ — failed to deliver the message, there will be no delivery attempts.
     * __spam__ — the message has been delivered, but it was reported as spam by the recipient.
     * Values: `EmailStatus` constants.
     *
     * @var string|null
     */
    private $status;

    /**
     * UniOne internal detailed delivery status, you can pass several values at once, comma-separated. Some possible
     * values are:
     *
     * __err_user_unknown__ -- email address doesn't exist;
     * __err_user_inactive__ -- email address isn't used anymore;
     * __err_will_retry__ -- email was temporary rejected, delivery will be retried later;
     * __err_mailbox_discarded__ -- email address was active earlier, but now it's deleted;
     * __err_mailbox_full__ -- mailbox is full;
     * __err_spam_rejected__ -- email was rejected as a spam;
     * __err_blacklisted__ -- email was rejected because sender IP or sender domain is found in a black list;
     * __err_too_large__ -- email size is over limit, according to recipient's server;
     * __err_unsubscribed__ -- email was unsubscribed;
     * __err_unreachable__ -- numerous delivery failures lead to mark this email address as permanently unavailable;
     * __err_skip_letter__ -- sending has been canceled because the email address is temporarily unavailable;
     * __err_domain_inactive__ -- the domain does not accept mail or does not exist;
     * __err_destination_misconfigured__ -- the domain does not accept mail due to incorrect settings on the
     * recipient’s side, and the server’s response contains information about a cause that can be fixed (for example,
     * an inoperative blacklist is used, etc.);
     * __err_delivery_failed__ -- delivery failed due to other reasons;
     * __err_spam_skipped__ -- sending has been canceled because the campaign has been blocked as a spam;
     * __err_lost__ -- the message was not sent due to inconsistency of its parts or it has been lost because of the
     * failure on our side. The sender needs to re-send the letter on his own, since the original has not been saved;
     *
     * We reserve the right to change or add internal delivery statuses as we need, so the following list is provided
     * as an example only, without any description: ok_sent, ok_delivered, ok_read, ok_link_visited, ok_unsubscribed,
     * ok_resubscribed, ok_spam_folder, ok_fbl, not_sent, skip_dup_unreachable, skip_dup_temp_unreachable,
     * skip_dup_mailbox_full, err_spam_removed, err_resend, err_unknown, err_retry_letter, err_src_invalid,
     * err_dest_invalid, err_not_available, err_internal, err_no_dns, err_no_smtp, err_giveup.
     *
     * @var string|null
     */
    private $deliveryStatus;

    /**
     * Recipient email address
     * Example: `david@example.org`.
     *
     * @var string|null
     */
    private $email;

    /**
     * Sender email address
     * Example: `sender@example.com`.
     *
     * @var string|null
     */
    private $emailFrom;

    /**
     * Recipient domain
     * Example: `example.org`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Campaign identifier, unsigned decimal integer or UUID up to 128-bit, passed in metadata with name
     * "campaign_id" (name is configurable thru support).
     * Example: `c77f4f4e-3561-49f7-9f07-c35be01b4f43`.
     *
     * @var string|null
     */
    private $campaignId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->jobId = Data::string($data['job_id'] ?? null);
        $model->status = Data::string($data['status'] ?? null);
        $model->deliveryStatus = Data::string($data['delivery_status'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->emailFrom = Data::string($data['email_from'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->campaignId = Data::string($data['campaign_id'] ?? null);

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
     * Email status.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Email status.
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
     * UniOne internal detailed delivery status, you can pass several values at once, comma-separated.
     */
    public function getDeliveryStatus(): ?string
    {
        return $this->deliveryStatus;
    }

    /**
     * UniOne internal detailed delivery status, you can pass several values at once, comma-separated.
     *
     * @return $this
     */
    public function setDeliveryStatus(?string $deliveryStatus): self
    {
        $this->deliveryStatus = $deliveryStatus;

        return $this;
    }

    /**
     * Recipient email address
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Recipient email address
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Sender email address
     */
    public function getEmailFrom(): ?string
    {
        return $this->emailFrom;
    }

    /**
     * Sender email address
     *
     * @return $this
     */
    public function setEmailFrom(?string $emailFrom): self
    {
        $this->emailFrom = $emailFrom;

        return $this;
    }

    /**
     * Recipient domain
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Recipient domain
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Campaign identifier, unsigned decimal integer or UUID up to 128-bit, passed in metadata with name
     * "campaign_id" (name is configurable thru support).
     */
    public function getCampaignId(): ?string
    {
        return $this->campaignId;
    }

    /**
     * Campaign identifier, unsigned decimal integer or UUID up to 128-bit, passed in metadata with name
     * "campaign_id" (name is configurable thru support).
     *
     * @return $this
     */
    public function setCampaignId(?string $campaignId): self
    {
        $this->campaignId = $campaignId;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'job_id' => $this->jobId,
            'status' => $this->status,
            'delivery_status' => $this->deliveryStatus,
            'email' => $this->email,
            'email_from' => $this->emailFrom,
            'domain' => $this->domain,
            'campaign_id' => $this->campaignId,
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
