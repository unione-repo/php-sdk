<?php

declare(strict_types=1);

namespace UniOne\Api\Template\Model;

use UniOne\Client\Data;

/**
 * TemplateSetResponse
 */
final class TemplateSetResponse implements \JsonSerializable
{
    /**
     * "success" string
     * Allowed values: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Object with all the template properties.
     *
     * @var TemplateObject|null
     */
    private $template;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->template = Data::model(TemplateObject::class, $data['template'] ?? null);

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
     * Object with all the template properties.
     */
    public function getTemplate(): ?TemplateObject
    {
        return $this->template;
    }

    /**
     * Object with all the template properties.
     *
     * @return $this
     */
    public function setTemplate(?TemplateObject $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'template' => null === $this->template ? null : Data::object($this->template->toArray()),
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
