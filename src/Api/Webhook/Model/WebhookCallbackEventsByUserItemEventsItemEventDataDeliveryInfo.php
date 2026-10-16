<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * Object with detailed delivery info.Event date & time in UTC time zone in "YYYY-MM-DD hh:mm:ss" format. This
 * property exists only if webhook has delivery_info proeprty set to 1 and
 * event_name="transactional_email_status".
 */
final class WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo implements \JsonSerializable
{
    public function __construct(
        /**
         * UniOne internal detailed delivery status. Some possible values are:
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
         */
        public ?string $deliveryStatus = null,
        /**
         * SMTP response.
         */
        public ?string $destinationResponse = null,
        /**
         * User agent of recipient. Present only if detected for "clicked" and "opened" statuses.
         * Example: `Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133
         * Safari/537.36`.
         */
        public ?string $userAgent = null,
        /**
         * Recipient's device type, detected from the user agent. Present for "clicked" and "opened" statuses; equals
         * "unknown" if the device type couldn't be detected.
         */
        public DeviceType|string|null $deviceType = null,
        /**
         * Recipient's device brand, detected from the user agent. Present for "clicked" and "opened" statuses if
         * detected. For device_type "mobile" and "tablet" it's always present and equals "unknown" when the brand
         * couldn't be detected.
         * Example: `Apple`.
         */
        public ?string $deviceBrand = null,
        /**
         * Name of the operating system of the recipient's device, detected from the user agent. Present for "clicked"
         * and "opened" statuses; equals "unknown" if the OS couldn't be detected.
         * Example: `GNU/Linux`.
         */
        public ?string $osName = null,
        /**
         * Name of the browser the email was opened in, detected from the user agent. Present for "clicked" and "opened"
         * statuses only if a browser was detected, so it never comes together with email_client_name.
         * Example: `Chrome`.
         */
        public ?string $browserName = null,
        /**
         * Name of the email client application the email was opened in, detected from the user agent. Present for
         * "clicked" and "opened" statuses only if an email client was detected, so it never comes together with
         * browser_name.
         * Example: `Microsoft Outlook`.
         */
        public ?string $emailClientName = null,
        /**
         * Traffic quality for "opened" and "clicked" statuses. "human" means a recognized browser or email client
         * without machine signs; "machine" means a bot, link scanner or security proxy; "protected" means a mailbox/OS
         * privacy proxy where a human action cannot be confirmed (Apple Mail Privacy Protection / iCloud Private Relay,
         * Gmail Image Proxy — Apple MPP is protected, not machine); "unknown" means the user agent is missing, broken or
         * not recognized.
         */
        public TrafficType|string|null $trafficType = null,
        /**
         * Recipient's IP address. Present only if detected for "clicked" and "opened" statuses.
         * Example: `111.222.33.44`.
         */
        public ?string $ip = null,
        /**
         * ISO 3166-1 alpha-2 country code detected from recipient IP. Present for "clicked" and "opened" statuses.
         * Example: `DE`.
         */
        public ?string $countryCode = null,
        /**
         * Country detected from recipient IP. Present for "clicked" and "opened" statuses.
         * Example: `Germany`.
         */
        public ?string $country = null,
        /**
         * City detected from recipient IP. Present for "clicked" and "opened" statuses.
         * Example: `Berlin`.
         */
        public ?string $city = null,
        /**
         * IP address of the SMTP server that sent the message. Present only for "delivered", "soft_bounced" and
         * "hard_bounced" statuses, if available.
         * Example: `192.0.2.10`.
         */
        public ?string $senderIp = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            deliveryStatus: Data::string($data['delivery_status'] ?? null),
            destinationResponse: Data::string($data['destination_response'] ?? null),
            userAgent: Data::string($data['user_agent'] ?? null),
            deviceType: Data::enum(DeviceType::class, Data::string($data['device_type'] ?? null)),
            deviceBrand: Data::string($data['device_brand'] ?? null),
            osName: Data::string($data['os_name'] ?? null),
            browserName: Data::string($data['browser_name'] ?? null),
            emailClientName: Data::string($data['email_client_name'] ?? null),
            trafficType: Data::enum(TrafficType::class, Data::string($data['traffic_type'] ?? null)),
            ip: Data::string($data['ip'] ?? null),
            countryCode: Data::string($data['country_code'] ?? null),
            country: Data::string($data['country'] ?? null),
            city: Data::string($data['city'] ?? null),
            senderIp: Data::string($data['sender_ip'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'delivery_status' => $this->deliveryStatus,
            'destination_response' => $this->destinationResponse,
            'user_agent' => $this->userAgent,
            'device_type' => Data::value($this->deviceType),
            'device_brand' => $this->deviceBrand,
            'os_name' => $this->osName,
            'browser_name' => $this->browserName,
            'email_client_name' => $this->emailClientName,
            'traffic_type' => Data::value($this->trafficType),
            'ip' => $this->ip,
            'country_code' => $this->countryCode,
            'country' => $this->country,
            'city' => $this->city,
            'sender_ip' => $this->senderIp,
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
