<?php

declare(strict_types=1);

namespace UniOne\Api\System\Model;

use UniOne\Client\Data;

/**
 * SystemInfoResponse
 */
final class SystemInfoResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * "success" string
         * Allowed values: `success`.
         */
        public ?string $status = null,
        /**
         * Unique user identifier.
         * Example: `11344`.
         */
        public ?int $userId = null,
        /**
         * Email of the user.
         */
        public ?string $email = null,
        /**
         * Unqiue project identifier, ASCII string up to 36 characters long. Present only if the API key used for request
         * is the project API key.
         * Example: `6123462132634`.
         */
        public ?string $projectId = null,
        /**
         * Project name, unique for user account. Present only if the API key used for request is the project API key.
         * Example: `Project 1A`.
         */
        public ?string $projectName = null,
        /**
         * Object with email counter properties. Present only if the API key used for request is the user API key.
         */
        public ?ProjectAccountingObject $projectAccounting = null,
        /**
         * Object with accounting period properties. Present only if the API key used for request is the user API key.
         */
        public ?SystemInfoResponseAccounting $accounting = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            userId: Data::int($data['user_id'] ?? null),
            email: Data::string($data['email'] ?? null),
            projectId: Data::string($data['project_id'] ?? null),
            projectName: Data::string($data['project_name'] ?? null),
            projectAccounting: Data::model(ProjectAccountingObject::class, $data['project_accounting'] ?? null),
            accounting: Data::model(SystemInfoResponseAccounting::class, $data['accounting'] ?? null),
        );
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
