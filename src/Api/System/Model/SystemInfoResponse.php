<?php

declare(strict_types=1);

namespace UniOne\Api\System\Model;

use UniOne\Client\Data;

/**
 * SystemInfoResponse
 */
final class SystemInfoResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Unique user identifier.
     * Example: `11344`.
     *
     * @var int|null
     */
    private $userId;

    /**
     * Email of the user.
     *
     * @var string|null
     */
    private $email;

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long. Present only if the API key used for request
     * is the project API key.
     * Example: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Project name, unique for user account. Present only if the API key used for request is the project API key.
     * Example: `Project 1A`.
     *
     * @var string|null
     */
    private $projectName;

    /**
     * Object with email counter properties. Present only if the API key used for request is the user API key.
     *
     * @var ProjectAccountingObject|null
     */
    private $projectAccounting;

    /**
     * Object with accounting period properties. Present only if the API key used for request is the user API key.
     *
     * @var SystemInfoResponseAccounting|null
     */
    private $accounting;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->userId = Data::int($data['user_id'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectName = Data::string($data['project_name'] ?? null);
        $model->projectAccounting = Data::model(ProjectAccountingObject::class, $data['project_accounting'] ?? null);
        $model->accounting = Data::model(SystemInfoResponseAccounting::class, $data['accounting'] ?? null);

        return $model;
    }

    /**
     * "success" string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * "success" string
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
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
     * Email of the user.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email of the user.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Project name, unique for user account.
     */
    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    /**
     * Project name, unique for user account.
     *
     * @return $this
     */
    public function setProjectName(?string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Object with email counter properties.
     */
    public function getProjectAccounting(): ?ProjectAccountingObject
    {
        return $this->projectAccounting;
    }

    /**
     * Object with email counter properties.
     *
     * @return $this
     */
    public function setProjectAccounting(?ProjectAccountingObject $projectAccounting): self
    {
        $this->projectAccounting = $projectAccounting;

        return $this;
    }

    /**
     * Object with accounting period properties.
     */
    public function getAccounting(): ?SystemInfoResponseAccounting
    {
        return $this->accounting;
    }

    /**
     * Object with accounting period properties.
     *
     * @return $this
     */
    public function setAccounting(?SystemInfoResponseAccounting $accounting): self
    {
        $this->accounting = $accounting;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'user_id' => $this->userId,
            'email' => $this->email,
            'project_id' => $this->projectId,
            'project_name' => $this->projectName,
            'project_accounting' => null === $this->projectAccounting ? null : Data::object($this->projectAccounting->toArray()),
            'accounting' => null === $this->accounting ? null : Data::object($this->accounting->toArray()),
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
