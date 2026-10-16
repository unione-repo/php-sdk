<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;

/**
 * ProjectCreateRequest
 */
final class ProjectCreateRequest implements \JsonSerializable
{
    /**
     * Object with project properties.
     *
     * @var ProjectObject
     */
    private $project;

    public function __construct(ProjectObject $project)
    {
        $this->project = $project;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(ProjectObject::fromArray(Data::array($data['project'] ?? null) ?? []));
    }

    /**
     * Object with project properties.
     */
    public function getProject(): ProjectObject
    {
        return $this->project;
    }

    /**
     * Object with project properties.
     *
     * @return $this
     */
    public function setProject(ProjectObject $project): self
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
