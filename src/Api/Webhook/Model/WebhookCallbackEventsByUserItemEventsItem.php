<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookCallbackEventsByUserItemEventsItem
 */
final class WebhookCallbackEventsByUserItemEventsItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Type of event data contained in event_data field, either "transactional_email_status" or
         * "transactional_spam_block".
         */
        public EventName|string|null $eventName = null,
        /**
         * Object with different event properties depending on "event_name". Below you can see all the properties,
         * "transactional_email_status"-related first and then "transactional_spam_block"-related.
         */
        public ?WebhookCallbackEventsByUserItemEventsItemEventData $eventData = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            eventName: Data::enum(EventName::class, Data::string($data['event_name'] ?? null)),
            eventData: Data::model(WebhookCallbackEventsByUserItemEventsItemEventData::class, $data['event_data'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'event_name' => Data::value($this->eventName),
            'event_data' => null === $this->eventData ? null : Data::object($this->eventData->toArray()),
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
