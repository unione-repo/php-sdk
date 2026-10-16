<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;

/**
 * ProjectUpdateRequest
 */
final class ProjectUpdateRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Object with project properties.
         */
        public ProjectUpdateObject $project,
        /**
         * Unique project identifier. You should identify project to update either with project_id or with
         * project_api_key field. But we recommend usage of project_id as a more secure option.
         * Example: `1234567890`.
         */
        public ?string $projectId = null,
        /**
         * Optional project API key. You should identify project to update either with project_id or with project_api_key
         * field. But we recommend usage of project_id as a more secure option.
         * Example: `your api_key`.
         */
        public ?string $projectApiKey = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            project: ProjectUpdateObject::fromArray(Data::array($data['project'] ?? null) ?? []),
            projectId: Data::string($data['project_id'] ?? null),
            projectApiKey: Data::string($data['project_api_key'] ?? null),
        );
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
