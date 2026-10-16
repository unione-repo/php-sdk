<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;

/**
 * ProjectUpdateRequest
 */
final class ProjectUpdateRequest implements \JsonSerializable
{
    /**
     * Unique project identifier. You should identify project to update either with project_id or with
     * project_api_key field. But we recommend usage of project_id as a more secure option.
     * Example: `1234567890`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Optional project API key. You should identify project to update either with project_id or with project_api_key
     * field. But we recommend usage of project_id as a more secure option.
     * Example: `your api_key`.
     *
     * @var string|null
     */
    private $projectApiKey;

    /**
     * Object with project properties.
     *
     * @var ProjectUpdateObject
     */
    private $project;

    public function __construct(ProjectUpdateObject $project)
    {
        $this->project = $project;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(ProjectUpdateObject::fromArray(Data::array($data['project'] ?? null) ?? []));
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectApiKey = Data::string($data['project_api_key'] ?? null);

        return $model;
    }

    /**
     * Unique project identifier.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Unique project identifier.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Optional project API key.
     */
    public function getProjectApiKey(): ?string
    {
        return $this->projectApiKey;
    }

    /**
     * Optional project API key.
     *
     * @return $this
     */
    public function setProjectApiKey(?string $projectApiKey): self
    {
        $this->projectApiKey = $projectApiKey;

        return $this;
    }

    /**
     * Object with project properties.
     */
    public function getProject(): ProjectUpdateObject
    {
        return $this->project;
    }

    /**
     * Object with project properties.
     *
     * @return $this
     */
    public function setProject(ProjectUpdateObject $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'project_id' => $this->projectId,
            'project_api_key' => $this->projectApiKey,
            'project' => Data::object($this->project->toArray()),
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
