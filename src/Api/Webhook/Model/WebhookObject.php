<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * Object with all the webhook properties.
 */
final class WebhookObject implements \JsonSerializable
{
    /**
     * Webhook unique identifier.
     *
     * @var int|null
     */
    private $id;

    /**
     * Webhook URL.
     *
     * @var string|null
     */
    private $url;

    /**
     * Webhook status, "active" by default. "disabled" means that webhook has been disabled by the user, "stopped"
     * means that webhook has been stopped by the system after 24h of failed calls (with minimum of 10 distinct
     * events).
     * Default: `active`.
     * Values: `WebhookStatus` constants.
     *
     * @var string|null
     */
    private $status;

    /**
     * Notification format. "json_post"(default) or "json_post_gzip".
     * Default: `json_post`.
     * Values: `WebhookEventFormat` constants.
     *
     * @var string|null
     */
    private $eventFormat;

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
     *
     * @var int|null
     */
    private $deliveryInfo;

    /**
     * 0=several event notifications can be reported in single webhook call, 1=only single event can be reported in
     * one call (not recommended).
     * Allowed values: `0`, `1`.
     * Default: `0`.
     *
     * @var int|null
     */
    private $singleEvent;

    /**
     * Maximum quantity of permitted parallel queries to your server. The more your server can handle - the better.
     * Default: `10`.
     *
     * @var int|null
     */
    private $maxParallel;

    /**
     * Webhook properties last update date and time in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @var string|null
     */
    private $updatedAt;

    /**
     * Object containing events to notify of.
     *
     * @var WebhookEventsObject|null
     */
    private $events;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->id = Data::int($data['id'] ?? null);
        $model->url = Data::string($data['url'] ?? null);
        $model->status = Data::string($data['status'] ?? null);
        $model->eventFormat = Data::string($data['event_format'] ?? null);
        $model->deliveryInfo = Data::int($data['delivery_info'] ?? null);
        $model->singleEvent = Data::int($data['single_event'] ?? null);
        $model->maxParallel = Data::int($data['max_parallel'] ?? null);
        $model->updatedAt = Data::string($data['updated_at'] ?? null);
        $model->events = Data::model(WebhookEventsObject::class, $data['events'] ?? null);

        return $model;
    }

    /**
     * Webhook unique identifier.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Webhook unique identifier.
     *
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Webhook URL.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Webhook URL.
     *
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Webhook status, "active" by default. "disabled" means that webhook has been disabled by the user, "stopped"
     * means that webhook has been stopped by the system after 24h of failed calls (with minimum of 10 distinct
     * events).
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Webhook status, "active" by default. "disabled" means that webhook has been disabled by the user, "stopped"
     * means that webhook has been stopped by the system after 24h of failed calls (with minimum of 10 distinct
     * events).
     *
     * @param string|null $status Values: `WebhookStatus` constants.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Notification format. "json_post"(default) or "json_post_gzip".
     *
     * @return string|null
     */
    public function getEventFormat(): ?string
    {
        return $this->eventFormat;
    }

    /**
     * Notification format. "json_post"(default) or "json_post_gzip".
     *
     * @param string|null $eventFormat Values: `WebhookEventFormat` constants.
     *
     * @return $this
     */
    public function setEventFormat(?string $eventFormat): self
    {
        $this->eventFormat = $eventFormat;

        return $this;
    }

    /**
     * Shall detailed delivery info be returned(1) or not(0).
     */
    public function getDeliveryInfo(): ?int
    {
        return $this->deliveryInfo;
    }

    /**
     * Shall detailed delivery info be returned(1) or not(0).
     *
     * @return $this
     */
    public function setDeliveryInfo(?int $deliveryInfo): self
    {
        $this->deliveryInfo = $deliveryInfo;

        return $this;
    }

    /**
     * 0=several event notifications can be reported in single webhook call, 1=only single event can be reported in
     * one call (not recommended).
     */
    public function getSingleEvent(): ?int
    {
        return $this->singleEvent;
    }

    /**
     * 0=several event notifications can be reported in single webhook call, 1=only single event can be reported in
     * one call (not recommended).
     *
     * @return $this
     */
    public function setSingleEvent(?int $singleEvent): self
    {
        $this->singleEvent = $singleEvent;

        return $this;
    }

    /**
     * Maximum quantity of permitted parallel queries to your server.
     */
    public function getMaxParallel(): ?int
    {
        return $this->maxParallel;
    }

    /**
     * Maximum quantity of permitted parallel queries to your server.
     *
     * @return $this
     */
    public function setMaxParallel(?int $maxParallel): self
    {
        $this->maxParallel = $maxParallel;

        return $this;
    }

    /**
     * Webhook properties last update date and time in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Webhook properties last update date and time in UTC timezone in "YYYY-MM-DD hh:mm:ss" format.
     *
     * @return $this
     */
    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Object containing events to notify of.
     */
    public function getEvents(): ?WebhookEventsObject
    {
        return $this->events;
    }

    /**
     * Object containing events to notify of.
     *
     * @return $this
     */
    public function setEvents(?WebhookEventsObject $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'url' => $this->url,
            'status' => $this->status,
            'event_format' => $this->eventFormat,
            'delivery_info' => $this->deliveryInfo,
            'single_event' => $this->singleEvent,
            'max_parallel' => $this->maxParallel,
            'updated_at' => $this->updatedAt,
            'events' => null === $this->events ? null : Data::object($this->events->toArray()),
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
