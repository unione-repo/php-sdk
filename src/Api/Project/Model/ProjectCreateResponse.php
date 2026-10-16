<?php

declare(strict_types=1);

namespace UniOne\Api\Project\Model;

use UniOne\Client\Data;

/**
 * ProjectCreateResponse
 */
final class ProjectCreateResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Unqiue project identifier, ASCII string up to 36 characters long.
         * Example: `6123462132634`.
         */
        public ?string $projectId = null,
        /**
         * API key of the project. You can use it instead of the user API key parameter in all methods except project/*
         * methods.
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
            status: Data::string($data['status'] ?? null),
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
            'status' => $this->status,
            'project_id' => $this->projectId,
            'project_api_key' => $this->projectApiKey,
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
