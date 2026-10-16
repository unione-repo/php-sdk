<?php

declare(strict_types=1);

namespace UniOne\Api\Suppression\Model;

use UniOne\Client\Data;

/**
 * SuppressionGetRequest
 */
final class SuppressionGetRequest implements \JsonSerializable
{
    /**
     * Email to get suppression details for.
     * Example: `email@example.com`.
     *
     * @var string
     */
    private $email;

    /**
     * If a user has projects functionality enabled, he/she can pass all_projects=true to search in all projects'
     * data.
     * Default: `False`.
     *
     * @var bool|null
     */
    private $allProjects;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(Data::string($data['email'] ?? null) ?? '');
        $model->allProjects = Data::bool($data['all_projects'] ?? null);

        return $model;
    }

    /**
     * Email to get suppression details for.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Email to get suppression details for.
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * If a user has projects functionality enabled, he/she can pass all_projects=true to search in all projects'
     * data.
     */
    public function getAllProjects(): ?bool
    {
        return $this->allProjects;
    }

    /**
     * If a user has projects functionality enabled, he/she can pass all_projects=true to search in all projects'
     * data.
     *
     * @return $this
     */
    public function setAllProjects(?bool $allProjects): self
    {
        $this->allProjects = $allProjects;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'all_projects' => $this->allProjects,
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
