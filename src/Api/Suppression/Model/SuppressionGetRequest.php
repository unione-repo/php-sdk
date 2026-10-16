<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionGetRequest
 */
final class SuppressionGetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Email to get suppression details for.
         * Example: `email@example.com`.
         */
        public string $email,
        /**
         * If a user has projects functionality enabled, he/she can pass all_projects=true to search in all projects'
         * data.
         * Default: `False`.
         */
        public ?bool $allProjects = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Data::string($data['email'] ?? null) ?? '',
            allProjects: Data::bool($data['all_projects'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'all_projects' => $this->allProjects,
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
