<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * Webhook callback format description.
 */
final class WebhookCallback implements \JsonSerializable
{
    public function __construct(
        /**
         * MD5-hash of the message body, in which the value "auth" is replaced by api key of the user/project; with this
         * field the recipient of the notification can both authenticate and verify the notification integrity
         */
        public ?string $auth = null,
        /**
         * Array with only one element, containing events of a user/project.
         * @var list<WebhookCallbackEventsByUserItem>|null
         */
        public ?array $eventsByUser = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            auth: Data::string($data['auth'] ?? null),
            eventsByUser: Data::list($data['events_by_user'] ?? null, static fn ($item) => WebhookCallbackEventsByUserItem::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'auth' => $this->auth,
            'events_by_user' => null === $this->eventsByUser ? null : \array_map(static fn (WebhookCallbackEventsByUserItem $item) => Data::object($item->toArray()), $this->eventsByUser),
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
