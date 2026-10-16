<?php

declare(strict_types=1);

namespace UniOne\Api\Template\Model;

use UniOne\Client\Data;

/**
 * Object with all the properties of the template.
 */
final class TemplateSetRequest implements \JsonSerializable
{
    /**
     * Object with all the template properties.
     *
     * @var TemplateObject
     */
    private $template;

    public function __construct(TemplateObject $template)
    {
        $this->template = $template;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(TemplateObject::fromArray(Data::array($data['template'] ?? null) ?? []));
    }

    /**
     * Object with all the template properties.
     */
    public function getTemplate(): TemplateObject
    {
        return $this->template;
    }

    /**
     * Object with all the template properties.
     *
     * @return $this
     */
    public function setTemplate(TemplateObject $template): self
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
            'template' => Data::object($this->template->toArray()),
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
