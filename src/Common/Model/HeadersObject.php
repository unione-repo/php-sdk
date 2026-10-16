<?php

declare(strict_types=1);

namespace UniOne\Common\Model;

use UniOne\Client\Data;

/**
 * Contains email headers, maximum 50. Only headers with “X-” name prefix are accepted, all other are ignored,
 * for example X-UNIONE-Global-Language, X-UNIONE-Template-Engine. Standard headers "To," "CC," and "BCC" are
 * passed without the "X-." Yet, they are processed in a particular way and, as a result, have a number of
 * restrictions. You can find more details about it [here](/cc-and-bcc). If our support have approved omitting
 * standard unsubscription block for you, you can also pass List-Unsubscribe, List-Subscribe, List-Help,
 * List-Owner, List-Archive, In-Reply-To and References headers.
 */
final class HeadersObject implements \JsonSerializable
{
    /**
     * The language of the unsubscribe footer and unsubscribe page. Languages supported are: "be", "de", "en", "es",
     * "fr", "it", "pl", "pt", "ru", "ua", "kz".
     *
     * @var string|null
     */
    private $xUNIONEGlobalLanguage;

    /**
     * The template engine for handling the substitutions(merge tags), “simple”, “velocity”, “liquid” or “none”.
     * Default value is “simple”. Has a priority over the value allowed in the “template_engine” parameter.
     *
     * @var string|null
     */
    private $xUNIONETemplateEngine;

    /**
     * Fields beyond the named ones (any other key of the JSON object): name => value. A named field wins over the
     * same key here.
     *
     * @var array<string, string>
     */
    private $extra = [];

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->xUNIONEGlobalLanguage = Data::string($data['X-UNIONE-Global-Language'] ?? null);
        $model->xUNIONETemplateEngine = Data::string($data['X-UNIONE-Template-Engine'] ?? null);
        $model->extra = Data::extra($data, ['X-UNIONE-Global-Language', 'X-UNIONE-Template-Engine'], static function ($item) { return Data::string($item) ?? ''; });

        return $model;
    }

    /**
     * The language of the unsubscribe footer and unsubscribe page.
     */
    public function getXUNIONEGlobalLanguage(): ?string
    {
        return $this->xUNIONEGlobalLanguage;
    }

    /**
     * The language of the unsubscribe footer and unsubscribe page.
     *
     * @return $this
     */
    public function setXUNIONEGlobalLanguage(?string $xUNIONEGlobalLanguage): self
    {
        $this->xUNIONEGlobalLanguage = $xUNIONEGlobalLanguage;

        return $this;
    }

    /**
     * The template engine for handling the substitutions(merge tags), “simple”, “velocity”, “liquid” or “none”.
     */
    public function getXUNIONETemplateEngine(): ?string
    {
        return $this->xUNIONETemplateEngine;
    }

    /**
     * The template engine for handling the substitutions(merge tags), “simple”, “velocity”, “liquid” or “none”.
     *
     * @return $this
     */
    public function setXUNIONETemplateEngine(?string $xUNIONETemplateEngine): self
    {
        $this->xUNIONETemplateEngine = $xUNIONETemplateEngine;

        return $this;
    }

    /**
     * Fields beyond the named ones (any other key of the JSON object): name => value.
     *
     * @return array<string, string>
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * Sets the fields beyond the named ones: name => value. A named field wins over the same key here.
     *
     * @param array<string, string> $extra
     *
     * @return $this
     */
    public function setExtra(array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'X-UNIONE-Global-Language' => $this->xUNIONEGlobalLanguage,
            'X-UNIONE-Template-Engine' => $this->xUNIONETemplateEngine,
        ], static function ($value): bool {
            return $value !== null;
        }) + $this->extra;
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
