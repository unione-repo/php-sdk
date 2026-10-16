<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;

/**
 * ProjectCreateResponse
 */
final class ProjectCreateResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Unqiue project identifier, ASCII string up to 36 characters long.
     * Example: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * API key of the project. You can use it instead of the user API key parameter in all methods except project/*
     * methods.
     *
     * @var string|null
     */
    private $projectApiKey;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectApiKey = Data::string($data['project_api_key'] ?? null);

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
     * API key of the project.
     */
    public function getProjectApiKey(): ?string
    {
        return $this->projectApiKey;
    }

    /**
     * API key of the project.
     *
     * @return $this
     */
    public function setProjectApiKey(?string $projectApiKey): self
    {
        $this->projectApiKey = $projectApiKey;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'project_id' => $this->projectId,
            'project_api_key' => $this->projectApiKey,
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
