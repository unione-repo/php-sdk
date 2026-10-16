<?php

declare(strict_types=1);

namespace UniOne\Api\Webhook\Model;

use UniOne\Client\Data;

/**
 * WebhookCallbackEventsByUserItem
 */
final class WebhookCallbackEventsByUserItem implements \JsonSerializable
{
    /**
     * Unique user identifier.
     * Example: `11344`.
     *
     * @var int|null
     */
    private $userId;

    /**
     * Project identifier, present only if webhook was registered for the project using project API key.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Project name, present only if webhook was registered for the project using project API key.
     *
     * @var string|null
     */
    private $projectName;

    /**
     * Array of events reported by webhook.
     *
     * @var list<WebhookCallbackEventsByUserItemEventsItem>|null
     */
    private $events;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->userId = Data::int($data['user_id'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectName = Data::string($data['project_name'] ?? null);
        $model->events = Data::list($data['events'] ?? null, static function ($item) { return WebhookCallbackEventsByUserItemEventsItem::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * Unique user identifier.
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Unique user identifier.
     *
     * @return $this
     */
    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Project identifier, present only if webhook was registered for the project using project API key.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Project identifier, present only if webhook was registered for the project using project API key.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Project name, present only if webhook was registered for the project using project API key.
     */
    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    /**
     * Project name, present only if webhook was registered for the project using project API key.
     *
     * @return $this
     */
    public function setProjectName(?string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Array of events reported by webhook.
     *
     * @return list<WebhookCallbackEventsByUserItemEventsItem>|null
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * Array of events reported by webhook.
     *
     * @param list<WebhookCallbackEventsByUserItemEventsItem>|null $events
     *
     * @return $this
     */
    public function setEvents(?array $events): self
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
            'user_id' => $this->userId,
            'project_id' => $this->projectId,
            'project_name' => $this->projectName,
            'events' => null === $this->events ? null : \array_map(static function (WebhookCallbackEventsByUserItemEventsItem $item) { return Data::object($item->toArray()); }, $this->events),
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
