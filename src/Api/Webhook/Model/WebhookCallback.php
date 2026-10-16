<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * Webhook callback format description.
 */
final class WebhookCallback implements \JsonSerializable
{
    /**
     * MD5-hash of the message body, in which the value "auth" is replaced by api key of the user/project; with this
     * field the recipient of the notification can both authenticate and verify the notification integrity
     *
     * @var string|null
     */
    private $auth;

    /**
     * Array with only one element, containing events of a user/project.
     *
     * @var list<WebhookCallbackEventsByUserItem>|null
     */
    private $eventsByUser;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->auth = Data::string($data['auth'] ?? null);
        $model->eventsByUser = Data::list($data['events_by_user'] ?? null, static function ($item) { return WebhookCallbackEventsByUserItem::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * MD5-hash of the message body, in which the value "auth" is replaced by api key of the user/project; with this
     * field the recipient of the notification can both authenticate and verify the notification integrity
     */
    public function getAuth(): ?string
    {
        return $this->auth;
    }

    /**
     * MD5-hash of the message body, in which the value "auth" is replaced by api key of the user/project; with this
     * field the recipient of the notification can both authenticate and verify the notification integrity
     *
     * @return $this
     */
    public function setAuth(?string $auth): self
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Array with only one element, containing events of a user/project.
     *
     * @return list<WebhookCallbackEventsByUserItem>|null
     */
    public function getEventsByUser(): ?array
    {
        return $this->eventsByUser;
    }

    /**
     * Array with only one element, containing events of a user/project.
     *
     * @param list<WebhookCallbackEventsByUserItem>|null $eventsByUser
     *
     * @return $this
     */
    public function setEventsByUser(?array $eventsByUser): self
    {
        $this->eventsByUser = $eventsByUser;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'auth' => $this->auth,
            'events_by_user' => null === $this->eventsByUser ? null : \array_map(static function (WebhookCallbackEventsByUserItem $item) { return Data::object($item->toArray()); }, $this->eventsByUser),
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
