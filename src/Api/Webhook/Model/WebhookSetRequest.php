<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookSetRequest
 */
final class WebhookSetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * URL that will receive the notification when an event occurs. The URL should be unique for a user or a project.
         * Only ASCII characters are supported for now in URL, please convert to
         * [Punycode](https://en.wikipedia.org/wiki/Punycode) if you need to use non-ASCII characters.
         * Example: `https://yourhost.example.com/unione-webhook`.
         */
        public string $url,
        /**
         * Webhook status, "active" by default. "disabled" means that webhook has been disabled by the user, "stopped"
         * means that webhook has been stopped by the system after 24h of failed calls (with minimum of 10 distinct
         * events).
         * Default: `active`.
         */
        public WebhookStatus|string|null $status = null,
        /**
         * Notification format. "json_post"(default) or "json_post_gzip".
         * Default: `json_post`.
         */
        public WebhookEventFormat|string|null $eventFormat = null,
        /**
         * Shall detailed delivery info be returned(1) or not(0). When it's 1, the information about SMTP response and
         * internal delivery status is returned for "hard_bounced" and "soft_bounced" email statuses; the user agent,
         * recipient IP address, detected geo fields, device info detected from the user agent (device type and brand, OS
         * name, browser or email client name) and traffic_type (human, machine, protected or unknown) are returned for
         * "opened" and "clicked" statuses; URL is returned for "clicked" status. For "delivered", "soft_bounced" and
         * "hard_bounced" statuses UniOne may also return sender_ip, the IP address of the SMTP server that sent the
         * message, if available.
         * Allowed values: `0`, `1`.
         * Default: `0`.
         */
        public ?int $deliveryInfo = null,
        /**
         * 0=several event notifications can be reported in single webhook call, 1=only single event can be reported in
         * one call (not recommended).
         * Allowed values: `0`, `1`.
         * Default: `0`.
         */
        public ?int $singleEvent = null,
        /**
         * Maximum quantity of permitted parallel queries to your server. The more your server can handle - the better.
         * Default: `10`.
         */
        public ?int $maxParallel = null,
        /**
         * Object containing events to notify of.
         */
        public ?WebhookEventsObject $events = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: Data::string($data['url'] ?? null) ?? '',
            status: Data::enum(WebhookStatus::class, Data::string($data['status'] ?? null)),
            eventFormat: Data::enum(WebhookEventFormat::class, Data::string($data['event_format'] ?? null)),
            deliveryInfo: Data::int($data['delivery_info'] ?? null),
            singleEvent: Data::int($data['single_event'] ?? null),
            maxParallel: Data::int($data['max_parallel'] ?? null),
            events: Data::model(WebhookEventsObject::class, $data['events'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'url' => $this->url,
            'status' => Data::value($this->status),
            'event_format' => Data::value($this->eventFormat),
            'delivery_info' => $this->deliveryInfo,
            'single_event' => $this->singleEvent,
            'max_parallel' => $this->maxParallel,
            'events' => null === $this->events ? null : Data::object($this->events->toArray()),
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
