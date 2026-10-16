<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookCallbackEventsByUserItemEventsItem
 */
final class WebhookCallbackEventsByUserItemEventsItem implements \JsonSerializable
{
    /**
     * Type of event data contained in event_data field, either "transactional_email_status" or
     * "transactional_spam_block".
     * Values: `EventName` constants.
     *
     * @var string|null
     */
    private $eventName;

    /**
     * Object with different event properties depending on "event_name". Below you can see all the properties,
     * "transactional_email_status"-related first and then "transactional_spam_block"-related.
     *
     * @var WebhookCallbackEventsByUserItemEventsItemEventData|null
     */
    private $eventData;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->eventName = Data::string($data['event_name'] ?? null);
        $model->eventData = Data::model(WebhookCallbackEventsByUserItemEventsItemEventData::class, $data['event_data'] ?? null);

        return $model;
    }

    /**
     * Type of event data contained in event_data field, either "transactional_email_status" or
     * "transactional_spam_block".
     *
     * @return string|null
     */
    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    /**
     * Type of event data contained in event_data field, either "transactional_email_status" or
     * "transactional_spam_block".
     *
     * @param string|null $eventName Values: `EventName` constants.
     *
     * @return $this
     */
    public function setEventName(?string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * Object with different event properties depending on "event_name".
     */
    public function getEventData(): ?WebhookCallbackEventsByUserItemEventsItemEventData
    {
        return $this->eventData;
    }

    /**
     * Object with different event properties depending on "event_name".
     *
     * @return $this
     */
    public function setEventData(?WebhookCallbackEventsByUserItemEventsItemEventData $eventData): self
    {
        $this->eventData = $eventData;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'event_name' => $this->eventName,
            'event_data' => null === $this->eventData ? null : Data::object($this->eventData->toArray()),
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
