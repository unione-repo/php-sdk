<?php

declare(strict_types=1);

namespace UniOne\Api\Template\Model;

use UniOne\Client\Data;

/**
 * TemplateListResponse
 */
final class TemplateListResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Array of template objects.
     *
     * @var list<TemplateListObject>|null
     */
    private $templates;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->templates = Data::list($data['templates'] ?? null, static function ($item) { return TemplateListObject::fromArray(Data::array($item) ?? []); });

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
     * Array of template objects.
     *
     * @return list<TemplateListObject>|null
     */
    public function getTemplates(): ?array
    {
        return $this->templates;
    }

    /**
     * Array of template objects.
     *
     * @param list<TemplateListObject>|null $templates
     *
     * @return $this
     */
    public function setTemplates(?array $templates): self
    {
        $this->templates = $templates;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'templates' => null === $this->templates ? null : \array_map(static function (TemplateListObject $item) { return Data::object($item->toArray()); }, $this->templates),
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
